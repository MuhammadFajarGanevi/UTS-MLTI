<script setup>
import api from '@/plugins/axios'
import { onMounted, ref } from 'vue'

const header = [
  { title: 'No', key: 'number' },
  { title: 'Judul', key: 'title' },
  { title: 'Deskripsi', key: 'description' },
  { title: 'pelapor', key: 'langkah' },
  { title: 'Penanggungjawab', key: 'hasil' },
  { title: 'Kategori Masalah', key: 'kategori' },
  { title: 'Komentar', key: 'komen' },
  { title: 'Waktu', key: 'tanggal' },
  { title: 'Status', key: 'status' },
]

const incidents = ref([])

onMounted(async () => {
  try {
    const response = await api.get('https://www.kuliah-oskhar.my.id/api/v1/problem?length=1000')
    const incidentData = response.data?.[0]?.data?.data

    console.log(incidentData)

    incidents.value = incidentData.map((item, index) => ({
      number: index + 1,
      title: item.subject || '-',
      description: item.description || '-',
      langkah: item.reporter?.name || '-',

      hasil: item.personInControl?.name || '-',
      kategori: item.categories?.[0]?.name || '-',
      komen: item.comment || '-',
      tanggal: item.created_at || '-',
      status: item.status || 'Dikirim',
    }))
  } catch (error) {
    console.error('Gagal mengambil data incident:', error)
  }
})
</script>

<template>
  <VCard>
    <VCardTitle>
      Laporan Masalah
    </VCardTitle>
    <VDataTable
      :headers="header"
      :items="incidents"
      class="elevation-1"
    />
    <VSpacer class="mb-10" />
    <div class="d-flex justify-end me-4 mb-4">
      <VBtn
        color="primary"
        to="/laporan-masalah"
      >
        Tambah
      </VBtn>
    </div>
  </VCard>
</template>
