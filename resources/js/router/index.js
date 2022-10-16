import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import DashboardSuperadmin from "../views/DashboardSuperadmin.vue";
import AdminPegawai from "../views/AdminPegawai.vue";
import AdminAkun from "../views/AdminAkun.vue";
import AdminPayroll from "../views/AdminPayroll.vue";
import AdminTunjangan from "../views/AdminTunjangan.vue";
import AdminBonus from "../views/AdminBonus.vue";
import AdminPotongan from "../views/AdminPotongan.vue";
import AdminGolongan from "../views/AdminGolongan.vue";
import AdminKehadiran from "../views/AdminKehadiran.vue";
import AdminRiwayat from "../views/AdminRiwayat.vue";
import AdminCuti from "../views/AdminCuti.vue";
import AdminLaporan from "../views/AdminLaporan.vue";
import AdminJabatan from "../views/AdminJabatan.vue";
import ApproveCuti from "../views/ApproveCuti.vue";
import ApproveLembur from "../views/ApproveLembur.vue";
import ApproveReqabsen from "../views/ApproveReqabsen.vue";
import ApproveIzin from "../views/ApproveIzin.vue";
import AdminProfile from "../views/AdminProfile.vue";
import Profile from "../views/Profile.vue";
import Signup from "../views/Signup.vue";
import Signin from "../views/Signin.vue";
import LupaPassword from "../views/LupaPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import LupaAdmin from "../views/LupaAdmin.vue";
import ResetAdmin from "../views/ResetAdmin.vue";
import SigninPegawai from "../views/SigninPegawai.vue";
import Register from "../views/Register.vue";

import SuperadminApprove from "../views/SuperadminApr.vue";
import SuperadminPt from "../views/SuperadminP.vue";
import SuperadminHapuspeg from "../views/SuperadminHapus.vue";
import SuperadminProfile from "../views/SuperadminProfile.vue";


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
    } else next({ name: '/' });
}

function pegawai(to, from, next) {
    if (localStorage.getItem("loggedIn")) {
        (localStorage.getItem("role") == 'Pegawai')
        next();
    } else next({ name: 'Login' });
}

const routes = [
    // {
    //     path: "/",
    //     name: "/",
    //     redirect: "/dashboard-default",
    // },
    {
        path: "/superadminapprove",
        name: "Management Akun",
        component: SuperadminApprove
    },
    {
        path: "/superadminhapuspeg",
        name: "Superadmin Hapuspegawai",
        component: SuperadminHapuspeg
    },
    {
        path: "/superadminpt",
        name: "Superadmin Perusahaan",
        component: SuperadminPt
    },
    {
        path: "/",
        name: "/",
        component: Signin,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
    {
        path: "/adminprofile",
        name: "Admin Profile",
        component: AdminProfile
    },
    {
        path: "/loginpegawai",
        name: "/loginpegawai",
        component: SigninPegawai,
    },
    {
        path: "/lupapassword",
        name: "/lupapassword",
        component: LupaPassword,
    },
    {
        path: "/resetpassword",
        name: "/resetpassword",
        component: ResetPassword,
    },
    {
        path: "/lupaadmin",
        name: "/lupaadmin",
        component: LupaAdmin,
    },
    {
        path: "/resetadmin",
        name: "/resetadmin",
        component: ResetAdmin,
    },
    {
        path: "/dashboard-default",
        name: "Dashboard",
        component: Dashboard,
        beforeEnter: admin,
    },
    {
        path: "/superadmindashboard",
        name: "Dashboard Superadmin",
        component: DashboardSuperadmin,
        beforeEnter: manager,
    },
    {
        path: "/superadminprofile",
        name: "Superadmin Profile",
        component: SuperadminProfile,
    },
    {
        path: "/datapegawai",
        name: "Data Pegawai",
        component: AdminPegawai,
    },
    {
        path: "/datakehadiran",
        name: "Data Kehadiran",
        component: AdminKehadiran,
    },
    {
        path: "/akunpegawai",
        name: "Akun Pegawai",
        component: AdminAkun,
    },
    {
        path: "/payroll",
        name: "Payroll",
        component: AdminPayroll,
    },
    {
        path: "/tunjangan",
        name: "Tunjangan",
        component: AdminTunjangan,
    },
    {
        path: "/bonus",
        name: "Bonus",
        component: AdminBonus,
    },
    {
        path: "/potongan",
        name: "Potongan",
        component: AdminPotongan,
    },
    {
        path: "/golongan",
        name: "Golongan",
        component: AdminGolongan,
    },
    {
        path: "/riwayat",
        name: "Riwayat Gaji",
        component: AdminRiwayat,
    },
    {
        path: "/tunjangan",
        name: "Tunjangan",
        component: AdminTunjangan,
    },
    {
        path: "/cuti",
        name: "Cuti",
        component: AdminCuti,
    },
    {
        path: "/laporan",
        name: "Laporan",
        component: AdminLaporan,
    },
    {
        path: "/jabatan",
        name: "Jabatan",
        component: AdminJabatan,
    },
    {
        path: "/approveizin",
        name: "Approvement Izin",
        component: ApproveIzin,
    },
    {
        path: "/approvelembur",
        name: "Approvement Lembur",
        component: ApproveLembur,
    },
    {
        path: "/approvecuti",
        name: "Approvement Cuti",
        component: ApproveCuti,
    },
    {
        path: "/approvereqabsen",
        name: "Approve Request Attendance",
        component: ApproveReqabsen,
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
    },
    {
        path: "/signup",
        name: "Signup",
        component: Signup,
    },

];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
    linkActiveClass: "active",
});

export default router;