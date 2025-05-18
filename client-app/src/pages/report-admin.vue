<script setup>
import api from '@/plugins/axios'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import { onMounted, ref } from 'vue'

const header = [
  { title: 'No', key: 'number' },
  { title: 'Judul', key: 'title' },
  { title: 'Pelapor', key: 'langkah' },
  { title: 'Penyelesai', key: 'hasil' },
  { title: 'Kategori Masalah', key: 'kategori' },
  { title: 'Komentar', key: 'komen' },
  { title: 'Waktu', key: 'tanggal' },
  { title: 'Status', key: 'status' },
  { title: 'Hapus', key: 'hapus' },
]

const incidents = ref([])
const showDialog = ref(false)
const selectedIncident = ref(null)

const form = ref({
  status: '',
})

onMounted(async () => {
  await fetchIncidents()
})

const fetchIncidents = async () => {
  try {
    const response = await api.get('https://www.kuliah-oskhar.my.id/api/v1/incident?length=1000')
    const incidentData = response.data?.[0]?.data?.data || []

    incidents.value = incidentData.map((item, index) => ({
      id: item.id,
      number: index + 1,
      title: item.subject || '-',
      langkah: item.reporter?.name || '-',
      hasil: item.resolver?.name || '-',
      kategori: item.categories?.[0]?.name || '-',
      komen: item.comment || '-',
      tanggal: item.created_at || '-',
      status: item.status || 'Dikirim',
    }))
  } catch (error) {
    console.error('Gagal mengambil data incident:', error)
  }
}

const viewIncident = item => {
  selectedIncident.value = item
  form.value.status = item.status
  showDialog.value = true
}

const closeDialog = () => {
  showDialog.value = false
  selectedIncident.value = null
  form.value.status = ''
}

const deleteIncident = async item => {
  if (!confirm(`Yakin ingin menghapus incident "${item.title}"?`)) return

  try {
    await api.delete(`https://www.kuliah-oskhar.my.id/api/v1/incident/${item.id}`)
    await fetchIncidents()
  } catch (error) {
    console.error('Gagal menghapus incident:', error)
  }
}

const saveIncident = async () => {
  if (!selectedIncident.value) return

  try {
    const id = selectedIncident.value.id

    const dataToSend = {
      status: form.value.status,
    }

    await api.put(`https://www.kuliah-oskhar.my.id/api/v1/incident/status/${id}`, dataToSend)

    await fetchIncidents()
    closeDialog()
  } catch (error) {
    console.error('Gagal menyimpan perubahan:', error)
  }
}

// Cetak PDF
const printPDF = () => {
  const doc = new jsPDF()

  const tableColumn = [
    'No',
    'Judul',
    'Pelapor',
    'Penyelesai',
    'Kategori',
    'Komentar',
    'Waktu',
    'Status',
  ]

  const tableRows = incidents.value.map(item => [
    item.number,
    item.title,
    item.langkah,
    item.hasil,
    item.kategori,
    item.komen,
    item.tanggal,
    item.status,
  ])

  autoTable(doc, {
    head: [tableColumn],
    body: tableRows,
    styles: { fontSize: 8 },
    headStyles: { fillColor: [220, 53, 69] }, // merah
    margin: { top: 20 },
  })

  doc.save('laporan-insiden.pdf')
}
</script>

<template>
  <VCard>
    <VDataTable
      :headers="header"
      :items="incidents"
      class="elevation-1"
    >
      <template #item.status="{ item }">
        <span
          style="color: blue; cursor: pointer; text-decoration: underline;"
          @click="viewIncident(item)"
        >
          {{ item.status }}
        </span>
      </template>

      <template #item.hapus="{ item }">
        <VBtn
          icon
          @click="deleteIncident(item)"
        >
          <VIcon>bx-trash</VIcon>
        </VBtn>
      </template>
    </VDataTable>

    <div class="d-flex justify-end me-4 mb-4 mt-4">
      <VBtn
        color="error"
        class="mb-4"
        @click="printPDF"
      >
        Cetak PDF
      </VBtn>
    </div>
  </VCard>

  <VDialog
    v-model="showDialog"
    max-width="600px"
  >
    <VCard>
      <VCardTitle>Ubah Status</VCardTitle>
      <VCardText>
        <VForm @submit.prevent="saveIncident">
          <VSelect
            v-model="form.status"
            label="Status"
            :items="['dikirim', 'selesai']"
            required
          />
        </VForm>
      </VCardText>
      <VCardActions>
        <VSpacer />
        <VBtn
          text
          @click="closeDialog"
        >
          Tutup
        </VBtn>
        <VBtn
          color="primary"
          @click="saveIncident"
        >
          Simpan
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>
