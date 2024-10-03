import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import router from "./router";
// PLUGINS
import http from "./plugins/axios";
import PluginOptions from "./plugins/toastification";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const app = createApp(App);

app.provide("http", http);
app.use(Toast, PluginOptions);
app.use(router);
app.mount("#app");
