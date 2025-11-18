import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        component: () => import('../components/App.vue'),
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
