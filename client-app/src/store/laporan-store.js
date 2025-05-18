// stores/laporanStore.js
import { defineStore } from 'pinia'

export const useLaporanStore = defineStore('laporan', {
  state: () => ({
    daftarLaporan: [],
  }),
  actions: {
    tambahLaporan(laporan) {
      this.daftarLaporan.push(laporan)
    },
  },
})
