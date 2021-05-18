<template>
    <div>
        <div class="pt-24 mx-auto w-full font-sans">
            <div class="w-full py-4 md:px-16 px-8">
                <span class="text-dapblue font-bold text-2xl">User Profile </span>
            </div>
        </div>
        <div class="block w-full md:px-10 px-8">
            <div class="md:flex block w-full h-auto md:p-4 p-0 md:mb-0 mb-16">
                <div class="w-full md:p-4 p-0 text-gray-800 md:m-6 m-0 mb-2">
                    <span class="text-xl font-semibold">Profile Information</span><br/>
                    <span class="text-sm">Update your account's profile information and email address.</span>
                </div>
                <div class="w-full p-4 rounded-md bg-gray-300 shadow-xl md:m-6 m-0">                   
                    <div class="my-4">
                        <p class="text-md">Name </p>
                        <input type="text" v-model="prInfo.name" class="md:w-8/12 w-full h-10 p-3 bg-gray-200 focus:bg-white border-dapyellow-100 border-2 rounded-lg" autocomplete="no">
                    </div>
                    <div class="mb-4 mt-6">
                        <p class="text-md">Email Address</p>
                        <input type="text" v-model="prInfo.email" class="md:w-8/12 w-full h-10 p-3 bg-gray-200 focus:bg-white border-dapyellow-100 border-2 rounded-lg" autocomplete="no">
                    </div>
                    <transition name="fade"
                    v-on:before-enter="enter">
                        <span v-if="show" class="text-gray-700 text-xs ml-2" role="alert">
                            <strong>{{message}}</strong>
                        </span>
                    </transition>
                    <div class="mb-4 mt-6 md:float-right">
                        <button @click.prevent="changeProfileInfo" class="w-32 py-2 text-center font-semibold bg-dapyellow-100 hover:bg-dapyellow-200 hover:shadow-xl rounded-md">Save</button>
                    </div>
                </div>
            </div>

            <div class="md:flex block w-full h-auto md:p-4 p-0">
                <div class="w-full md:p-4 p-0 text-gray-800 md:m-6 m-0 mb-2">
                    <span class="text-xl font-semibold">Update Password</span><br/>
                    <span class="text-sm">Ensure your account is using a long, random password to stay secure.</span>
                </div>
                <div class="w-full p-4 rounded-md bg-gray-300 shadow-xl md:m-6 m-0">
                    <div class="mb-4 mt-6">
                        <p class="text-md">New Password</p>
                        <input type="password" v-model="prPass.password" class="md:w-8/12 w-full h-10 p-3 bg-gray-200 focus:bg-white border-dapyellow-100 border-2 rounded-lg">
                    </div>
                    <div class="mb-4 mt-6">
                        <p class="text-md">Confirm New Password</p>
                        <input type="password" v-model="prPass.password_confirmation" class="md:w-8/12 w-full h-10 p-3 bg-gray-200 focus:bg-white border-dapyellow-100 border-2 rounded-lg">
                    </div>
                    <transition name="fade"
                    v-on:before-enter="enter">
                        <span v-if="show2" class="text-gray-700 text-xs ml-2" role="alert">
                            <strong>{{message2}}</strong>
                        </span>
                    </transition>
                    <div class="mb-4 mt-6 md:float-right">
                        
                        <button @click.prevent="changePassword" class="w-32 py-2 text-center font-semibold bg-dapyellow-100 hover:bg-dapyellow-200 hover:shadow-xl rounded-md">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {mapActions} from 'vuex'
export default {
    name:'Profile',
    data() {
        return {
            prInfo : {
                name: '',
                email: ''
            },
            prPass: {
                password:'',
                password_confirmation:''
            },
            message: null,
            message2: null,
            show: false,
            show2: false
        }
    },
    computed:{
        ...mapGetters({
            user: 'auth/user',
            messageGet: 'auth/message',
        })
    },
    mounted() {
        this.prInfo.name = this.user.name
        this.prInfo.email = this.user.email
		
		if(this.get_token !== '') {
            this.checkToken().then(res=>{
                if(!res.success) {
                    this.logoutAction().then(() => {
                        this.$router.replace({
                            name:'login'
                        })
                    })
                }
            })
        }
    },
    methods: {
        enter: function(el, done) {

            var that = this;

            setTimeout(function() {
                that.show = false;
                that.show2 = false;
            }, 3000); // hide the message after 3 seconds
        },

        ...mapActions({
            updateProfile: 'auth/updateProfile',
            updatePassword: 'auth/updatePassword',
            checkToken: 'auth/checkToken',
            logoutAction: 'auth/logout'
        }),

        changeProfileInfo() {
            this.updateProfile(this.prInfo).then(()=>{
                this.message = this.messageGet
                this.show = !this.show
            });
        },

        changePassword() {
            this.updatePassword(this.prPass).then(()=>{
                this.message2 = this.messageGet
                this.show2 = !this.show2
            });
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>