import Vuex from 'vuex';
import Vue from 'vue';
import auth from './auth'
import ict from './ict'
import diags from './diags'
import clearance from './clearance'
import dashboard from './dashboard'
import prev_maintenance from './prev_maintenance'

Vue.use(Vuex);


export default new Vuex.Store({
    state: {
        
    },
    mutations: {

    },
    actions: {
        
    },
    modules: {
        auth,
        ict,
        diags,
        clearance,
        dashboard,
        prev_maintenance
    }
});