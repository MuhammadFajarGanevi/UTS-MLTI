<template>
  <VContainer>
    <VRow>
      <VCol cols="12">
        <VCard>
          <VCardTitle class="pt-5 pb-4">
            <h2>Ringkasan Laporan Layanan</h2>
            <VSpacer class="pt-2" />
            <VRow>
              <VCol cols="4">
                <VCard
                  variant="text"
                  class="summary"
                >
                  <VCardTitle>Total Insiden</VCardTitle>
                  <VCardText class="text-h5">
                    2
                  </VCardText>
                </VCard>
              </VCol>
              <VCol cols="4">
                <VCard
                  variant="text"
                  class="summary"
                >
                  <VCardTitle>Total Permintaan</VCardTitle>
                  <VCardText class="text-h5">
                    2
                  </VCardText>
                </VCard>
              </VCol>
              <VCol cols="4">
                <VCard
                  variant="text"
                  class="summary"
                >
                  <VCardTitle>Total Masalah</VCardTitle>
                  <VCardText class="text-h5">
                    2
                  </VCardText>
                </VCard>
              </VCol>
            </VRow>
          </VCardTitle>
          

          <!-- Insiden Terbaru -->
          <VRow>
            <VCol cols="12">
              <VCard>
                <VCardTitle>
                  Insiden terbaru
                </VCardTitle>
                <VDataTable
                  :headers="headers" 
                  :items="isi"
                  class="elevation-1"
                  dense
                />
              </VCard>
            </VCol>
          </VRow>

          <!-- Permintaan Terbaru -->
          <VRow>
            <VCol cols="12">
              <VCard>
                <VCardTitle>
                  Permintaan terbaru
                </VCardTitle>
                <VDataTable
                  :headers="headers" 
                  :items="isi"
                  class="elevation-1"
                  dense
                />
              </VCard>
            </VCol>
          </VRow>

          <VRow>
            <VCol cols="12">
              <VCard>
                <VCardTitle>
                  Masalah terbaru
                </VCardTitle>
                <VDataTable
                  :headers="headers" 
                  :items="isi"
                  class="elevation-1"
                  dense
                />
              </VCard>
            </VCol>
          </VRow>
        </VCard>
      </VCol>
    </VRow>

    <!-- Ringkasan Angka -->
  </VContainer>
</template>

<script setup>
const headers = [
  { title: 'Judul', key: 'title' },
  { title: 'status', key: 'status' },
  { title: 'Tanggal', key: 'date' },

  // { title: 'Aksi', key: 'actions', sortable: false },
]

const isi=[
  {
    title: "coba1",
    status: "berhasil",
    date: "2025-05-10",
  },
]
</script>

<style scoped>
h2,
h3 {
  margin-block-end: 16px;
}

.summary {
  border-inline-start: 4px solid #2196f3; /* warna biru Vuetify (blue-500) */
  padding-inline-start: 16px;
}
</style>
