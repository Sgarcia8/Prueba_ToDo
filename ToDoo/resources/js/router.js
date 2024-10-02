import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import notFound from './components/NotfoundPage.vue';
import Dashboard from './components/Dashboard.vue';

const routes = [
    { path: '/', component: Login },
    { path: '/register', component: Register },
    { path: '/dashboard', component: Dashboard},
    { path: '/:pathMatch(.*)*', component: notFound },
];

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: 'active',
    routes,
});

export default router;