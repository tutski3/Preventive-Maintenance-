import axios from 'axios'

export default {
    namespaced: true,
    state: {
        flag: Boolean,
        token: null,
        user: null,
        message: null,
        users: []
    },
    getters: {
        authenticated(state) {
            return state.token && state.user
        },
        user(state) {
            return state.user
        },
        message(state) {
            return state.message
        },
        users(state) {
            return state.users
        }
    },
    mutations: {
        changeFlag(state, flag){
            state.flag = flag;
        },
        SET_USER(state, user) {
            state.user = user;
        },
        SET_TOKEN (state, token) {
            state.token = token;
        },
        clearToken(state) {
            localStorage.removeItem('auth')
            state.token = '';
        },
        setMessage(state, msg) {
            state.message = msg;
        },
        setUsers(state, users) {
            state.users = users;
        }
    },
    actions: {
        async login({dispatch}, credentials) {
            let response = await axios.post('/api/login', credentials);
            return dispatch('attempt', response.data.token);
        },
        async attempt ({ commit, state }, token) {
            if(token) {
                commit('SET_TOKEN',token)
            }

            if(!state.token) {
                return
            }

            try{
                let response = await axios.get('/api/me');

                commit('SET_USER', response.data)
            }
            catch(e){
                commit('SET_TOKEN', null)
                commit('SET_USER', null)
            }
        },
        logout({ commit }) {
            return axios.post('api/logout').then(()=>{
                commit('SET_TOKEN', null)
                commit('SET_USER', null)
            })
        },
        async updateProfile({dispatch},info){
            try {
                let response = await axios.post('/api/updateProfile', info);
                
                return dispatch('go', response.data.message);

            }
            catch(error) {
                let res;
                if(!error.response.data.errors.email){
                    res = error.response.data.errors.name[0]
                }
                else if(!error.response.data.errors.name){
                    res = error.response.data.errors.email[0]
                }
                else {
                    res = error.response.data.errors.name[0] + ' ' + error.response.data.errors.email[0]
                }
                return dispatch('go', res);
            }
        },
        async updatePassword({dispatch}, pass) {
            try {
                let response = await axios.post('/api/updatePassword', pass);
                return dispatch('go', response.data.message);

            }
            catch(error) {
                return dispatch('go', error.response.data.errors.password[0]);
            }
        },
        async go ({commit}, msg) {
            if(msg) {
                commit('setMessage',msg)
            }
        },
        async createUser(_, reqs) {
            let response = await axios.post('/api/createUser', reqs);
            return response.data;
        },
        async getUsers({dispatch}) {
            let response = await axios.get('/api/getUsers');
            return dispatch('get_users',response.data);
        },
        async get_users({commit}, users) {
            if(users) {
                commit('setUsers',users.result)
            }
        },
        async update_user(_, reqs) {
            let response = await axios.post('/api/updateUser', reqs);
            return response.data
        },
        async checkToken(_) {
            let response = await axios.post('/api/checkToken');
            return response.data
        }
    }
}