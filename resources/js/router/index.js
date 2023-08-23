import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../components/zoho/form/Index.vue')
    },
    {
        path: '/zoho/form',
        name: 'zoho.form.index',
        component: () => import('../components/zoho/form/Index.vue')
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router
