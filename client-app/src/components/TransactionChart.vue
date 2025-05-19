<template>
  <div style="block-size: 400px; inline-size: 100%;">
    <Line
      :data="chartData"
      :options="chartOptions"
    />
  </div>
</template>

<script setup>
import {
  CategoryScale,
  Chart as ChartJS,
  Legend,
  LinearScale,
  LineElement,
  PointElement,
  Title,
  Tooltip,
} from 'chart.js'
import { computed, defineProps } from 'vue'
import { Line } from 'vue-chartjs'

const props = defineProps({
  dataByPeriod: {
    type: Object,
    required: false,
    default: () => ({
      labels: [
        '2025-05-01',
        '2025-05-02',
        '2025-05-03',
        '2025-05-04',
        '2025-05-05',
        '2025-05-06',
        '2025-05-07',
        '2025-05-08',
        '2025-05-09',
        '2025-05-10',
        '2025-05-11',
        '2025-05-12',
        '2025-05-13',
        '2025-05-14',
      ],
      totalTraffic: [
        100,
        110,
        120,
        130,
        115,
        140,
        160,
        170,
        165,
        180,
        175,
        190,
        185,
        200,
      ],
      successTraffic: [
        90,
        100,
        110,
        120,
        110,
        130,
        150,
        160,
        150,
        170,
        160,
        180,
        170,
        190,
      ],
      failedTraffic: [
        10,
        10,
        10,
        10,
        5,
        10,
        10,
        10,
        15,
        10,
        15,
        10,
        15,
        10,
      ],
    }),
  },
})

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale)

const chartData = computed(() => ({
  labels: props.dataByPeriod.labels || [],
  datasets: [
    {
      label: 'Total Traffic',
      data: props.dataByPeriod.totalTraffic || [],
      borderColor: '#3b82f6',
      backgroundColor: '#3b82f6',
      fill: false,
      tension: 0.3,
    },
    {
      label: 'Traffic Sukses',
      data: props.dataByPeriod.successTraffic || [],
      borderColor: '#10b981',
      backgroundColor: '#10b981',
      fill: false,
      tension: 0.3,
    },
    {
      label: 'Traffic Gagal',
      data: props.dataByPeriod.failedTraffic || [],
      borderColor: '#ef4444',
      backgroundColor: '#ef4444',
      fill: false,
      tension: 0.3,
    },
  ],
}))

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top',
    },
    tooltip: {
      mode: 'index',
      intersect: false,
    },
  },
  scales: {
    x: {
      ticks: {
        autoSkip: false,
        maxRotation: 45,
        minRotation: 45,
      },
      grid: {
        display: false,
      },
    },
    y: {
      beginAtZero: true,
      ticks: {
        precision: 0,
        stepSize: 20,
      },
    },
  },
}
</script>
