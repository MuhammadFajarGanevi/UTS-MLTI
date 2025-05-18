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
</script>

<template>
  <!-- 👉 Dashboards -->
  <!--
    <VerticalNavGroup
    :item="{
    title: 'Dashboards',
    // badgeContent: '5',
    // badgeClass: 'bg-error',
    icon: 'bx-home-smile',
    }"
    >
    <VerticalNavLink
    :item="{
    title: 'Analytics',
    to: '/dashboard',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'Reports',
    to: '/report',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'hasil',
    to: '/hasil',
    }"
    />
    </VerticalNavGroup> 
  -->

  <VerticalNavLink
    :item="{
      title: 'Dashboards',
      // badgeContent: '5',
      // badgeClass: 'bg-error',
      icon: 'bx-home-smile',
      to:'/dashboard',
    }"
  />

  <!-- 👉 Front Pages -->
  <!--
    <VerticalNavGroup
    :item="{
    title: 'Front Pages',
    icon: 'bx-file',
    badgeContent: 'Pro',
    badgeClass: 'bg-light-primary text-primary',
    }"
    >
    <VerticalNavLink
    :item="{
    title: 'Landing',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/front-pages/landing-page',
    target: '_blank',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'Pricing',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/front-pages/pricing',
    target: '_blank',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'Payment',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/front-pages/payment',
    target: '_blank',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'Checkout',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/front-pages/checkout',
    target: '_blank',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'Help Center',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/front-pages/help-center',
    target: '_blank',
    }"
    />
    </VerticalNavGroup> 
  -->

  <!-- 👉 Apps & Pages -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Laporan',
    }"
  />
  <!--
    <VerticalNavLink
    :item="{
    title: 'Email',
    icon: 'bx-envelope',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/apps/email',
    target: '_blank',
    badgeContent: 'Pro',
    badgeClass: 'bg-light-primary text-primary',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'Chat',
    icon: 'bx-chat',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/apps/chat',
    target: '_blank',
    badgeContent: 'Pro',
    badgeClass: 'bg-light-primary text-primary',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'Calendar',
    icon: 'bx-calendar',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/apps/calendar',
    target: '_blank',
    badgeContent: 'Pro',
    badgeClass: 'bg-light-primary text-primary',
    }"
    />
    <VerticalNavLink
    :item="{
    title: 'Kanban',
    icon: 'bx-grid',
    href: 'https://demos.themeselection.com/sneat-vuetify-vuejs-admin-template/demo-1/apps/kanban',
    target: '_blank',
    badgeContent: 'Pro',
    badgeClass: 'bg-light-primary text-primary',
    }"
    /> 
  -->

  <VerticalNavLink
    :item="{
      title: 'Insiden',
      icon: 'bx-news',
      to: role === 'admin' ? '/report-admin' :'/report',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Layanan',
      icon: 'bx-news',
      to: role === 'admin' ? '/layanan-admin' :'/layanan',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Laporan',
      icon: 'bx-news',
      to: role === 'admin' ? '/masalah-admin' : '/masalah',
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
