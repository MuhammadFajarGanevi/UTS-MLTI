export const routes = [
  { path: '/', redirect: '/dashboard' },
  {
    path: '/',
    component: () => import('@/layouts/default.vue'),
    children: [
      {
        path: 'dashboard',
        component: () => import('@/pages/dashboard.vue'),
        meta: { requiresAuth: true },
      },
      {
        path: 'report',
        component: () => import('@/pages/report.vue'),
        meta: { requiresAuth: true },
        
      },
      {
        path: 'hasil',
        component: () => import('@/pages/hasil.vue'),
        meta: { requiresAuth: true },
        
      },
      {
        path: 'layanan',
        component: () => import('@/pages/layanan-user.vue'),
        meta: { requiresAuth: true, role: 'user' },
        
      },
      {
        path: 'layanan-admin',
        component: () => import('@/pages/layanan-admin.vue'),
        meta: { requiresAuth: true, role: 'admin' },
        
      },
      {
        path: 'laporan-layanan',
        component: () => import('@/pages/laporan-layanan-form.vue'),
        meta: { requiresAuth: true, role: 'user' },
        
      },
      {
        path: 'masalah',
        component: () => import('@/pages/masalah-user.vue'),
        meta: { requiresAuth: true, role: 'user' },
        
      },
      {
        path: 'masalah-admin',
        component: () => import('@/pages/masalah-admin.vue'),
        meta: { requiresAuth: true, role: 'admin' },
        
      },
      {
        path: 'laporan-masalah',
        component: () => import('@/pages/masalah-form.vue'),
        meta: { requiresAuth: true, role: 'user' },
        
      },
    ],
  },
  {
    path: '/',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        path: 'login',
        component: () => import('@/pages/login.vue'),
        
      },
      {
        path: 'register',
        component: () => import('@/pages/register.vue'),
        
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]
