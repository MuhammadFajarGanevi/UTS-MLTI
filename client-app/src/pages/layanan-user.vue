<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router' // ⬅️ Tambahkan ini
import axios from '@/plugins/axios'

const router = useRouter() // ⬅️ Tambahkan ini

const headers = [
  { title: 'No', key: 'number' },
  { title: 'Judul', key: 'subject' },
  { title: 'Deskripsi', key: 'description' },
  { title: 'Manfaat', key: 'content' },
  { title: 'Alternatif', key: 'alternatif' },
  { title: 'PIC', key: 'pic' },
  { title: 'Kategori', key: 'kategori' },
  { title: 'Tanggal', key: 'created_at' },
  { title: 'Status', key: 'status' },
]

const layanan = ref([])

onMounted(async () => {
  try {
    const response = await axios.get('/request-service?length=1000')

    console.log('RAW response:', response.data)

    const raw = response.data[0]

    if (raw && raw.status && raw.data?.data) {
      layanan.value = raw.data.data.map((item, index) => ({
        number: index + 1,
        subject: item.subject || '-',
        description: item.description || '-',
        content: item.content || '-',
        alternatif: '-', // tidak ada di API
        pic: item.pic?.name || '-',
        kategori: item.categories?.[0]?.name || '-',
        created_at: item.created_at?.split('T')[0] || '-',
        status: item.status || '-',
      }))
    } else {
      console.warn('Response tidak sesuai format yang diharapkan:', raw)
    }
  } catch (err) {
    console.error('Gagal mengambil data layanan:', err)
  }
})
</script>


<template>
  <VCard>
    <VCardTitle>
      Permintaan Layanan
    </VCardTitle>

    <VDataTable
      :headers="headers"
      :items="layanan"
      class="elevation-1"
    />

    <div class="d-flex justify-end me-4 mb-4 mt-4">
      <VBtn
        color="primary"
        class="mb-4"
        @click="router.push('/laporan-layanan')"
      >
        + Tambah Permintaan
      </VBtn>
    </div>
  </VCard>
</template>
