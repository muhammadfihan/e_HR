<template>
    <div class="nav_warp" v-if="role === 'Admin'">
        <div class="warp" >
            <ul>
                <router-link  to="AdminDashboard"><li class="active">Dashboard</li></router-link>
                <router-link  to="DataPegawai"><li>Pegawai</li></router-link>
                <router-link  to="AkunPegawai"><li>Data User</li> </router-link>
                <router-link  to="Jabatan"><li>Jabatan</li> </router-link>
                <router-link  to="Kehadiran"><li>Kehadiran</li> </router-link>
                <router-link  to="Payroll"><li>Payroll</li> </router-link>
                <router-link  to="Laporan"><li>Laporan</li> </router-link>
                <router-link  to="Cuti"><li>Cuti</li> </router-link>
                <router-link  to="Lembur"><li>Lembur</li> </router-link>
         
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
        // const items = document.querySelectorAll("ul li");
        // items.forEach((item) => {
        //     item.addEventListener("click", () => {
        //         document.querySelector("li.active").classList.remove("active");
        //         item.classList.add("active");
        //     });

        // });
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
 ul {
        list-style-type: none;
        background-color: white;
        display: flex;
        text-align: center;
        margin: 10px 10px;
        width: 60vw;
        justify-content: space-between;
        border-radius: 0;
        padding: 15px;
    }
    
    ul li {
        text-align: center;
        cursor: pointer;
        color: #124EB2;
        display: inline-block;
        position: relative;
    }
    
    ul li:hover {
        text-align: center;
        cursor: pointer;
        color: #E95A09;
        display: inline-block;
        position: relative;
        border-bottom: 3px solid #E95A09;
    }
     .router-link-exact-active li {
        color: #E95A09;
        font-weight: 500;
        border-bottom: 3px solid #E95A09;
    }
    
    .router-link-exact-active button {
        background-color: #E95A09;
        color: white;
        outline: none;
    }
</style>
