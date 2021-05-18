import axios from 'axios'

export default {
    namespaced: true,
    state: {
        message: null,
        qr: null,
        view_data: null,
        items: [],
        status: null
    },
    getters: {
        responseMsg(state) {
            return state.message
        },
        responseDev(state) {
            return state.qr
        },
        get_items(state) {
            return state.items
        },
        get_items_status(state) {
            return state.status
        }
    },
    mutations: {
        getResponse(state, res) {
            state.message = res.message
            if(res.dev_id){
                state.qr = res.dev_id
            }
        },
        set_items(state, items) {
            state.items = items.result
            state.status = items.status
        }
    },
    actions: {
        async addItem({dispatch}, reqs) {
            if(reqs.ict_type == 'pc') {
                let response = await axios.post('/api/addPC', reqs)
                return dispatch('get', response.data)
            }
            else if(reqs.ict_type == 'other') {
                let response = await axios.post('/api/addOther', reqs)
                return dispatch('get', response.data)
            }
        },
        get({commit}, res) {
            if(res) {
                commit('getResponse', res)
            }
        },
        async updateItem(_, reqs) {
            let response = await axios.post('/api/updateICT', reqs)
            return response.data
        },
        async getItems({dispatch},rr) {
            let response = await axios.post('/api/admin/index', rr)
            return dispatch('setItems', response.data)
        },
        async setItems({commit}, items) {
            if(items) {
                commit('set_items', items)
            }
        },
        async navigateItems(_, rr) {
            let response = await axios.post('/api/admin/index?page='+rr.p, rr)
            return response.data
        },
        async getItem(_, dev_id) {
            let response = await axios.post('/api/view/'+dev_id)
            return response.data
        },
        async getDiag(_, get_cn) {
            let response = await axios.post('/api/diagnosis/'+get_cn)
            return response.data
        },
    }
}