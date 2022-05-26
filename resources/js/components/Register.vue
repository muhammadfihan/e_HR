<template>
    <div class="navbara">
        <div class="forms-navbara">
            <div class="signin-signup">

                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>

                <form class="sign-in-form">
                     <h2 class="title">Daftar</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" v-model="name" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email Perusahaan" v-model="email"/>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-building-user"></i>
                        <input type="text" placeholder="Nama Perusahaan" v-model="nama_perusahaan"/>
                    </div>
                    <div class="input-field">
                        <i  class="fa-solid fa-user-tie"></i>
                        <input type="text" placeholder="Jabatan" v-model="jabatan" />
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-users"></i>
                        <input type="text" placeholder="Jumlah Karyawan" v-model="jumlah_karyawan" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" v-model="password"/>
                    </div>
                    <input type="submit" class="tmbl" value="Daftar" @click="register" />
                </form>
                <form  class="sign-up-form">
                    <h2 class="title">Daftar</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Username" v-model="name" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email/Email Perusahaan" v-model="email"/>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-building-user"></i>
                        <input type="text" placeholder="Nama Perusahaan" v-model="nama_perusahaan"/>
                    </div>
                    <div class="input-field">
                        <i  class="fa-solid fa-user-tie"></i>
                        <input type="text" placeholder="Jabatan" v-model="jabatan" />
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-users"></i>
                        <input type="text" placeholder="Jumlah Karyawan" v-model="jumlah_karyawan" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" v-model="password"/>
                    </div>
                    <input type="submit" class="tmbl" value="Daftar" @click="register" />
                </form>
            </div>
        </div>

        <div class="panels-navbara">
            <div class="panel left-panel">
                <div class="content">
                    <h3>HR Management AMS</h3>
                    <p style="font-size: 1em">
                        HR Management AMS hadir untuk memudahkan pengelolaan kepegawaian dan kehadiran karyawan serta payroll untuk memudahkan penggajian
                    </p>
                    <p>
                        Daftarkan Perusahaan Anda
                    </p>
                    <button class="tmbl4" @click="Landing" >
                        Home
                    </button>
                </div>
                <img :src="'/images/login.svg'"  class="image" alt="" />
            </div>
        </div>
    </div>
</template>

