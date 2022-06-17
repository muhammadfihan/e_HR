<template>
    <nav class="navbar navbar-expand-lg fixed-top" style="height:70px;background-color: #124EB2;" >
        <a class="navbar-brand" style="color:white;margin-left:35px;font-size: 27px;font-weight: 500;">AMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
            <ul class="navbar-nav mr-auto" style=" margin-left: 10px;"  >
            </ul>
            <ul class="nav navbar-nav navbar-right" style="margin-right:10px;margin-top:8px;" v-if="role === 'Admin'">
                <li class="nav-item active">
                    <a class="nav-link ">  <router-link  to="AdminDashboard"><li class="active" style="color:white;">Dashboard</li></router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link">  <router-link  to="DataPegawai"><li style="color:white;">Data Pegawai</li> </router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link">  <router-link  to="AkunPegawai"><li style="color:white;">Data User</li> </router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link"> <router-link  to="Jabatan"><li style="color:white;">Jabatan</li> </router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link"> <router-link  to="Kehadiran"><li style="color:white;">Kehadiran</li> </router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link"> <router-link  to="Payroll"><li style="color:white;">Payroll</li> </router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link"> <router-link  to="Laporan"><li style="color:white;">Laporan</li> </router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link">  <router-link  to="Cuti"><li style="color:white;">Cuti</li> </router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link"> <router-link  to="Lembur"><li style="color:white;margin-right: 20px;">Lembur</li> </router-link></a>
                </li>
                <div class="btn-group" style="margin-bottom:4px">
                    <button type="button"  class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:7px;background-color:white;color:#124EB2; outline:none;"><i class="fa-solid fa-user" style="font-size:19"></i>
                    {{ name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" style="text-align:center;font-weight: 500;">{{ role }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" style="cursor:pointer">Pengaturan Profile</a>
                    <a class="dropdown-item" style="cursor:pointer" @click="logout">Logout</a>
                    </div>
                </div>
            </ul>
                 <ul class="nav navbar-nav navbar-right" style="margin-right:10px;margin-top:8px;" v-if="role === 'Pegawai'">
                <li class="nav-item active">
                    <a class="nav-link ">  <router-link  to="PegawaiDashboard"><li class="active" style="color:white;">Dashboard</li></router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link">  <router-link  to="Absen"><li style="color:white;">Absensi</li></router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link">  <router-link  to="LaporanHarian"><li style="color:white;">Laporan Tugas</li></router-link></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link">  <router-link  to="Pengajuan"><li style="color:white;">Pengajuan</li></router-link></a>
                </li>
                 <li class="nav-item ">
                    <a class="nav-link"><router-link  to="GajiPegawai"><li style="color:white;margin-right: 20px;">Penggajian</li></router-link></a>
                </li>
                <div class="btn-group" style="margin-bottom:4px">
                    <button type="button"  class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:7px;background-color:white;color:#124EB2; outline:none;"><i class="fa-solid fa-user" style="font-size:19"></i>
                    {{ name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" style="text-align:center;font-weight: 500;">{{ role }}</a>
                    <div class="dropdown-divider"></div>
                     <a class="dropdown-item" style="cursor:pointer" >Pengaturan Profile</a>

                    <a class="dropdown-item" style="cursor:pointer" @click="logout">Logout</a>
                    </div>
                </div>
            </ul>
        </div>
</nav>

</template>
<script>

export default {
        data() {
            return {
                loggedIn: localStorage.getItem("loggedIn"),
                token: localStorage.getItem("token"),
                name: localStorage.getItem("name"),
                role: localStorage.getItem("role")
            };
        },
        methods: {
            logout() {
                axios.post('/api/logout', {
                        tok: this.token
                    },
                    {
                        headers: {
                            Authorization: "Bearer " + this.token
                        }
                    }).then((response) => {
                    window.location.reload();
                    localStorage.clear()
                    return this.$router.push({ name: "Login" });
                })
            },
        },

        mounted() {
            if (!this.loggedIn) {
                return this.$router.push({name: "Login"});
            }
        },

}

</script>

<style scoped>
ul {
        list-style-type: none;
        
   
    }
a {
    font-weight: 300;
}
    
    /* ul li {
        font-weight: 350;
        text-align: center;
        cursor: pointer;
        color: white;
        font-size: 16px;
        display: inline-block;
        position: relative;
    }
    
    ul li:hover {
        text-align: center;
        cursor: pointer;
        color:#124EB2;
        display: inline-block;
        position: relative;
        border-bottom: 3px solid #E95A09;
    } */
    .router-link-exact-active li {
        font-weight: 400;
        border-bottom: 3px solid #E95A09;
    }
    
    .router-link-exact-active button {
        background-color: #E95A09;
        color: white;
        outline: none;
    }
.navbarcuy {
    width: 100%;
    height: 8.5%;
    background-color: #124EB2;
    overflow: auto;
    position: fixed;
    z-index: 6;
    box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.25);
}
.navbarcuy .search-container {
    float: left;
    margin-top: 10px;
    padding-left: 200px;

}
bodysearch{
    background: #f2f2f2;
}
.search {
    width: 100%;
    position: relative;
    display: flex;
}

.searchTerm {
    width: 100%;
    border: 0px solid white;
    border-right: none;
    padding: 5px;
    height: 30px;
    font-weight:400;
    font-size: 15px;
    border-radius: 5px 0 0 5px;
    outline: none;
    color: #9DBFAF;
}

.searchTerm:focus{
    color: #124EB2;
}

.searchButton {
    width: 40px;
    height: 30px;
    border: 0px solid #ffffff;
    background: #ffffff;
    text-align: center;
    color: #bbbbbb;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    font-size: 20px;
}


.navbarcuy a {

    float: left;
    padding: 16px;
    color: white;
    text-decoration: none;
    font-size: 17px;
}
.navbarcuy a:hover {

    color: white;

}
</style>


