import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

// Lazy-loaded pages
const Login = () => import('@/pages/auth/Login.vue')
const Register = () => import('@/pages/auth/Register.vue')
const MainLayout = () => import('@/layouts/MainLayout.vue')
const Dashboard = () => import('./../pages/dashboard/Dashboard.vue')
// const Dashboard = () => import('@/pages/dashboard/Dashboard.vue')
const CreateTask = () => import('@/pages/dashboard/CreateTask.vue')
const EditTask = () => import('@/pages/dashboard/EditTask.vue')

const routes = [
  {
    path: '/',
    redirect: '/login',
  },
  {
    path: '/login',
    component: Login,
    meta: { requiresGuest: true },
  },
  {
    path: '/register',
    component: Register,
    meta: { requiresGuest: true },
  },
  {
    path: '/dashboard',
    component: MainLayout,
    meta: { requiresAuth: true },
    children: [
      { path: '', component: Dashboard },
      { path: 'create', component: CreateTask },
      { path: 'edit/:id', component: EditTask },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Navigation guard
router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  console.log(auth.isAuthenticated);
  
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    next('/login')
  } else if (to.meta.requiresGuest && auth.isAuthenticated) {
    next('/dashboard')
  } else {
    next()
  }
})

export default router
