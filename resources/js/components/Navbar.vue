<template>
    <div class="nav_warp" v-if="role === 'Admin'">
        <div class="warp" >
            <ul>
                <router-link to="AdminDashboard"><li class="active">Dashboard</li></router-link>
                <router-link to="DataPegawai"><li>Pegawai</li></router-link>
                <li>Data User</li>
                <li>Kehadiran</li>
                <li>Payroll</li>
                <li>Laporan</li>
                <li>Cuti</li>
                <li>Lembur</li>
            </ul>
        </div>
    </div>
</template>

<script>

export default {
    name: "Navbar",
     data() {
            return {
                loggedIn: localStorage.getItem("loggedIn"),
                token: localStorage.getItem("token"),
                name: localStorage.getItem("name"),
                role: localStorage.getItem("role")
            };
        },

    mounted() {
        const items = document.querySelectorAll("ul li");
        items.forEach((item) => {
            item.addEventListener("click", () => {
                document.querySelector("li.active").classList.remove("active");
                item.classList.add("active");
            });

        });
        if (!this.loggedIn) {
                return this.$router.push({name: "Login"});
            }

    },
    beforeRouteEnter(to, from, next) {
        if (JSON.parse(window.localStorage.getItem("loggedIn"))) {
            if(window.localStorage.getItem("role") == 'Manager'){
                return next();
            } else if (window.localStorage.getItem("role") == 'Admin') {
                return next();
            } else if (window.localStorage.getItem("role") == 'Pegawai') {
                return next();
            }
        }
        next();
    },

}
</script>

<style scoped>

</style>
