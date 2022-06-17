<template>

       <div class="tab-form">
           <div >
               <div class="tab-header">
                    <div class="active" @click="reset_admin" style=" font-size: 20px;font-weight: 500;">
                        Admin
                    </div>
                    <div @click="reset_peg" style=" font-size: 20px; font-weight: 500;"> Pegawai</div>
                </div>
           </div>
                
        <div class="tab-body" >
            <div class="signup active">
                <h2>Login Admin</h2>
                <form id="reset_admin">
                     <div class="input-field">
                        <i style="background:none" class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email Perusahaan" v-model="email" />
                    </div>
                    <div class="input-field">
                        <i style="background:none" class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" v-model="password"/>
                    </div>
                    <div class="form-input" @click="loginAdmin" >
                        <button type="submit">Masuk</button>
                    </div>
                </form>
            </div>
            
            <div class="login">
                <h2>Login Pegawai</h2>
                <form id="reset_peg">
                    <div class="input-field">
                        <i style="background:none" class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email Pegawai" v-model="email" />
                    </div>
                    <div class="input-field">
                        <i style="background:none" class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" v-model="password"/>
                    </div>
                    <div class="form-input" @click="loginPegawai">
                        <button type="submit" >Masuk</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</template>

<script>
import Dashboard from "./Dashboard";
export default {
    components: {Dashboard},
    mounted() {
        

        let tab = document.querySelector(".tab-form");
        let tabHeader = tab.querySelector(".tab-header");
        let tabHeaderElements = tab.querySelectorAll(".tab-header > div");
        let tabBody = tab.querySelector(".tab-body");
        let tabBodyElements = tab.querySelectorAll(".tab-body > div");

        for (let i = 0; i < tabHeaderElements.length; i++) {
        tabHeaderElements[i].addEventListener("click", function() {
            tabHeader.querySelector(".active").classList.remove("active");
            tabHeaderElements[i].classList.add("active");
            tabBody.querySelector(".active").classList.remove("active");
            tabBodyElements[i].classList.add("active");
        });

    }
    },
    data() {
        return {
            email: "",
            password: "",
            role :"",
            error: null,
            loggedIn: localStorage.getItem("loggedIn"),
            token: localStorage.getItem("token"),

        }
    },
    methods: {
        reset_admin() {
        document.getElementById("reset_admin").reset();
        localStorage.clear()
        },
        reset_peg() {
        document.getElementById("reset_peg").reset();
        localStorage.clear();
        },

        loginAdmin(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    })
                        .then(response => {
                            console.log(response.data)
                            if (response.data.success) {
                                window.localStorage.setItem("loggedIn", true)
                                window.localStorage.setItem("token", response.data.token)
                                window.localStorage.setItem("role", response.data.user.role)
                                window.localStorage.setItem("name", response.data.user.name)

                                if (response.data.user.role == 'Manager') {
                                    this.$router.push("/ManagerDashboard")
                                } else if (response.data.user.role == 'Admin') {
                                    this.$router.push("/AdminDashboard")
                                } else if (response.data.user.role == 'Pegawai') {
                                    this.$router.push("/PegawaiDashboard")
                                }
                                this.loggedIn = true;
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }
        },
        loginPegawai(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/loginpegawai', {
                        email: this.email,
                        password: this.password
                    })
                        .then(response => {
                            console.log(response.data)
                            if (response.data.success) {
                                window.localStorage.setItem("loggedIn", true)
                                window.localStorage.setItem("token", response.data.token)
                                window.localStorage.setItem("role", response.data.user.role)
                                window.localStorage.setItem("name", response.data.user.name)

                                if (response.data.user.role == 'Manager') {
                                    this.$router.push("/ManagerDashboard")
                                } else if (response.data.user.role == 'Admin') {
                                    this.$router.push("/AdminDashboard")
                                } else if (response.data.user.role == 'Pegawai') {
                                    this.$router.push("/PegawaiDashboard")
                                }
                                this.loggedIn = true;
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (JSON.parse(window.localStorage.getItem("loggedIn"))) {
            if (window.localStorage.getItem("role") == 'Manager') {
                return next("/ManagerDashboard");
            } else if (window.localStorage.getItem("role") == 'Admin') {
                return next("/AdminDashboard");
            } else if (window.localStorage.getItem("role") == 'Pegawai') {
                return next("/PegawaiDashboard");
            }
        }
        next();
    },

}
</script>

<style scoped>
 * {
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
        background-color: white;
        border-radius: 10px;
        
    }
    
    body {
        background: rgb(237, 237, 237);
        
    }
    .input-field {

    max-width: 380px;
    width: 100%;
    background-color: #f0f0f0;
    margin: 18px 0;
    height: 55px;
    border-radius: 7px;
    display: grid;
    grid-template-columns: 15% 85%;
    padding: 0 0.4rem;
    position: relative;
}

.input-field i {
    text-align: center;
    line-height: 55px;
    color: #acacac;
    transition: 0.5s;
    font-size: 1.1rem;
}

.input-field input {
    background: none;
    outline: none;
    border: none;
    line-height: 1;
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
}

.input-field input::placeholder {
    color: #aaa;
    font-weight: 500;
}
    .tab-form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 95%;
        max-width: 400px;
        box-shadow: 10px 10px 5px 10px rgba(0, 0, 0, 0.08);
    }
    
    .tab-form .tab-header {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        /* background-color: #124EB2; */
    }
    
    .tab-form .tab-header>div {
        flex: 1;
        padding: 10px;
        text-align: center;
        color: #124EB2;
        margin: 10px;
        background-color: #f0f0f0;;
        cursor: pointer;
        border-radius: 7px;
    }
    
    .tab-form .tab-header>div.active {
        border-radius: 10px;
        color: white;
        background-color: #124EB2;
    }
    
    .tab-form .tab-body {
        position: relative;
        min-height: 360px;
        overflow: hidden;
    }
    
    .tab-form .tab-body>div {
        position: absolute;
        width: 100%;
        top: -150vh;
        opacity: 0;
        padding: 5px 25px;
        transition: opacity 300ms ease-in-out;
    }
    
    .tab-form .tab-body>div.active {
        top: 0px;
        opacity: 1;
        transition: opacity 300ms ease-in-out;
    }
    
    .tab-form .tab-body>div h2 {
        font-size: 25px;
        color: #124EB2;
        text-align: center;
        margin-bottom: 20px;
    }
    
    .tab-form .tab-body>div .form-input {
        margin: 10px 0px;
    }
    
    .tab-form .tab-body>div .form-input label {
        display: block;
        font-size: 15px;
    }
    
    .tab-form .tab-body>div .form-input input {
        border-radius: 7px;
        width: 100%;
        color: #124EB2;
        margin-top: 10px;
        font-size: 15px;
        padding: 8px;
    }
    
    .tab-form .tab-body>div .form-input button {
        width: 100%;
        color: white;
        margin-top: 70px;
        padding: 10px;
        border: none;
        outline: none;
        cursor: pointer;
        background-color: #124EB2;
        border-radius: 7px;
    }
</style>
