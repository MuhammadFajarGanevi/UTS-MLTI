<script setup>
import api from '@/plugins/axios'
import { onMounted, ref } from 'vue'

const header = [
  { title: 'No', key: 'number' },
  { title: 'Judul', key: 'title' },
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

// Tambahkan opsi status
const statusOptions = [
  { label: 'submitted', value: 'submitted' },
  { label: 'in progress', value: 'in_progress' },
  { label: 'resolved', value: 'resolved' },
]

onMounted(async () => {
  await fetchProblem()
})

const fetchProblem = async () => {
  try {
    const response = await api.get('https://www.kuliah-oskhar.my.id/api/v1/incident?length=1000')
    const incidentData = response.data?.[0]?.data?.data

    console.log(incidentData)

    incidents.value = incidentData.map((item, index) => ({
      number: index + 1,
      id: item.id,
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
  form.value.status = item.status // ⬅️ isi v-model dengan status saat ini
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
    await fetchProblem() // ⬅️ fix: fetchProblem bukan fetchIncidents
  } catch (error) {
    console.error('Gagal menghapus incident:', error)
  }
}

const saveIncident = async () => {
  if (!selectedIncident.value) return

  try {
    const id = selectedIncident.value.id

    const dataToSend = {
      status: form.value.status, // ⬅️ hasil akhir akan seperti { "status": "closed" }
    }

    console.log(dataToSend)

    await api.put(`https://www.kuliah-oskhar.my.id/api/v1/incident/status/${id}`, dataToSend)

    await fetchProblem() // refresh data
    closeDialog()
  } catch (error) {
    console.error('Gagal menyimpan perubahan:', error)
  }
}
</script>

<template>
  <VCard>
    <VCardTitle>
      Laporan Insiden
    </VCardTitle>
    <VDataTable
      :headers="header"
      :items="incidents"
      class="elevation-1"
    >
      <template #item.status="{ item }">
        <span
          style=" color: blue;cursor: pointer; text-decoration: underline;"
          @click="viewIncident(item)"
        >
          {{ item.status }}
        </span>
      </template>

      <template #item.hapus="{ item }">
        <VBtn
          icon
          color="error"
          @click="deleteIncident(item)"
        >
          <VIcon>
            bx-x
          </VIcon>
        </VBtn>
      </template>
    </VDataTable>
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
            :items="statusOptions"
            label="Status Masalah"
            item-title="label"
            item-value="value"
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
