import { createRouter, createWebHistory } from 'vue-router'
import { routes } from './routes'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const role = localStorage.getItem('userRole')

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!token) {
      next('/login')
    } else if (to.meta.role && to.meta.role !== role) {
      next('/unauthorized')
    } else {
      next()
    }
  } else {
    next()
  }
})


// // Fungsi cek autentikasi sederhana (cek token di localStorage)
// function isAuthenticated() {
//   return !!localStorage.getItem('user-token')
// }

// // Navigation Guard
// router.beforeEach((to, from, next) => {
//   const requiresAuth = to.matched.some(record => record.meta.requiresAuth)

//   if (requiresAuth && !isAuthenticated()) {
//     // Belum login tapi mau ke halaman yang butuh login
//     next('/login')
//   } else if ((to.path === '/login' || to.path === '/register') && isAuthenticated()) {
//     // Sudah login tapi buka halaman login/register
//     next('/dashboard')
//   } else {
//     // Boleh lanjut
//     next()
//   }
// })

export default function (app) {
  app.use(router)
}

export { router }
