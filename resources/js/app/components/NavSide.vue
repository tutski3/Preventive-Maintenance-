<template>
<div>
    <nav class="fixed z-50 font-sans flex content-center md:justify-between py-3 px-6 bg-dapblue text-gray-100 shadow w-full">
        <div class="inner flex item-center">
            <img  @click="showmenu = !showmenu" id="logo" :src="'img/applogo.png'" class="w-16 h-16 mx-3 cursor-pointer" :class="showmenu === false ? 'rotate' : 'rotate-back'">
            <span class="text-2xl font-sans font-bold mt-3">DAP ICT Inventory</span>
        </div>
        <div class="md:flex md:mb-0 self-center relative hidden">
            <span @click="showmenu2 = !showmenu2" class="text-gray-100 font-semibold py-2 px-4 rounded inline-flex items-center cursor-pointer">
                <span class="mr-3">{{ user.name }}</span> 
                <span class="ease-out transition-transform transition-medium" :style="showmenu2 === true ? 'transform:rotate(0deg)' : 'transform:rotate(180deg)'">
                    <i class="fas fa-chevron-up"></i>
                </span>
            </span>
            <div v-if="showmenu2">
                <div class="absolute z-30 right-0 mt-10">
                    <div class="bg-white rounded-lg shadow-xl py-3 w-48 text-dapblue">
                        <div class="py-2 w-full cursor-pointer hover:bg-gray-400 px-10" @click.prevent="profile"><i class="fas fa-user"></i> Profile</div>
                        <div v-if="user.name == 'John Alfred Serraon' || user.name == 'Joseph Tusay'" class="py-2 w-full cursor-pointer hover:bg-gray-400 px-10" @click.prevent="accounts"><i class="fas fa-users"></i> Accounts</div>
                        <div class="py-2 w-full cursor-pointer hover:bg-gray-400 px-10" @click.prevent="logout"><i class="fas fa-sign-out"></i> Logout</div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <transition name="slide">
        <div v-if="showmenu">
            <span @click="showmenu = !showmenu, showmenu2 = false" class="fixed top-0 right-0 bottom-0 left-0 h-full w-full bg-gray-500 opacity-75"></span>
            <div class="w-64 min-h-screen p-4 pt-24 bg-dapblue fixed left-0 top-0 shadow-2xl ease-in-out transition-transform transition-medium">
                <div class="flex justify-center">
                    <nav class="w-56 relative">
                        <span class="absolute h-12 p-2 mt-4 w-full bg-white rounded-lg shadow ease-out transition-transform transition-medium" :style="{ transform: `translateY(calc(150% * ${selected}))` }"></span>
                        <ul class="relative">
                            <li @click.prevent="dashboard">
                                <button type="button" @click="select(0)" :aria-selected="selected === 0" class="py-6 px-3 w-full flex items-center focus:outline-none focus-visible:underline">
                                <span :class="selected === 0 ? 'text-dapblue' : 'text-gray-200'">
                                    <i class="fas fa-home-lg-alt" style="font-size:20px"></i>
                                </span>
                                <span :class="selected === 0 ? 'text-dapblue font-bold' : 'text-gray-200 font-normal'" class="ml-2 text-md transition-all ease-out transition-medium">
                                    Dashboard
                                </span>
                                </button>
                            </li>
                            <li @click.prevent="main">
                                <button type="button" @click="select(1)" :aria-selected="selected === 1" class="py-6 px-3 w-full flex items-center focus:outline-none focus-visible:underline">
                                <span :class="selected === 1 ? 'text-dapblue' : 'text-gray-200'" >
                                    <i class="fas fa-inventory" style="font-size:20px"></i>
                                </span>
                                <span :class="selected === 1 ? 'text-dapblue font-bold' : 'text-gray-200 font-normal'" class="ml-2 text-lg transition-all ease-out transition-medium">
                                    ICT Inventory
                                </span>
                                </button>
                            </li>
                            <li @click.prevent="diagnosis">
                                <button type="button" @click="select(2)" :aria-selected="selected === 2" class="py-6 px-3 w-full flex items-center focus:outline-none focus-visible:underline">
                                <span :class="selected === 2 ? 'text-dapblue' : 'text-gray-200'" >
                                    <i class="fas fa-file-contract" style="font-size:20px"></i>
                                </span>
                                <span :class="selected === 2 ? 'text-dapblue font-bold' : 'text-gray-200 font-normal'" class="ml-2 text-lg transition-all ease-out transition-medium">
                                    Diagnosis
                                </span>
                                </button>
                            </li>
                            <li @click.prevent="clearance">
                                <button type="button" @click="select(3)" :aria-selected="selected === 3" class="py-6 px-3 w-full flex items-center focus:outline-none focus-visible:underline">
                                <span :class="selected === 3 ? 'text-dapblue' : 'text-gray-200'" >
                                    <i class="fas fa-file-alt" style="font-size:20px"></i>
                                </span>
                                <span :class="selected === 3 ? 'text-dapblue font-bold' : 'text-gray-200 font-normal'" class="ml-2 text-lg transition-all ease-out transition-medium">
                                    Clearance
                                </span>
                                </button>
                            </li>
                            <li @click.prevent="preventive_maintenance">
                                <button type="button" @click="select(4)" :aria-selected="selected === 4" class="py-6 px-3 w-full flex items-center focus:outline-none focus-visible:underline">
                                <span :class="selected === 4 ? 'text-dapblue' : 'text-gray-200'" >
                                    <i class="fas fa-file-alt" style="font-size:20px"></i>
                                </span>
                                <span :class="selected === 4 ? 'text-dapblue font-bold' : 'text-gray-200 font-normal'" class="ml-2 text-lg transition-all ease-out transition-medium">
                                    Preventive Maintenance
                                </span>
                                </button>
                            </li>
                            <li class="mt-8 md:hidden block ">
                                <button class="py-2 w-full bg-dapyellow-100 hover:bg-opacity-75 text-dapblue rounded-lg" @click.prevent="profile">Profile</button>
                                <button class="py-2 w-full bg-dapyellow-100 hover:bg-opacity-75 text-dapblue rounded-lg mt-2" @click.prevent="logout">Logout</button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </transition>

