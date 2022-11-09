import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import axios from 'axios'
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import ArgonDashboard from "./argon-dashboard";
import { Form, HasError, AlertError } from 'vform'
import VueLazyload from "vue-lazyload";

window.Form = Form;
const appInstance = createApp(App);
app.config.globalProperties.$axios = axios;
appInstance.use(store);
appInstance.use(router);
appInstance.use(VueLazyload);
appInstance.use(ArgonDashboard);
appInstance.mount("#app");