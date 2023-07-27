import Vue from 'vue';
import CardPages from "./pages/CardPages";
import TariffPages from "./pages/TariffPages";
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
require('./bootstrap');

const app = new Vue({
    el: '#app',
    components:{
        CardPages,
        TariffPages
    }
});
