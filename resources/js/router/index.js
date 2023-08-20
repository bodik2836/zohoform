import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../components/zohoform/Index.vue')
    },
    {
        path: '/zoho/form',
        name: 'zoho.form.index',
        component: () => import('../components/zohoform/Index.vue')
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router
