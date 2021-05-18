import axios from 'axios'

export default {
    namespaced: true,
    state: {
        pc_permonth: [],
        others_permonth: [],
        diagnose_pc_permonth: [],
        diagnose_others_permonth: [],
        pc: [],
        others: [],
        status: 0
    },
    getters: {
        get_pc_data_permonth(state) {
            return state.pc_permonth
        },
        get_others_data_permonth(state) {
            return state.others_permonth
        },
        get_pc_data(state) {
            return state.pc
        },
        get_others_data(state) {
            return state.others
        },
        get_diagnose_pc_data_permonth(state) {
            return state.diagnose_pc_permonth
        },
        get_diagnose_others_data_permonth(state) {
            return state.diagnose_others_permonth
        },
        get_status(state) {
            return state.status
        },
    },
    mutations: {
        set_datas(state, datas) {
            state.pc_permonth = datas.all_pc_ict_permonth
            state.others_permonth = datas.all_others_ict_permonth
            state.pc = datas.all_pc_ict
            state.others = datas.all_others_ict
            state.diagnose_pc_permonth = datas.all_diagnose_pc_permonth
            state.diagnose_others_permonth = datas.all_diagnose_others_permonth
            state.status = datas.status
        }
    },
    actions: {
        async index({dispatch}) {
            let response = await axios.get('api/dashboard')
            return dispatch('fill_data', response.data)
        },
        async fill_data({commit}, datas){
            if(datas) {
                commit('set_datas', datas)
            }
        }
    }
}