<script setup>
import axios from '@/plugins/axios'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import { onMounted, ref } from 'vue'

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
  { title: 'Hapus', key: 'hapus' },
]

const layanan = ref([])

onMounted(async () => {
  await fetchLayanan()
})

const fetchLayanan = async () => {
  try {
    const response = await axios.get('/request-service?length=1000')
    const raw = response.data[0]

    if (raw && raw.status && raw.data?.data) {
      layanan.value = raw.data.data.map((item, index) => ({
        id: item.id,
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
}

const deleteLayanan = async item => {
  if (!confirm(`Yakin ingin menghapus layanan "${item.subject}"?`)) return

  try {
    await axios.delete(`/request-service/${item.id}`)
    await fetchLayanan()
  } catch (error) {
    console.error('Gagal menghapus layanan:', error)
  }
}

const printPDF = () => {
  const doc = new jsPDF()

  const tableColumn = [
    'No',
    'Judul',
    'Deskripsi',
    'Manfaat',
    'Alternatif',
    'PIC',
    'Kategori',
    'Tanggal',
    'Status',
  ]

  const tableRows = layanan.value.map(item => [
    item.number,
    item.subject,
    item.description,
    item.content,
    item.alternatif,
    item.pic,
    item.kategori,
    item.created_at,
    item.status,
  ])

  autoTable(doc, {
    head: [tableColumn],
    body: tableRows,
    styles: { fontSize: 8 },
    headStyles: { fillColor: [220, 53, 69] }, // warna merah
    margin: { top: 20 },
  })

  doc.save('laporan-layanan.pdf')
}
</script>

<template>
  <VCard>
    <VCardTitle>
      Permintaan Layanan Admin
    </VCardTitle>

    <VDataTable
      :headers="headers"
      :items="layanan"
      class="elevation-1"
    >
      <template #item.hapus="{ item }">
        <VBtn
          icon
          @click="deleteLayanan(item)"
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
</template>
