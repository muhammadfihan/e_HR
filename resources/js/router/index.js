import { createWebHistory, createRouter } from "vue-router";

import Login from '../components/Login'
import AdminDashboard from "../dashboard/AdminDashboard";
import ManagerDashboard from "../dashboard/ManagerDashboard";
import PegawaiDashboard from "../dashboard/PegawaiDashboard";
import TopBar from "../dashboard/TopBar";
import DataPegawai from "../components/Admin/DataPegawai";
import Navbar from "../components/Navbar";
import { next } from "lodash/seq";

function manager(to, from, next) {
    if (localStorage.getItem("loggedIn")) {
        (localStorage.getItem("role") == 'Manager')
        next();
    } else next({ name: 'Login' });
}

function admin(to, from, next) {
    if (localStorage.getItem("loggedIn")) {
        (localStorage.getItem("role") == 'Admin')
        next();
    } else next({ name: 'Login' });
}

function pegawai(to, from, next) {
    if (localStorage.getItem("loggedIn")) {
        (localStorage.getItem("role") == 'Pegawai')
        next();
    } else next({ name: 'Login' });
}
export const routes = [{
        name: 'Login',
        path: '/',
        component: Login
    },
    {
        name: 'AdminDashboard',
        path: '/AdminDashboard',
        component: AdminDashboard,
        beforeEnter: admin,
    },
    {
        name: 'ManagerDashboard',
        path: '/ManagerDashboard',
        component: ManagerDashboard,
        beforeEnter: manager,
    },
    {
        name: 'PegawaiDashboard',
        path: '/PegawaiDashboard',
        component: PegawaiDashboard,
        beforeEnter: pegawai,
    },
    {
        name: 'TopBar',
        path: '/TopBar',
        component: TopBar
    },
    {
        name: 'Navbar',
        path: '/Navbar',
        component: Navbar
    },
    {
        name: 'DataPegawai',
        path: '/DataPegawai',
        component: DataPegawai,
        beforeEnter: admin,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;