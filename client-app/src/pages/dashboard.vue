<template>
  <VContainer
    fluid
    class="dashboard-container"
  >
    <!-- Judul -->
    <h2 class="text-h5 font-weight-bold mb-4">
      Dashboard
    </h2>

    <!-- Statistik Atas -->
    <VRow
      class="mb-4"
      dense
    >
      <VCol
        cols="12"
        sm="4"
      >
        <VCard class="stat-card">
          <div class="card-title">
            <VIcon
              color="primary"
              class="me-2"
            >
              bx-bar-chart
            </VIcon>
            Total Transaksi
          </div>
          <div class="card-value">
            {{ totalTransaksi }}
          </div>
          <div class="card-sub">
            Hasil Akumulatif
          </div>
        </VCard>
      </VCol>

      <VCol
        cols="12"
        sm="4"
      >
        <VCard class="stat-card">
          <div class="card-title">
            <VIcon
              color="success"
              class="me-2"
            >
              bx-check-circle
            </VIcon>
            Transaksi Sukses
          </div>
          <div class="card-value">
            {{ transaksiSukses }}
          </div>
          <div class="card-sub">
            Rate:
            {{
              (totalTransaksi + totalLayanan) > 0
                ? (((transaksiSukses + layananSukses) / (totalTransaksi + totalLayanan)) * 100).toFixed(1)
                : 0
            }}%
          </div>
        </VCard>
      </VCol>

      <VCol
        cols="12"
        sm="4"
      >
        <VCard class="stat-card">
          <div class="card-title">
            <VIcon
              color="error"
              class="me-2"
            >
              bx-x-circle
            </VIcon>
            Transaksi Gagal
          </div>
          <div class="card-value">
            {{ transaksiGagal }}
          </div>
          <div class="card-sub">
            Rate:
            {{
              (totalTransaksi + totalLayanan) > 0
                ? (((transaksiGagal + layananGagal) / (totalTransaksi + totalLayanan)) * 100).toFixed(1)
                : 0
            }}%
          </div>
        </VCard>
      </VCol>
    </VRow>

    <!-- Grafik -->
    <VRow dense>
      <VCol cols="12">
        <VCard class="graph-card pa-4">
          <div class="font-weight-bold text-body-1 mb-2">
            <VIcon
              color="primary"
              class="me-2"
            >
              bx-money
            </VIcon>
            Grafik Jumlah Transaksi per Tanggal
          </div>
          <TransactionChart :data-by-date="dataChartByDate" />
        </VCard>
      </VCol>
    </VRow>
  </VContainer>
</template>

<script setup>
import TransactionChart from '@/components/TransactionChart.vue'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const totalTransaksi = ref(233)
const transaksiSukses = ref(229)
const transaksiGagal = ref(4)

const dataChartIncidentByDate = ref({})
const dataChartLayananByDate = ref({})

const dataChartByDate = ref({})

onMounted(async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) {
      alert('Token tidak ditemukan. Silakan login terlebih dahulu.')
      router.push('/login')
      
      return
    }
  } catch (err) {
    console.error('Gagal mengambil data:', err)
    alert('Gagal mengambil data. Periksa token dan koneksi internet.')
  }
})
</script>

<style scoped>
.dashboard-container {
  background-color: #f9f9f9;
  min-block-size: 100vh;
  padding-block-start: 20px;
}

.stat-card {
  padding: 20px;
  border-radius: 12px;
  background-color: #fff;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 6%);
  text-align: center;
}

.card-title {
  color: #4b5563;
  font-weight: 600;
}

.card-value {
  color: #111827;
  font-size: 26px;
  font-weight: bold;
  margin-block-start: 8px;
}

.card-sub {
  color: #9ca3af;
  font-size: 14px;
  margin-block-start: 4px;
}

.graph-card {
  border-radius: 12px;
  background-color: #fff;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 6%);
}
</style>
