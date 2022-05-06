<template>


    <div class="navbarcuy">
        <div>
        <a  style="margin-left:120px; font-weight: 600; font-size: 24px"> AMS</a>
        </div>
        <div style="float:right; margin-right: 20px; margin-top: 5px">
            <a><i class="fa-solid fa-user" style="font-size:22px"></i></a>
            <a style=" margin-left: -20px">{{ name }}</a>
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
.navbarcuy {
    width: 100%;
    background-color: #124EB2;
    overflow: auto;
    position: fixed;
    z-index: 6;
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


