
import Vue from 'vue';
import VueRouter from 'vue-router';
import MainApp  from './components/MainApp';
import Vuex from 'vuex';
import {routes} from './routes';
import StoreData from './store';
import vueKanban from 'vue-kanban'
import plugins from './plugins.js'


Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(vueKanban);

require('./bootstrap');

window.Vue = require('vue');

const store = new Vuex.Store(StoreData);


Vue.use(plugins);

const router =  new VueRouter({
    routes,
    mode:'history'
});

const app = new Vue({
    el: '#app',
    router,
    store,
    plugins,
    components:{
        MainApp,
    }
});
