import axios from 'axios'

export default {
    namespaced: true,
    state:{
        diags: [],
        status: null
    },
    getters: {
        diags(state) {
            return state.diags
        },
        get_diagnosis_status(state) {
            return state.status
        }
    },
    mutations: {
        set_diags(state, diagnosis) {
            state.diags = diagnosis.result
            state.status = diagnosis.status
        }
    },
    actions: {
        async searchPN(_, val) {
            let response = await axios.post('api/diagnosis/search/'+val)
            return response.data
        },
        async getItem(_, dev_id) {
            let response = await axios.post('/api/view/'+dev_id)
            return response.data
        },
        async createDiags(_, reqs) {
            let response = await axios.post('/api/diagnosis/create', reqs)
            return response.data
        },
        async getDiags({dispatch}, rr) {
            let response = await axios.post('/api/diagnosis/index', rr)
            return dispatch('setDiags', response.data)
        },
        async setDiags({commit}, diags) {
            if(diags) {
                commit('set_diags', diags)
            }
        },
        async getDiag(_, get_cn) {
            let response = await axios.post('/api/diagnosis/'+get_cn)
            return response.data
        },
    }
}