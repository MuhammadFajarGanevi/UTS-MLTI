<script setup>
import { useLaporanStore } from '@/store/laporan-store'

const laporanStore = useLaporanStore()

const header = [
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

const incidents = ref([
  {
    number: '1',
    title: 'Kebakaran Ringan',
    keterangan: 'Kebakaran kecil di gudang B.',
    tanggal: '2025-05-10',
  },
  {
    number: '2',
    title: 'Tumpahan Bahan Kimia',
    keterangan: 'Tumpahan di area lab lantai 2.',
    tanggal: '2025-05-09',
  },
])

// Konversi data dari store ke struktur tabel
const isi = laporanStore.daftarLaporan.map((item, index) => ({
  number: index + 1,
  title: item.judul,
  deskripsi: item.deskripsi,
  manfaat: item.manfaat,
  alternatif: item.alternatif,
  hasil: '', // kosongkan atau isi sesuai data
  modifikasi: '', // kosongkan atau isi sesuai data
  tanggal: item.tanggal,
  status: 'Dikirim',
  komen: '', // kosongkan atau isi sesuai kebutuhan
}))
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
