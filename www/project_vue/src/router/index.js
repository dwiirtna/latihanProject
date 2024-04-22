import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/views/Home.vue';
import AboutPage from '@/views/About.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/home' },
    { path: '/home', name: 'HomePage', component: HomePage},
    { path: '/about', name: 'AboutPage', component: AboutPage},

    // {
    //   path: '/',
    //   name: 'home',
    //   component: HomeView
    // },
    // {
    //   path: '/about',
    //   name: 'about',
    //   component: () => import('../views/AboutView.vue')
    // }
  ]
})

export default router
