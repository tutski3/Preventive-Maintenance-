require('./bootstrap');
import "tailwindcss/tailwind.css"
import Vue from 'vue';
import VueRouter from 'vue-router';
import { routes } from './app/routes';
import store from './app/store/index';
import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'

Vue.use(Chartkick.use(Chart))

require('./app/store/subscriber')

import NavSide from './app/components/NavSide';
import App from './app/App';

Vue.component('navside', NavSide);

const router = new VueRouter({
    routes,
    mode: 'history',
});

store.dispatch('auth/attempt', localStorage.getItem('token')).then(()=> {
    const app = new Vue({
        el: '#app',
        router:router,
        store:store,
        render:app =>app(App)
    });
});
