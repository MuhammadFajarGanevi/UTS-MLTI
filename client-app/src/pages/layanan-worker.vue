<script setup>
import api from '@/plugins/axios'
import { onMounted, ref } from 'vue'

const header = [
  { title: 'No', key: 'number' },
  { title: 'Judul', key: 'subject' },
  { title: 'Deskripsi', key: 'description' },
  { title: 'Comment', key: 'comment' },
  { title: 'PIC', key: 'pic' },
  { title: 'Kategori', key: 'kategori' },
  { title: 'Tanggal', key: 'created_at' },
  { title: 'Status', key: 'status' },
  { title: 'edit', key: 'edit' },
]

const incidents = ref([])
const showDialog = ref(false)
const selectedIncident = ref(null)

const form = ref({
  comment: '', // tambahkan ini
})

onMounted(async () => {
  await fetchIncidents()
})

const fetchIncidents = async () => {
  try {
    const response = await api.get('https://www.kuliah-oskhar.my.id/api/v1/request-service?length=1000')
    const incidentData = response.data?.[0]?.data?.data || []

    incidents.value = incidentData.map((item, index) => ({
      number: index + 1,
      id: item.id,
      subject: item.subject || '-',
      description: item.description || '-',
      comment: item.comment || '-',
      pic: item.personInControl?.name || '-',
      kategori: item.categories?.[0]?.name || '-',
      created_at: item.created_at?.split('T')[0] || '-',
      status: item.status || '-',
      
    }))
  } catch (error) {
    console.error('Gagal mengambil data incident:', error)
  }
}

const viewIncident = item => {
  selectedIncident.value = item
  form.value.comment = item.komen // ambil dari field yang ditampilkan
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
    await api.delete(`https://www.kuliah-oskhar.my.id/api/v1/request-service/${item.id}`)
    await fetchIncidents() // Refresh data setelah delete
  } catch (error) {
    console.error('Gagal menghapus incident:', error)
  }
}

const saveIncident = async () => {
  if (!selectedIncident.value) return

  try {
    const id = selectedIncident.value.id

    const dataToSend = {
      comment: form.value.comment,
    }

    console.log(dataToSend)

    await api.put(`https://www.kuliah-oskhar.my.id/api/v1/request-service/worker/${id}`, dataToSend)

    await fetchIncidents()
    closeDialog()
  } catch (error) {
    console.error('Gagal menyimpan perubahan:', error)
  }
}
</script>

<template>
  <VCard>
    <VCardTitle>
      Permintaan Layanan
    </VCardTitle>
    <VDataTable
      :headers="header"
      :items="incidents"
      class="elevation-1"
    >
      <!--
        <template #item.status="{item}">
        <span
        style=" color: blue;cursor: pointer; text-decoration: underline;"
        @click="viewIncident(item)"
        >
        {{ item.status }}
        </span>
        </template> 
      -->
      
      <template #item.edit="{ item }">
        <VBtn
          icon
          @click="viewIncident(item)"
        >
          <VIcon>
            bx-pencil
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
      <VCardTitle>beri komentar</VCardTitle>
      <VCardText>
        <VForm @submit.prevent="saveIncident">
          <!--
            <VSelect
            v-model="form.status"
            label="Status"
            :items="[
            'submitted', 'in_progress','resolved'
            ]"
            required
            /> 
          -->
          <VTextField
            v-model="form.comment"
            placeholder="Masukkan komentar"
            variant="outlined"
            hide-details
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
