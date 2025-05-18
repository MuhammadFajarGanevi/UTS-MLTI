<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue'
import api from '@/plugins/axios'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const role = localStorage.getItem('userRole')

const handleLogout = async () => {
  try {
    const token = localStorage.getItem('token')

    // Pastikan token ada sebelum logout
    if (!token) {
      router.push('/login')
      
      return
    }

    // Kirim request logout ke API
    await api.post('/auth/logout', {}, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })

    // Hapus token dan redirect ke login
    localStorage.removeItem('token')
    router.push('/login')
  } catch (error) {
    console.error('Gagal logout:', error)

    // Tetap hapus token jika terjadi error
    localStorage.removeItem('token')
    router.push('/login')
  }
}

// Routing berdasarkan role
const reportRoute = computed(() => {
  if (role === 'admin') return '/report-admin'
  else if (role === 'worker') return '/report-worker'
  else return '/report'
})

const layananRoute = computed(() => {
  if (role === 'admin') return '/layanan-admin'
  else if (role === 'worker') return '/layanan-worker'
  else return '/layanan'
})

const masalahRoute = computed(() => {
  if (role === 'admin') return '/masalah-admin'
  else if (role === 'worker') return '/masalah-worker'
  else return '/masalah'
})
</script>

<template>
  <VerticalNavLink
    :item="{
      title: 'Dashboards',
      icon: 'bx-home-smile',
      to:'/dashboard',
    }"
  />

  
  <!-- 👉 Apps & Pages -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Laporan',
    }"
  />
 

  <VerticalNavLink
    :item="{
      title: 'Insiden',
      icon: 'bx-news',
      to: reportRoute,
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Layanan',
      icon: 'bx-news',
      to: layananRoute,
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Laporan',
      icon: 'bx-news',
      to: masalahRoute,
    }"
  />

  <!-- 👉 Logout Button -->
  <div class="logout-section">
    <VerticalNavLink
      :item="{
        title: 'Logout',
        icon: 'bx-log-out',
      }"
      @click="handleLogout"
    />
  </div>
</template>

<style scoped>
.logout-section {
  position: absolute;
  inline-size: 100%;
  inset-block-end: 1rem;
  inset-inline-start: 0;
}
</style>
