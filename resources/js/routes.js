import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name:'accueil.index',
        component: () => import('@/pages/accueil/Accueil.vue'),
        meta:{title:'Accueil'}
    },
    {
        path: '/page1',
        name:'page1.index',
        component: () => import('@/pages/accueil/page1.vue'),
        meta:{title:'Page 1'}
    },
    {
        path: '/page2',
        name:'page2.index',
        component: () => import('@/pages/accueil/page2.vue'),
        meta:{title:'Page 2'}
    },
]

export default createRouter({
    history: createWebHistory(window.location.pathname+'/#/'),
    routes
});