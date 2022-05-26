<template>


    <div class="navbarcuy">
        <div>
        <a  style="margin-left:120px; font-weight: 600; font-size: 24px"> AMS</a>
        </div>
         <div style="float:left; margin-left: 20px; margin-top: 5px" v-if="role === 'Admin'">
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
        
        <div style="float:right; margin-right: 20px; margin-top: 5px">
            <a> <i class="fa-solid fa-message" style="font-size:19"></i></a>
            <a> <i class="fa-solid fa-bell" style="font-size:19"></i></a>
            <a><i class="fa-solid fa-user" style="font-size:19"></i></a>
            
            <!-- <a style=" margin-left: -20px">{{ name }}</a> -->
            <a style="cursor:pointer;" @click="logout">Logout</a>
            
        </div>
        
    </div>

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
                    localStorage.clear()
                    return this.$router.push({ name: "Landing" });
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
    
    ul li {
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
        display: inline-block;
        position: relative;
        border-bottom: 3px solid #E95A09;
    }
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


