import axios from 'axios'

export default {
    namespaced: true,
    state:{
        datas: [],
        status
    },
    getters: {
        get_datas(state) {
            return state.datas
        },
        get_status(state) {
            return state.status
        }
    },
    mutations: {
        set_datas(state, data) {
            state.datas = data.data
            state.status = data.status
        }
    },
    actions: {
        async getDatas({dispatch}, range) {
            let response = await axios.post('/api/preventive_maintenance/index', range)
            return dispatch('setDatas', response.data)
        },
        async setDatas({commit}, data) {
            if(data) {
                commit('set_datas', data)
            }
        },
    }
}