<script>
import Dashboard from "./Dashboard";
export default {
    components: {Dashboard},
    mounted() {

    },
    data() {
        return {
            name: "",
            email: "",
            password: "",
            nama_perusahaan:"",
            jabatan : "",
            jumlah_karyawan: "",
            role :"",
            error: null,
            loggedIn: localStorage.getItem("loggedIn"),
            token: localStorage.getItem("token"),

        }
    },
    methods: {
       Landing(){
            this.$router.push('/'); 
      },
        register(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/register', {
                        name: this.name,
                        email: this.email,
                        nama_perusahaan:this.nama_perusahaan,
                        jabatan:this.jabatan,
                        jumlah_karyawan:this.jumlah_karyawan,
                        role:this.role,
                        password: this.password
                    })
                        .then(response => {
                            if (response.data.success) {
                                window.location.href = "/"

                            }else {
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });

                })
            }
        },
        login(e) {
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
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@200;300;400;500;600;700;800&display=swap");

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body,
input {
    font-family: "Roboto", sans-serif;
}

.navbara {
    position: relative;
    width: 100%;
    background-color: #fff;
    min-height: 100vh;
    overflow: hidden;
}
.tmbl4 {

    width: 90px;
    background-color: #E95A09;
    border: none;
    font-size: 0.9em;
    outline: none;
    height: 41px;
    border-radius: 10px;
    color: white;
    text-transform: uppercase;
    font-weight: 600;
    margin: 10px 0;
    cursor: pointer;
    transition: 0.5s;
}
.tmbl4:hover {
    color: #124EB2;
    background-color: white;
}

.forms-navbara {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

.signin-signup {
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
    left: 75%;
    width: 50%;
    transition: 1s 0.7s ease-in-out;
    display: grid;
    grid-template-columns: 1fr;
    z-index: 5;
}

form {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0rem 5rem;
    transition: all 0.2s 0.7s;
    overflow: hidden;
    grid-column: 1 / 2;
    grid-row: 1 / 2;
}

form.sign-up-form {
    opacity: 0;
    z-index: 1;
}

form.sign-in-form {
    z-index: 2;
}

.title {
    font-size: 2.2rem;
    color: #444;
    margin-bottom: 10px;
}

.input-field {
    max-width: 380px;
    width: 100%;
    background-color: #f0f0f0;
    margin: 10px 0;
    height: 55px;
    border-radius: 15px;
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
.boxpilih {
    background-color: transparent;
    border-radius: 15px;
    margin-left: -4px;
    font-size: 1.1rem;
    font-family:Roboto;
    font-weight: 500;
    color: #acacac;
    border: none;
    overflow: hidden;
}

.social-text {
    padding: 0.7rem 0;
    font-size: 1rem;
}

.social-media {
    display: flex;
    justify-content: center;
}

.social-icon {
    height: 46px;
    width: 46px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 0.45rem;
    color: #333;
    border-radius: 50%;
    border: 1px solid #333;
    text-decoration: none;
    font-size: 1.1rem;
    transition: 0.3s;
}

.social-icon:hover {
    color: #E95A09;
    border-color: #E95A09;
}
.input-select {
    max-width: 380px;
    width: 100%;
    background-color: #f0f0f0;
    margin: 10px 0;
    height: 55px;
    border-radius: 15px;
    display: grid;
    grid-template-columns: 15% 85%;
    padding: 0 0.4rem;
    position: relative;
}

.input-select i {
    text-align: center;
    line-height: 55px;
    color: #acacac;
    transition: 0.5s;
    font-size: 1.1rem;
}

.input-select input {
    background: none;
    outline: none;
    border: none;
    line-height: 1;
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
}

.input-select input::placeholder {
    color: #aaa;
    font-weight: 500;
}

.tmbl {
    width: 130px;
    background-color: #E95A09;
    border: none;
    font-size: 0.8rem;
    outline: none;
    height: 41px;
    border-radius: 15px;
    color: #fff;
    text-transform: uppercase;
    font-weight: 600;
    margin: 10px 0;
    cursor: pointer;
    transition: 0.5s;
}

.tmbl:hover {
    background-color: #E95A09;
}
.panels-navbara {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}

.navbara:before {
    content: "";
    position: absolute;
    height: 2000px;
    width: 2000px;
    top: -10%;
    right: 48%;
    transform: translateY(-50%);
    background-image: linear-gradient(-45deg, #124EB2 0%, #124EB2 100%);
    transition: 1.8s ease-in-out;
    border-radius: 50%;
    z-index: 6;

}

.image {
    width: 100%;
    transition: transform 1.1s ease-in-out;
    transition-delay: 0.4s;
}

.panel {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    justify-content: space-around;
    text-align: center;
    z-index: 6;
}

.left-panel {
    pointer-events: all;
    padding: 3rem 17% 2rem 12%;
}

.right-panel {
    pointer-events: none;
    padding: 3rem 12% 2rem 17%;
}

.panel .content {
    color: #fff;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.6s;
}

.panel h3 {
    font-weight: 600;
    line-height: 1;
    font-size: 1.5rem;
}

.panel p {
    font-size: 0.95rem;
    padding: 0.7rem 0;
}

.tmbl.transparent {
    margin: 0;
    background: #E95A09;
    border: none;
    width: 130px;
    height: 41px;
    font-weight: 600;
    font-size: 0.8rem;
}

.right-panel .image,
.right-panel .content {
    transform: translateX(800px);
}

/* ANIMATION */

.navbara.sign-up-mode:before {
    transform: translate(100%, -50%);
    right: 52%;
}

.navbara.sign-up-mode .left-panel .image,
.navbara.sign-up-mode .left-panel .content {
    transform: translateX(-800px);
}

.navbara.sign-up-mode .signin-signup {
    left: 25%;
}

.navbara.sign-up-mode form.sign-up-form {
    opacity: 1;
    z-index: 2;
}

.navbara.sign-up-mode form.sign-in-form {
    opacity: 0;
    z-index: 1;
}

.navbara.sign-up-mode .right-panel .image,
.navbara.sign-up-mode .right-panel .content {
    transform: translateX(0%);
}

.navbara.sign-up-mode .left-panel {
    pointer-events: none;
}

.navbara.sign-up-mode .right-panel {
    pointer-events: all;
}

@media (max-width: 870px) {
    .navbara {
        min-height: 800px;
        height: 100vh;
    }
    .signin-signup {
        width: 100%;
        top: 95%;
        transform: translate(-50%, -100%);
        transition: 1s 0.8s ease-in-out;
    }

    .signin-signup,
    .navbara.sign-up-mode .signin-signup {
        left: 50%;
    }

    .panels-navbara {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 2fr 1fr;
    }

    .panel {
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        padding: 2.5rem 5%;
        grid-column: 1 / 2;
    }

    .right-panel {
        grid-row: 3 / 4;
    }

    .left-panel {
        grid-row: 1 / 2;
    }

    .image {
        width: 200px;
        transition: transform 0.9s ease-in-out;
        transition-delay: 0.6s;
    }

    .panel .content {
        padding-right: 15%;
        transition: transform 0.9s ease-in-out;
        transition-delay: 0.8s;
    }

    .panel h3 {
        font-size: 1.2rem;
    }

    .panel p {
        font-size: 0.7rem;
        padding: 0.5rem 0;
    }

    .tmbl.transparent {
        width: 110px;
        height: 35px;
        font-size: 0.7rem;
    }

    .navbara:before {
        width: 1500px;
        height: 1500px;
        transform: translateX(-50%);
        left: 30%;
        bottom: 72%;
        right: initial;
        top: initial;
        transition: 2s ease-in-out;
    }

    .navbara.sign-up-mode:before {
        transform: translate(-50%, 100%);
        bottom: 22%;
        right: initial;
    }

    .navbara.sign-up-mode .left-panel .image,
    .navbara.sign-up-mode .left-panel .content {
        transform: translateY(-300px);
    }

    .navbara.sign-up-mode .right-panel .image,
    .navbara.sign-up-mode .right-panel .content {
        transform: translateY(0px);
    }

    .right-panel .image,
    .right-panel .content {
        transform: translateY(300px);
    }

    .navbara.sign-up-mode .signin-signup {
        top: 2%;
        transform: translate(-50%, 0);
    }
}

@media (max-width: 570px) {
    form {
        padding: 0 2rem;
    }

    .image {
        display: none;
    }
    .panel .content {
        padding: 0.5rem 1rem;
    }
    .navbara {
        padding: 1.5rem;
    }

    .navbara:before {
        bottom: 72%;
        left: 50%;
    }

    .navbara.sign-up-mode:before {
        bottom: 10%;
        left: 50%;
    }
}
select:focus{
    outline: none;
}

</style>
