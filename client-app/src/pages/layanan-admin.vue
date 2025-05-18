<script setup>
const header=[
  { title: 'No', key: 'number' },
  { title: 'Judul', key: 'title' },
  { title: 'Deskripsi', key: 'deskripsi' },
  { title: 'Manfaat', key: 'manfaat' },
  { title: 'Alternatif', key: 'alternatif' },
  { title: 'Hasil', key: 'hasil' },
  { title: 'Modifikasi', key: 'modifikasi' },
  { title: 'Waktu', key: 'tanggal' },
  { title: 'Status', key: 'status' },
  { title: 'Komentar', key: 'komen' },
]

// const isi =[
//   { number: '1',
//     title: 'coba',
//     keterangan: 'coba2',
//     langkah: 'bismillah',
//     hasil: 'alhamdulillah',
//     kategori: 'insiden bug',
//     modifikasi: 'cobakosong',
//     tanggal: '22-10-2024',
//     status: 'dibaca',
//     komen: 'buat percobaan',
//   },
// ]
</script>

<template>
  <VCard>
    <VCardTitle>
      Permintaan Layanan
    </VCardTitle>
    <VDataTable
      :headers="header"
      :items="isi"
      class="elevation-1"
    />
    <VSpacer class="mb-10" />
    <div class="d-flex justify-end me-4 mb-4">
      <VBtn
        color="error"
        @click="$router.push('/laporan-layanan')"
      >
        Cetak PDF
      </VBtn>
    </div>
  </VCard>
</template>
<!-- 
  <style scoped>

  </style> 
-->
