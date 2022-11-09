import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import DashboardSuperadmin from "../views/DashboardSuperadmin.vue";
import DashboardPegawai from "../views/DashboardPegawai.vue";
import AdminPegawai from "../views/Admin/AdminPegawai.vue";
import AdminAkun from "../views/Admin/AdminAkun.vue";
import AdminPayroll from "../views/Admin/AdminPayroll.vue";
import AdminTunjangan from "../views/Admin/AdminTunjangan.vue";
import AdminBonus from "../views/Admin/AdminBonus.vue";
import AdminPotongan from "../views/Admin/AdminPotongan.vue";
import AdminGolongan from "../views/Admin/AdminGolongan.vue";
import AdminKehadiran from "../views/Admin/AdminKehadiran.vue";
import AdminPencairan from "../views/Admin/AdminPencairan.vue";
import AdminCuti from "../views/Admin/AdminCuti.vue";
import AdminLaporan from "../views/Admin/AdminLaporan.vue";
import AdminJabatan from "../views/Admin/AdminJabatan.vue";
import ApproveCuti from "../views/Admin/ApproveCuti.vue";
import ApproveLembur from "../views/Admin/ApproveLembur.vue";
import ApproveReqabsen from "../views/Admin/ApproveReqabsen.vue";
import ApproveIzin from "../views/Admin/ApproveIzin.vue";
import AdminProfile from "../views/Admin/AdminProfile.vue";
import Profile from "../views/Profile.vue";
import Signup from "../views/Signup.vue";
import Signin from "../views/Signin.vue";
import LupaPassword from "../views/LupaPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import LupaAdmin from "../views/LupaAdmin.vue";
import ResetAdmin from "../views/ResetAdmin.vue";
import SigninPegawai from "../views/SigninPegawai.vue";
import Register from "../views/Register.vue";
import Landing from "../views/Landing.vue";

import Presensi from "../views/Pegawai/PegawaiPresensi.vue"
import Kehadiran from "../views/Pegawai/PegawaiKehadiran.vue"
import PegawaiLaporan from "../views/Pegawai/PegawaiLaporan.vue"
import PegawaiIzin from "../views/Pegawai/PegawaiIzin.vue"
import PegawaiLembur from "../views/Pegawai/PegawaiLembur.vue"
import PegawaiCuti from "../views/Pegawai/PegawaiCuti.vue"
import PegawaiReqabsen from "../views/Pegawai/PegawaiReqabsen.vue"
import PegawaiProfile from "../views/Pegawai/PegawaiProfile.vue"
import PegawaiAmbil from "../views/Pegawai/PegawaiAmbil.vue"
import PegawaiCek from "../views/Pegawai/PegawaiCek.vue"
import PegawaiRiwayat from "../views/Pegawai/PegawaiRiwayat.vue"

import SuperadminApprove from "../views/SuperAdmin/SuperadminApr.vue";
import SuperadminPt from "../views/SuperAdmin/SuperadminP.vue";
import SuperadminHapuspeg from "../views/SuperAdmin/SuperadminHapus.vue";
import SuperadminProfile from "../views/SuperAdmin/SuperadminProfile.vue";


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
    } else next({ name: '/' });
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
        component: Landing,
    },
    {
        path: "/login",
        name: "Login",
        component: Signin,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
    {
        path: "/adminprofile",
        name: "Profil Admin",
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
        path: "/pegawaidashboard",
        name: "Dashboard Pegawai",
        component: DashboardPegawai,
        beforeEnter: pegawai,
    },
    {
        path: "/superadminprofile",
        name: "Profil Superadmin",
        component: SuperadminProfile,
    },
    {
        path: "/pegawaiprofile",
        name: "Profil Pegawai",
        component: PegawaiProfile,
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
        path: "/pencairan",
        name: "Pencairan Gaji",
        component: AdminPencairan,
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
    {
        path: "/presensi",
        name: "Presensi Harian",
        component: Presensi,
    },
    {
        path: "/kehadiran",
        name: "Kehadiran Pegawai",
        component: Kehadiran,
    },
    {
        path: "/pegawailaporan",
        name: "Laporan Pegawai",
        component: PegawaiLaporan,
    },
    {
        path: "/pengajuanizin",
        name: "Pengajuan Izin",
        component: PegawaiIzin,
    },
    {
        path: "/pengajuanlembur",
        name: "Pengajuan Lembur",
        component: PegawaiLembur,
    },
    {
        path: "/pengajuancuti",
        name: "Pengajuan Cuti",
        component: PegawaiCuti,
    },
    {
        path: "/pengajuanreqabsen",
        name: "Pengajuan Request Attendance",
        component: PegawaiReqabsen,
    },
    {
        path: "/pengambilangaji",
        name: "Pengambilan Gaji",
        component: PegawaiAmbil,
    },
    {
        path: "/gajicek",
        name: "Cek Pengambilan Gaji",
        component: PegawaiCek,
    },
    {
        path: "/riwayatgajipegawai",
        name: "Riwayat Penggajian",
        component: PegawaiRiwayat,
    },

];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
    linkActiveClass: "active",
});

export default router;