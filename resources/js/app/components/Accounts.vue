<template>
    <div class="pt-24 mx-auto w-full font-sans overflow-hidden">
        <transition name="fade">
            <div v-if="err" class="fixed z-40 top-0 w-full h-16 bg-red-700 opacity-75 mt-20 text-center p-6">
                <span class="text-white py-4 font-semibold">{{errMsg}}</span>
            </div>
        </transition>
        <transition name="fade">
            <div v-if="success" class="fixed z-40 top-0 w-full h-16 bg-green-700 opacity-75 mt-20 text-center p-6">
                <span class="text-white py-4 font-semibold">{{successMsg}}</span>
            </div>
        </transition>
        <div class="w-full py-4 md:px-16 px-8">
            <span class="text-dapblue font-bold text-2xl">User Accounts</span>
            <div class="my-2 font-semibold">
                <span v-if="selected == 1" @click="selected = 0, reqs.name = '', reqs.email = '', reqs.position = '', reqs.password = '', reqs.password_confirmation = ''" class="py-2 px-6 bg-dapyellow-100 float-left cursor-pointer rounded-lg hover:opacity-75 hover:shadow-lg">Back to User List</span>
                <span v-if="selected == 0" @click="selected = 1, edit_now = false, add_now = true" class="py-2 px-6 bg-dapyellow-100 float-right cursor-pointer rounded-lg hover:opacity-75 hover:shadow-lg">Add User</span>
            </div>
            <div class="mt-16 mb-16 md:mb-0">
                <transition name="slide">
                    <div v-if="selected == 0" class="w-full h-auto p-6 bg-gray-300 rounded-lg shadow-xl m-auto">
                        <div class="w-full py-2 text-lg font-semibold text-center text-dapblue">User List</div>
                        <div class="w-full text-center my-2">
                            <div class="w-full m-auto text-center rounded-lg">
                                <!-- start Pagination -->
                                <div class="my-4 block md:flex justify-between">
                                    <div class="my-2 md:my-0 w-full">
                                        <div>Page {{this.paginate.currentPage}} of {{this.paginate.pages}}</div>
                                    </div>
                                    <div class="my-2 md:my-0 w-full">
                                        <input v-model="search" type="text" maxlength="20" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center placeholder-dapyellow-200" placeholder="Search...">
                                    </div>
                                    <div class="my-2 md:my-0 w-full">
                                        <!-- <button @click="navigate_display(pagination.first_page)" :disabled="pagination.current_page == 1" :class="pagination.current_page == 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'" class=" p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-chevron-double-left"></i></button> -->
                                        <button :disabled="!isPrevDisabled" :class="isPrevDisabled ? 'cursor-pointer' : 'opacity-50 cursor-not-allowed'" @click="paginate.currentPage--" class=" p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-chevron-left"></i></button>
                                        <button @click="paginate.currentPage++" :disabled="!isNextDisabled" :class="isNextDisabled ? 'cursor-pointer' : 'opacity-50 cursor-not-allowed'" class="p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-chevron-right"></i></button>
                                        <!-- <button @click="navigate_display(pagination.last_page)" :disabled="pagination.current_page == pagination.last_page || pagination.total == 0" :class="pagination.current_page == pagination.last_page || pagination.total == 0 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'" class="p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-chevron-double-right"></i></button> -->
                                    </div>
                                </div>
                                <!-- end Pagination -->

                                <div class="flex text-lg font-semibold rounded-t-lg border-2 border-gray-900 items-center">
                                    <div class="w-full table-cell py-4">Name</div>
                                    <div class="w-full table-cell py-4">Email</div>
                                    <div class="w-full table-cell py-4">Position</div>
                                    <div class="w-full table-cell py-4">Created At</div>
                                    <div class="w-full table-cell py-4">Action</div>
                                </div>

                                <!-- table body -->
                                <div v-if="nodata" class="flex border-b-2 border-l-2 border-r-2 border-gray-900 items-center">
                                    <div class="w-full table-row py-2 cursor-default font-bold">No record available</div>
                                </div>
                                <div v-else>
                                    <div v-for="user in displayedUsers" :key="user.id" class="flex border-b-2 border-l-2 border-r-2 border-gray-900 items-center">
                                        <div class="w-full table-cell py-2 cursor-pointer">{{user.name}}</div>
                                        <div class="w-full table-cell py-2 cursor-pointer">{{user.email}}</div>
                                        <div class="w-full table-cell py-2 cursor-pointer">{{user.position}}</div>
                                        <div class="w-full table-cell py-2 cursor-pointer">{{user.created_att}}</div>
                                        <div class="w-full table-cell py-2 cursor-pointer"><button @click.prevent="edit(user.name,user.email,user.position,user.id)" class="p-2 bg-dapyellow-100 rounded-lg w-20 hover:shadow-lg">Edit</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
                <transition name="slide">
                    <div v-if="selected == 1" class="w-full h-auto p-6 bg-gray-300 rounded-lg shadow-xl m-auto">
                        <div v-if="add_now" class="w-full py-2 text-lg font-semibold text-center text-dapblue">Add User</div>
                        <div v-if="edit_now" class="w-full py-2 text-lg font-semibold text-center text-dapblue">Update User</div>

                        <div class="w-full text-center my-2">
                            <div class="text-lg text-center md:flex block">
                                <div class="w-full">
                                    <div class="my-4">
                                        <p class="mb-1">Full Name</p>
                                        <input v-model="reqs.name" type="text" class="bg-gray-400 md:w-6/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                    <div class="my-4">
                                        <p class="mb-1">Position</p>
                                        <input v-model="reqs.position" type="text" class="bg-gray-400 md:w-6/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="my-4">
                                        <p class="mb-1">Email</p>
                                        <input v-model="reqs.email" type="text" class="bg-gray-400 md:w-6/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                    <div class="my-4">
                                        <p class="mb-1">Password</p>
                                        <input v-model="reqs.password" type="password" class="bg-gray-400 md:w-6/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                    <div class="my-4">
                                        <p class="mb-1">Confirm Password</p>
                                        <input @keyup="check_password()" v-model="reqs.password_confirmation" type="password" :class="pass_error ? 'border-red-700 focus:bg-red-300':'border-dapblue focus:bg-gray-200'" class="bg-gray-400 md:w-6/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                        <p v-if="pass_error" class="mb-1 text-red-700">Password does not match.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-lg text-center mt-4">
                                <button v-if="add_now" @click.prevent="generate()" class="py-2 w-64 bg-dapyellow-100 hover:bg-opacity-50 text-dapblue rounded-lg hover:shadow-lg font-semibold">Create Account</button>
                                <button v-if="edit_now" @click.prevent="update()" class="py-2 w-64 bg-dapyellow-100 hover:bg-opacity-50 text-dapblue rounded-lg hover:shadow-lg font-semibold">Update Account</button>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    name:'Accounts',
    data() {
        return {
            err: false,
            errMsg: null,
            success: false,
            successMsg: null,
            selected: 0,
            reqs: {
                name: '',
                position: '',
                email: '',
                password: '',
                password_confirmation: '',
                user_id: null,
                pass_nochange: false
            },
            pass_error: false,
            reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            nodata: false,
            users: null,
            search: '',
            paginate: {
                currentPage: 1,
                perPage: 5,
                pages: 0
            },
            isNextDisabled: null,
            isPrevDisabled: null,
            add_now: false,
            edit_now: false

        }
    },
    computed: {
        ...mapGetters({
            get_users: 'auth/users',
            get_token: 'auth/gettoken'
        }),
        displayedUsers () {
            if(this.search != null || this.search != '') {
                return this.paginate_this(this.searching);
            }
            else {
                return this.paginate_this(this.get_users);
            }
        },
        searching() {
            this.paginate.currentPage = 1
            return this.get_users.filter((ss) => {
                return this.search.toLowerCase().split(' ').every(v => ss.name.toLowerCase().includes(v));
            });
        }
    },
    methods: {
        ...mapActions({
            createUser: 'auth/createUser',
            getUsers: 'auth/getUsers',
            updateUser: 'auth/update_user',
            checkToken: 'auth/checkToken',
            logoutAction: 'auth/logout'
        }),
        check_password() {
            if(this.reqs.password != this.reqs.password_confirmation) {
                this.pass_error = true
            }
            else {
                this.pass_error = false
            }
        },
        generate() {
            if(this.reqs.name == '' || this.reqs.position == '' || this.reqs.email == '' || this.reqs.password == '') {
                this.err = true
                this.errMsg = "Please Fill out all fields to create an account."
                setTimeout(()=>{
                    this.err = false
                }, 3000)
            }
            else if(!this.reg.test(this.reqs.email)) {
                this.err = true
                this.errMsg = "Please Enter correct email."
                setTimeout(()=>{
                    this.err = false
                }, 3000)
            }
            else {
                this.createUser(this.reqs).then(response => {
                    this.reqs.name = ''
                    this.reqs.email = ''
                    this.reqs.position = ''
                    this.reqs.password = ''
                    this.reqs.password_confirmation = ''
					
                    this.display()
                    this.selected = 0
                    this.success = true
                    this.successMsg = "User Added Successfully."
                    setTimeout(()=>{
                        this.success = false
                    }, 3000)
                })
            }
        },
        display() {
            this.getUsers().then(()=>{
                this.users = this.get_users
                // console.log(this.users);

                // if(response.status == 1) {
                //     if(response.result.data.length > 0) {
                //         this.nodata = false
                //         // this.pagination.current_page = response.result.current_page
                //         // this.pagination.last_page = response.result.last_page
                //         // this.pagination.last_page_url = response.result.last_page_url
                //         // this.pagination.first_page_url = response.result.first_page_url
                //         // this.pagination.prev_page_url = response.result.prev_page_url
                //         // this.pagination.next_page_url = response.result.next_page_url
                //         // this.paginate.resultCount = this.users.length
                //         // if(this.paginate.currentPage >= this.totalPages) {
                //         //     this.paginate.currentPage = this.totalPages - 1
                //         // }
                //         // var index = this.paginate.currentPage * this.paginate.itemsPerPage
                //         // this.users.slice(index, index + this.itemsPerPage)
                        
                        
                //         // console.log(this.users);
                //     }
                //     else {
                //         this.nodata = true
                //         // this.pagination.current_page = response.result.current_page
                //         // this.pagination.last_page = response.result.last_page
                //     }
                // }
                // else {
                //     this.nodata = true
                // }
            })
        },
        setPages (get_users) {
            if(get_users != null) {
                if(get_users.length > 0) {
                    let numberOfPages = Math.ceil(get_users.length / this.paginate.perPage);
                    this.paginate.pages = numberOfPages
                }
                else {
                    this.paginate.pages = 1
                }
            }
            else {
                let numberOfPages = Math.ceil(this.users.length / this.paginate.perPage);
                this.paginate.pages = numberOfPages
            }
			// for (let index = 1; index <= numberOfPages; index++) {
			// 	this.paginate.pages.push(index);
            // console.log(index);
            // }
		},
		paginate_this (get_users) {
            this.setPages(get_users)
            if(this.paginate.currentPage < this.paginate.pages) {
                this.isNextDisabled = true
            }
            else {
                this.isNextDisabled = false
            }
            if(this.paginate.currentPage != 1) {
                this.isPrevDisabled = true
            }
            else {
                this.isPrevDisabled = false
            }
            // console.log(this.paginate.pages.length);
			let page = this.paginate.currentPage;
            let perPage = this.paginate.perPage;
			let from = (page * perPage) - perPage;
			let to = (page * perPage);
			return  get_users.slice(from, to);
        },
        edit(name,email,position,id) {
            this.edit_now = true
            this.add_now = false
            this.selected = 1
            this.reqs.name = name
            this.reqs.position = position
            this.reqs.email = email
            this.reqs.user_id = id
        },
        update() {
            if(this.reqs.password == '' || this.reqs.password == null) {
                this.reqs.pass_nochange = true
            }
            else {
                this.reqs.pass_nochange = false
            }
            
            this.updateUser(this.reqs).then(res=>{
                this.display()
                this.reqs.name = ''
                this.reqs.email = ''
                this.reqs.position = ''
                this.reqs.password = ''
                this.reqs.password_confirmation = ''
                this.reqs.user_id = null
                this.selected = 0
                this.success = true
                this.successMsg = "User Updated Successfully."
                setTimeout(()=>{
                    this.success = false
                }, 3000)
            })
        }
    },
    created() {
        this.display()
    },
	watch: {
		users () {
			this.setPages();
		}
	},
	filters: {
		trimWords(value){
			return value.split(" ").splice(0,20).join(" ") + '...';
		}
	},
    mounted() {
        // console.log(this.get_token);
        if(this.get_token !== '') {
            this.checkToken().then(res=>{
                console.log(res);
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
.spin-logo {
    -moz-animation:spin 1s ease infinite;
    animation:spin 1s ease infinite;
}

@keyframes spin {
    0% {transform: rotateY(180deg);}
	40% {transform: translateY(-30px);}
    60% {transform: translateY(-15px);}
    100% {transform: rotateY(0deg);}
}


.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}


.slide-enter-active,
.slide-leave-active
{
  transition: transform 0.4s ease;
}

.slide-enter,
.slide-leave-to {
  transform: translateX(100%);
  transition: all 200ms ease-in 0s
}
</style>