import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name:'accueil.index',
        component: () => import('@/pages/films/FilmIndex.vue'),
        meta:{title:'Liste des films'}
    },
    {
        path: '/film/:id',
        name:'film.show',
        component: () => import('@/pages/films/FilmShow.vue'),
        meta:{title:'Détails du film'}
    },
    {
        path: '/film/edit/:id',
        name:'film.edit',
        component: () => import('@/pages/films/FilmEdit.vue'),
        meta:{title:'Modifier un film'}
    },
]

export default createRouter({
    history: createWebHistory(window.location.pathname+'/#/'),
    routes
});