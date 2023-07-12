// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [

  {
    path: '/',
    name: 'Index',
    component: import('../views/ListagemAtividades.vue')
  },
  {
    path: '/cadastro',
    name: 'Cadastro',
    component: import('../views/Cadastro.vue')
  },
  {
    path: '/login',
    component: import('../views/User/Login.vue')
  },
  {
    path: '/user/cadastro',
    component: import('../views/User/Cadastro.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
