import axios from 'axios'

export default {
    namespaced: true,
    state: {
        all_clearance: [],
        status: null
    },
    getters: {
        get_clearance(state) {
            return state.all_clearance
        },
        get_clearance_status(state) {
            return state.status
        }
    },
    mutations: {
        set_clearance(state, clearance) {
            state.all_clearance = clearance.result
            state.status = clearance.status
        }
    },
    actions: {
        async createClearance(_, reqs) {
            let response = await axios.post('/api/clearance/create', reqs)
            return response.data
        },
        async getClearances({dispatch}) {
            let response = await axios.get('/api/clearance/index')
            return dispatch('setClearance', response.data)
        },
        async setClearance({commit}, clearance) {
            if(clearance) {
                commit('set_clearance', clearance)
            }
        },
        async getClearance(_, get_cn) {
            let response = await axios.post('/api/clearance/'+get_cn)
            return response.data
        },
    }
}