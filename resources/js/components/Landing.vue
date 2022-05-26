<template>

  <div class="navbarcuy">
        <div>
        <a  style="margin-left:60px; margin-top: 10px; font-weight: 400; font-size: 32px"> AMS</a>
        </div>
        <div style="float:right; margin-right: 50px; margin-top: 20px;">
            <button @click="Daftar()" style="margin-right: 18px;" class="tmbl2">Daftar</button>
            <button @click="Login()" class="tmbl3">Login</button>
            
        </div>
        <div style="float:right; margin-right: 17px; margin-top: 6px;">
            <div>
            <ul>
                <router-link  to="/"><li class="active">Home</li></router-link>
                <router-link  to="About Us"><li>About Us</li></router-link>
                <router-link  to="Contact"><li>Contact</li></router-link>
                <router-link  to="Our Team"><li>Our Team</li></router-link>
                  
               
            </ul>
        </div>

        </div>         
        
    </div>
   

    <div class="wave-container">
        <div class="container" style="">
            
            <div  style="text-align: end;">
            <img :src="'/images/cobasaja.svg'" width="450" height="480" style="margin-right:-125px;margin-top: 60px;" />
            
             </div>
             <div style="margin-top: -400px; margin-left: 100px;">
                <p style="border-radius: 15px;font-size:2.8vw;color:white; font-weight: 600;">HRIS App Management</p>
                <p style="font-size:2.35vw;color:white;">Employee Management</p>
                 <a style="font-size:1.7vw;color:white;">Human Resource And Payroll Management App</a>
                 <p><button @click="Daftar()" class="tmbl4" >Coba</button></p>
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
         Login(){
            this.$router.push('/Login'); 
      },
       Daftar(){
            this.$router.push('/Register'); 
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
  .wave-container {
        height: 80vh;
        width: 100%;
     background-image: linear-gradient(0deg, #124EB2 2%, #124EB2 100%);
        position: relative;
    }
    
    .wave-container::before {
        content: "";
        width: 100%;
        height: 75px;
        position: absolute;
        bottom: -0.3%;
        left: 0;
        background-size: auto;
        background-repeat: repeat no-repeat;
        background-position: 14vw bottom;
        background-image: url("data:image/svg+xml;utf8,<svg viewBox='0 0 1200  105' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M0 77L50 72C100 68 200 58 300 39C400 20 500 -8 600 1C700 11 800 58 900 77C1000 96 1100 87 1150 82L1200 77V106H1150C1100 106 1000 106 900 106C800 106 700 106 600 106C500 106 400 106 300 106C200 106 100 106 50 106H0V77Z' fill='%23ffffff'/></svg>");
    }
    
    @media(max-width:850px) {
        .wave-container::before {
            height: 37.5px
        }
    }

@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@200;300;400;500;600;700;800&display=swap");

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
 ul{
    list-style-type: none;
}
 
    ul li {
        text-align: center;
        cursor: pointer;
        color: white;
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
    list-style-type: none;
        color: white;
        font-weight: 500;
        border-bottom: 3px solid #E95A09;
}
    
.router-link-exact-active button {
        background-color: #E95A09;
        color: white;
        outline: none;
}
.navbarcuy {
    width: 100%;
    height: 12%;
    background-color: #124EB2;
    overflow: auto;
    position: fixed;
    z-index: 6;
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
    margin-top: 15px;
    height: 50px;
    border-radius: 10px; 
    float: left;
    padding: 16px;
    color: white;
    text-decoration: none;
    font-size: 17px;
    
}
.navbarcuy a:hover {

    color: white;

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
    width: 90px;
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
.tmbl2 {

    width: 90px;
    background-color: #ffffff;
    border: none;
    font-size: 0.9em;
    outline: none;
    height: 41px;
    border-radius: 10px;
    color: #124EB2;
    text-transform: uppercase;
    font-weight: 600;
    margin: 10px 0;
    cursor: pointer;
    transition: 0.5s;
}
.tmbl3 {

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

/* .tmbl:hover {
    background-color: #E95A09;
}
.tmbl2:hover {
    color: white;
    background-color: #E95A09;
} */
.tmbl4:hover {
    color: #124EB2;
    background-color: white;
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
