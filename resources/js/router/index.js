import { createWebHistory, createRouter } from "vue-router";
import Landing from '../components/Landing'
import Login from '../components/Login'
import LoginPegawai from '../components/LoginPegawai'
import Register from '../components/Register'
import TopBar from "../dashboard/TopBar";

// Admin Role
import AdminDashboard from "../dashboard/AdminDashboard";
import ManagerDashboard from "../dashboard/ManagerDashboard";
import PegawaiDashboard from "../dashboard/PegawaiDashboard";
import DataPegawai from "../components/Admin/DataPegawai";
import AkunPegawai from "../components/Admin/AkunPegawai";
import Jabatan from "../components/Admin/Jabatan";
import Kehadiran from "../components/Admin/Kehadiran";
import Payroll from "../components/Admin/Payroll";
import Laporan from "../components/Admin/Laporan";
import Lembur from "../components/Admin/Lembur";
import Cuti from "../components/Admin/Cuti";
import ProfileAdmin from "../components/Admin/ProfileAdmin";

//Pegawai Role
import Absen from "../components/Pegawai/Absen";
import GajiPegawai from "../components/Pegawai/GajiPegawai";
import LaporanHarian from "../components/Pegawai/LaporanHarian";
import Pengajuan from "../components/Pegawai/Pengajuan";
import Profile from "../components/Pegawai/Profile";

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
        name: 'Landing',
        path: '/',
        component: Landing
    },
    {
        name: 'Login',
        path: '/Login',
        component: Login
    },
    {
        name: 'LoginPegawai',
        path: '/LoginPegawai',
        component: LoginPegawai
    },
    {
        name: 'Register',
        path: '/Register',
        component: Register
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
        name: 'DataPegawai',
        path: '/DataPegawai',
        component: DataPegawai,
        beforeEnter: admin,
    },
    {
        name: 'ProfileAdmin',
        path: '/ProfileAdmin',
        component: ProfileAdmin,
        beforeEnter: admin,
    },
    {
        name: 'AkunPegawai',
        path: '/AkunPegawai',
        component: AkunPegawai,
        beforeEnter: admin,
    },
    {
        name: 'Jabatan',
        path: '/Jabatan',
        component: Jabatan,
        beforeEnter: admin,
    },
    {
        name: 'Kehadiran',
        path: '/Kehadiran',
        component: Kehadiran,
        beforeEnter: admin,
    },
    {
        name: 'Payroll',
        path: '/Payroll',
        component: Payroll,
        beforeEnter: admin,
    },
    {
        name: 'Laporan',
        path: '/Laporan',
        component: Laporan,
        beforeEnter: admin,
    },
    {
        name: 'Lembur',
        path: '/Lembur',
        component: Lembur,
        beforeEnter: admin,
    },
    {
        name: 'Cuti',
        path: '/Cuti',
        component: Cuti,
        beforeEnter: admin,
    },
    {
        name: 'Absen',
        path: '/Absen',
        component: Absen,
        beforeEnter: pegawai,
    },
    {
        name: 'GajiPegawai',
        path: '/GajiPegawai',
        component: GajiPegawai,
        beforeEnter: pegawai,
    },
    {
        name: 'LaporanHarian',
        path: '/LaporanHarian',
        component: LaporanHarian,
        beforeEnter: pegawai,
    },
    {
        name: 'Pengajuan',
        path: '/Pengajuan',
        component: Pengajuan,
        beforeEnter: pegawai,
    },
    {
        name: 'Profile',
        path: '/Profile',
        component: Profile,
        beforeEnter: pegawai,
    },


];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;