</div>
    
</template>

<script>
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'
export default {
    name:'NavSide',
    data() {
        return {
            selected: 0,
            showmenu: false,
            showmenu2: false,
        }
    },
    computed:{
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
        })
    },
    methods: {
        select(i) {
            this.selected = i;
        },
        ...mapActions({
            logoutAction: 'auth/logout',
            checkToken: 'auth/checkToken',
            logoutAction: 'auth/logout'
        }),
        logout() {
            this.logoutAction().then(() => {
                this.$router.replace({
                    name:'login'
                })
            })
        },
        profile() {
            this.$router.replace({
                name:'profile'
            });
            this.showmenu = false
            this.showmenu2 = false
        },
        accounts() {
            this.$router.replace({
                name:'accounts'
            });
            this.showmenu = false
            this.showmenu2 = false
        },
        dashboard() {
            this.$router.replace({
                name:'dashboard'
            });
            this.showmenu = false
            this.showmenu2 = false
        },
        main() {
            this.$router.replace({
                name:'main'
            });
            this.showmenu = false
            this.showmenu2 = false
        },
        diagnosis() {
            this.$router.replace({
                name:'diagnosis'
            });
            this.showmenu = false
            this.showmenu2 = false
        },
        clearance() {
            this.$router.replace({
                name:'clearance'
            });
            this.showmenu = false
            this.showmenu2 = false
        },
        preventive_maintenance() {
            this.$router.replace({
                name:'preventive_maintenance'
            });
            this.showmenu = false
            this.showmenu2 = false
        }
    },
    mounted() {
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
    }
}
</script>

<style scoped>
.ease-in {
  transition-timing-function: cubic-bezier(0.4, 0, 1, 1);
}
.ease-out {
  transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
}
.ease-in-out {
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.transition-fastest {
  transition-duration: 75ms;
}
.transition-faster {
  transition-duration: 100ms;
}
.transition-fast {
  transition-duration: 150ms;
}
.transition-medium {
  transition-duration: 200ms;
}
.transition-slow {
  transition-duration: 300ms;
}
.transition-slower {
  transition-duration: 500ms;
}
.transition-slowest {
  transition-duration: 700ms;
}

.transition-all {
  transition-property: all;
}
.transition-opacity {
  transition-property: opacity;
}
.transition-transform {
  transition-property: transform;
}

.focus-visible.focus-visible\:underline {
  text-decoration: underline;
}

.slide-enter-active,
.slide-leave-active
{
  transition: transform 0.4s ease;
}

.slide-enter,
.slide-leave-to {
  transform: translateX(-100%);
  transition: all 200ms ease-in 0s
}
</style>