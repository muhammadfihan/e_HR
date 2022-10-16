<template>
  <div
    class="collapse navbar-collapse w-auto h-auto h-100"
    id="sidenav-collapse-main"
  >
    <ul class="navbar-nav" v-if="role == 'Admin'">
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <a class="navbar-brand" style="margin-top:-20px;margin-bottom: -20px;">
        <span class="font-weight-bold" >Menu Pegawai</span>
      </a>
      <li class="nav-item">
        <sidenav-item
          url="/dashboard-default"
          :class="getRoute() === 'dashboard-default' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'لوحة القيادة' : 'Dashboard'"
        >
          <template v-slot:icon>
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/datapegawai"
          :class="getRoute() === 'tables' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'الجداول' : 'Data Pegawai'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/akunpegawai"
          :class="getRoute() === 'akunpegawai' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'الفواتیر' : 'Data Akun Pegawai'"
        >
          <template v-slot:icon>
            <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/datakehadiran"
          :class="getRoute() === 'tables' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'الجداول' : 'Kehadiran Pegawai'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-calendar-grid-58 text-info text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/cuti"
          :class="getRoute() === 'cuti' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'اشتراك' : 'Cuti'"
        >
          <template v-slot:icon>
            <i class="ni ni-collection text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/laporan"
          :class="getRoute() === 'laporan' ? 'active' : ''"
          :navText="
            this.$store.state.isRTL ? 'الواقع الافتراضي' : 'Laporan Pegawai'
          "
        >
          <template v-slot:icon>
            <i class="ni ni-app text-info text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/jabatan"
          :class="getRoute() === 'jabatan' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'حساب تعريفي' : 'Jabatan'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-02 text-danger text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <a class="navbar-brand" style="margin-top:-20px;margin-bottom: -20px;">
        <span class="font-weight-bold" >Payroll Pegawai</span>
      </a>
      <li class="nav-item">
        <sidenav-item
          url="/payroll"
          :class="getRoute() === 'payroll' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'تسجيل الدخول' : 'Penggajian'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/tunjangan"
          :class="getRoute() === 'tunjangan' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'تسجيل الدخول' : 'Tunjangan'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/bonus"
          :class="getRoute() === 'bonus' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'تسجيل الدخول' : 'Bonus'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-info text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/potongan"
          :class="getRoute() === 'potongan' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'تسجيل الدخول' : 'Potongan'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/golongan"
          :class="getRoute() === 'golongan' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'تسجيل الدخول' : 'Golongan'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-success text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/riwayat"
          :class="getRoute() === 'riwayat' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'تسجيل الدخول' : 'Riwayat'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <a class="navbar-brand" style="margin-top:-20px;margin-bottom: -20px;">
        <span class="font-weight-bold" >Approvement Pegawai</span>
      </a>
      <li class="nav-item">
        <sidenav-item
          url="/approvecuti"
          :class="getRoute() === 'approvecuti' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'اشتراك' : 'Approvement Cuti'"
        >
          <template v-slot:icon>
            <i class="ni ni-collection text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/approvelembur"
          :class="getRoute() === 'approvelembur' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'اشتراك' : 'Approvement Lembur'"
        >
          <template v-slot:icon>
            <i class="ni ni-collection text-info text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/approveizin"
          :class="getRoute() === 'approveizin' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'اشتراك' : 'Approvement Izin'"
        >
          <template v-slot:icon>
            <i class="ni ni-collection text-warning text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item mb-5">
        <sidenav-item
          url="/approvereqabsen"
          :class="getRoute() === 'approvereqabsen' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'اشتراك' : 'Request Attendance'"
        >
          <template v-slot:icon>
            <i class="ni ni-collection text-danger text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
    </ul>





    <ul class="navbar-nav" v-if="role == 'Manager'">
      <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i>
      <a class="navbar-brand" style="margin-top:-20px;margin-bottom: -20px;">
        <span class="font-weight-bold" >Menu Perusahaan</span>
      </a>
      <li class="nav-item">
        <sidenav-item
          url="/superadmindashboard"
          :class="getRoute() === 'superadmindashboard' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'لوحة القيادة' : 'Superadmin Dashboard'"
        >
          <template v-slot:icon>
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/superadminpt"
          :class="getRoute() === 'tables' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'الجداول' : 'Data Perusahaan'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/superadminapprove"
          :class="getRoute() === 'akunpegawai' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'الفواتیر' : 'Managament Akun'"
        >
          <template v-slot:icon>
            <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          url="/superadminhapuspeg"
          :class="getRoute() === 'tables' ? 'active' : ''"
          :navText="this.$store.state.isRTL ? 'الجداول' : 'Hapus Akun Pegawai'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-calendar-grid-58 text-info text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>
    </ul>
  </div>
</template>
<script>
import SidenavItem from "./SidenavItem.vue";
export default {
  name: "SidenavList",
  props: {
    cardBg: String
  },
  created() {
    this.minNav;
  },
  data() {
    return {
      loggedIn: localStorage.getItem("loggedIn"),
      token: localStorage.getItem("token"),
      name: localStorage.getItem("name"),
      role: localStorage.getItem("role"),
      title: "Argon Dashboard 2",
      controls: "dashboardsExamples",
      isActive: "active"
    };
  },
  components: {
    SidenavItem,

  },
  methods: {
    getRoute() {
      const routeArr = this.$route.path.split("/");
      return routeArr[1];
    }
  }
};
</script>
