<template>
    <div>
        <div class="p-4 flex h-screen">
            <div class="font-sans p-6 w-auto max-h-full bg-gray-300 m-auto shadow-lg rounded-lg">
                <div class="md:flex md:justify-between block text-center">
                    <span class="md:block hidden text-3xl font-sans font-bold mt-12 mr-32 text-gray-900">DAP ICT Inventory</span>
                    <img :src="'img/vertical-logo.png'" class="h-32 w-24 m-auto">
                    <span class="md:hidden text-2xl font-sans font-bold text-gray-900">DAP ICT Inventory</span>
                </div>
                <form @submit.prevent="submit">
                    <div class="mb-4 mt-6">
                        <span class="text-gray-500 m-2 text-lg">E-mail</span>
                        <input type="text" name="email" v-model="credentials.email"  class="w-full h-10 p-3 text-lg rounded-md bg-gray-500 focus:bg-gray-400 focus:text-dapblue placeholder-dapblue" placeholder="Enter e-mail">

                    </div>
                    <div class="my-4">
                        <span class="text-gray-500 m-2 text-lg">Password</span>
                        <input type="password" name="password" v-model="credentials.password" class="w-full h-10 p-3 text-lg rounded-md bg-gray-500 focus:bg-gray-400 focus:text-dapblue placeholder-dapblue" placeholder="Enter password">
                    </div>
                    
                    <span v-if="error != ''" class="text-red-700 text-xs ml-2" role="alert">
                        <strong>{{error}}</strong>
                    </span>
                    <div class="mb-4 mt-8">
                        <button type="submit" class="w-full bg-dapyellow-100 p-2 rounded-md text-lg font-sans font-bold text-dapblue hover:shadow-lg">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios'

import {mapActions} from 'vuex'

export default {
    name: 'Login',
    data() {
        return {
            credentials : {
                email: '',
                password: ''
            },
            error: ''
        }
    },
    mounted() {

    },
    methods: {
        ...mapActions({
            login: 'auth/login'
        }),
        submit(){
            this.login(this.credentials).then(() => {
                this.$router.replace({
                    name:'dashboard'
                })
            }).catch(()=>{
                this.error = 'Email or Password is incorrect.'
            });
        }

    }
}
</script>

<style scoped>
svg{
  width: 120px;
  height: auto;
}
</style>