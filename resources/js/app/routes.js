import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store/index';

import Login from './Login';
import Dashboard from './components/Dashboard';
import Profile from './components/Profile';
import Accounts from './components/Accounts';
import Main from './components/Main';
import Diagnosis from './components/Diagnosis';
import Clearance from './components/Clearance';
import PreventiveMaintenance from './components/PreventiveMaintenance';


Vue.use(VueRouter);


export const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter: (to, from, next) => {
            if(store.getters['auth/authenticated']) {
                return next({
                    name:'dashboard'
                })
            }
            next()
        }
    },
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard,
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']) {
                return next({
                    name:'login'
                })
            }
            next()
        }
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']) {
                return next({
                    name:'login'
                })
            }
            next()
        }
    },
    {
        path: '/accounts',
        name: 'accounts',
        component: Accounts,
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']) {
                return next({
                    name:'login'
                })
            }
            next()
        }
    },
    {
        path: '/ict-inventory',
        name: 'main',
        component: Main,
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']) {
                return next({
                    name:'login'
                })
            }
            next()
        }
    },
    {
        path: '/diagnosis',
        name: 'diagnosis',
        component: Diagnosis,
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']) {
                return next({
                    name:'login'
                })
            }
            next()
        }
    },
    {
        path: '/clearance',
        name: 'clearance',
        component: Clearance,
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']) {
                return next({
                    name:'login'
                })
            }
            next()
        }
    },
    {
        path: '/preventive_maintenance',
        name: 'preventive_maintenance',
        component: PreventiveMaintenance,
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']) {
                return next({
                    name:'login'
                })
            }
            next()
        }
    }

];