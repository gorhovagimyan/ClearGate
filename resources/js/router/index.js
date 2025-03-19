import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';
import Dashboard from '../Pages/Dashboard.vue';
import Tasks from '../Pages/Tasks.vue';
import Login from '../Pages/Auth/Login.vue';
import Register from '../components/Auth/Register.vue';
import store from '../store';

const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    },
    {
        path: '/tasks',
        name: 'tasks',
        component: Tasks,
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.isAuthenticated) {
        next('/login');
    } else {
        next();
    }
});

export default router; 