import { createApp } from "vue";
import VueToastification from 'vue-toastification'
import App from "./App.vue";
import store from "./store";
import router from "./router";
import axios from 'axios'
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import ArgonDashboard from "./argon-dashboard";
import { Form, HasError, AlertError } from 'vform'
import "vue-toastification/dist/index.css";
window.Form = Form;

const appInstance = createApp(App);
appInstance.config.globalProperties.$axios = axios;
appInstance.use(store);
appInstance.use(router);
appInstance.use(VueToastification, {
    transition: "Vue-Toastification__bounce",
    maxToasts: 20,
    newestOnTop: true
});
appInstance.use(ArgonDashboard);
appInstance.mount("#app");