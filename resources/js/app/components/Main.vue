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
        <div v-if="loading" class="w-full h-full flex m-auto z-50 fixed top-0 left-0 bg-gray-900 opacity-75">
            <img :src="'img/applogo.png'" class="w-32 h-32 spin-logo m-auto">
        </div>
        <div class="w-full py-4 md:px-16 px-8">
            <div>
                <span class="text-dapblue font-bold text-2xl">ICT Inventory</span>
            </div>
            <div class="my-2 font-semibold">
                <span v-if="selected !== 0 && selected !== 2" @click="display()" class="py-2 px-6 bg-dapyellow-100 float-left cursor-pointer rounded-lg hover:opacity-75 hover:shadow-lg">Back to ICT List</span>
                <span v-if="selected !== 1" @click="selected = 1" class="py-2 px-6 bg-dapyellow-100 float-right cursor-pointer rounded-lg hover:opacity-75 hover:shadow-lg">Add Item</span>

            </div>
            <div class="mt-16 mb-16 md:mb-0">
                <!-- ICT List -->
                <transition name="slide">
                    <div v-if="selected === 0" class="w-full h-auto p-6 bg-gray-300 rounded-lg shadow-xl m-auto">
                        <div class="w-full bg-opacity-75">
                            <div class="w-full m-auto text-center rounded-lg">
                                
                                <!-- start Pagination -->
                                <div class="my-4 block md:flex justify-between">
                                    <div class="my-2 md:my-0">
                                        <div>Page {{this.paginate.currentPage}} of {{this.paginate.pages}}</div>
                                    </div>
                                    <div class="my-2 md:my-0">
                                        <input v-model="search" type="text" maxlength="20" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center placeholder-dapyellow-200" title="Search User or Property Number" placeholder="Search...">
                                    </div>
                                    <div class="my-2 md:my-0">
                                        <select v-model="display_type" @change="display()"  class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                            <option value="pc">PC</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div class="my-2 md:my-0">
                                        <select v-model="select_center" @change="display()"  class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                            <option value="all">ALL</option>
                                            <option value="N/A">N/A</option>
                                            <option value="ADMIN">ADMIN</option>
                                            <option value="APOLO">APOLO</option>
                                            <option value="BUDGET">BUDGET</option>
                                            <option value="CANTEEN">CANTEEN</option>
                                            <option value="CFG">CFG</option>
                                            <option value="CLINIC">CLINIC</option>
                                            <option value="COD">COD</option>
                                            <option value="COF">COF</option>
                                            <option value="CORCOM">CORCOM</option>
                                            <option value="CORSEC">CORSEC</option>
                                            <option value="COSM">COSM</option>
                                            <option value="DAPCC">DAPCC</option>
                                            <option value="DAPCC-PASIG">DAPCC-PASIG</option>
                                            <option value="DAPCC-TAGAYTAY">DAPCC-TAGAYTAY</option>
                                            <option value="DSM">DSM</option>
                                            <option value="ESO">ESO</option>
                                            <option value="FINANCE">FINANCE</option>
                                            <option value="GSPDM">GSPDM</option>
                                            <option value="HRMDD">HRMDD</option>
                                            <option value="IAS">IAS</option>
                                            <option value="IMC">IMC</option>
                                            <option value="LEGAL">LEGAL</option>
                                            <option value="LIBRARY">LIBRARY</option>
                                            <option value="OP">OP</option>
                                            <option value="OP-SP">OP-SP</option>
                                            <option value="OSVP-P">OSVP-P</option>
                                            <option value="OSVP-S">OSVP-S</option>
                                            <option value="PDC">PDC</option>
                                            <option value="PDC-PDRO">PDC-PDRO</option>
                                            <option value="PMDP">PMDP</option>
                                            <option value="REGISTRAR">REGISTRAR</option>
                                            <option value="SHDP">SHDP</option>
                                            <option value="SPARTA">SPARTA</option>
                                            <option value="VP-CCC">VP-CCC</option>
                                        </select>
                                    </div>
                                    <div class="my-2 md:my-0">
                                        <select v-model="display_year" @change="display()"  class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                            <option value="all">ALL</option>
                                            <option v-for="year in years" :value="year" v-bind:key="year">{{ year }}</option>
                                        </select>
                                    </div>
                                    <div class="my-2 md:my-0">
                                        <!-- <button @click="navigate_display(pagination.first_page)" :disabled="pagination.current_page == 1" :class="pagination.current_page == 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'" class=" p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-chevron-double-left"></i></button> -->
                                        <button title="Previous" @click="paginate.currentPage--" :disabled="!isPrevDisabled" :class="isPrevDisabled ? 'cursor-pointer' : 'opacity-50 cursor-not-allowed'" class=" p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-chevron-left"></i></button>
                                        <button title="Next" @click="paginate.currentPage++" :disabled="!isNextDisabled" :class="isNextDisabled ? 'cursor-pointer' : 'opacity-50 cursor-not-allowed'" class="p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-chevron-right"></i></button>
                                        <!-- <button @click="navigate_display(pagination.last_page)" :disabled="pagination.current_page == pagination.last_page || pagination.total == 0" :class="pagination.current_page == pagination.last_page || pagination.total == 0 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'" class="p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-chevron-double-right"></i></button> -->
                                    </div>
                                </div>
                                <!-- end Pagination -->

                                <div class="flex text-lg font-semibold rounded-t-lg border-2 border-gray-900 items-center">
                                    <div class="w-full table-cell py-4">User</div>
                                    <div class="w-full table-cell py-4">Center</div>
                                    <div class="w-full table-cell py-4">Property Number</div>
                                    <div class="w-full table-cell py-4">Purchase Year</div>
                                    <div class="w-full table-cell py-4">Remarks</div>
                                    <div class="w-full table-cell py-4">Action</div>
                                </div>

                                <!-- table body -->
                                <div v-if="nodata" class="flex border-b-2 border-l-2 border-r-2 border-gray-900 items-center">
                                    <div class="w-full table-row py-2 cursor-default font-bold">No record available</div>
                                </div>
                                <div v-else>
                                    <div v-for="item in displayedItems" :key="item.device_id" class="flex border-b-2 border-l-2 border-r-2 border-gray-900 items-center">
                                        <div class="w-full table-cell py-2 cursor-pointer">{{item.user}}</div>
                                        <div class="w-full table-cell py-2 cursor-pointer">{{item.center}}</div>
                                        <div class="w-full table-cell py-2 cursor-pointer">{{item.property_number}}</div>
                                        <div class="w-full table-cell py-2 cursor-pointer">{{item.purchase_year}}</div>
                                        <div v-if="item.remarks.length < 20" class="w-full table-cell py-2 cursor-pointer">{{item.remarks}}</div>
                                        <div v-else class="w-full table-cell py-2 cursor-pointer">{{item.remarks.substring(0,20)+" ..."}}</div>
                                        <div class="w-full table-cell py-2 cursor-pointer"><button @click="edit(item.device_id)" class="p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="far fa-edit"></i></button> <button @click="view(item.device_id)" class="p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="fas fa-eye"></i></button></div>
                                    </div>
                                </div>
                                <div class="p-4 w-full"></div>
                            </div>
                        </div>
                    </div>
                </transition>
                <transition name="slide">
                    <div v-if="selected === 2 && item !== null" class="w-full h-auto px-6 py-4 bg-gray-300 rounded-lg shadow-xl m-auto">
                        <div class="float-right">
                            <div @click="closeView()" class="w-10 px-2 text-2xl cursor-pointer text-dapblue"><i class="far fa-times"></i></div>
                        </div>
                        
                        <div class="md:flex block mt-6">
                            <div class="p-4 w-full">
                                <div class="text-lg font-semibold text-center mb-4">User Details</div>
                                <div class="block">
                                    <div class="w-full flex">
                                        <div class="p-2 w-5/12 text-md font-semibold">User</div>
                                        <div class="p-2 text-md">{{item[0].user}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="p-2 w-5/12 text-md font-semibold">Center</div>
                                        <div class="p-2 text-md">{{item[0].center}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="p-2 w-5/12 text-md font-semibold">Unit</div>
                                        <div class="p-2 text-md">{{item[0].unit}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="p-2 w-5/12 text-md font-semibold">Purchase Year</div>
                                        <div class="p-2 text-md">{{item[0].purchase_year}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="p-2 w-5/12 text-md font-semibold">Issuance Date</div>
                                        <div class="p-2 text-md">{{item[0].issuance_date}}</div>
                                    </div>
                                    <div class="w-full flex">
                                        <div class="p-2 w-5/12 text-md font-semibold">Remarks</div>
                                        <div class="p-2 text-md">{{item[0].remarks}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 w-full">
                                <div class="text-lg font-semibold text-center mb-4">Device Details</div>
                                <div class="block">
                                    <div v-if="item[1].device_id.substr(0,2) === 'PC'">
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Property Number</div>
                                            <div class="p-2 text-md">{{item[1].property_number}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Type</div>
                                            <div class="p-2 text-md">{{item[1].type}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Processor</div>
                                            <div class="p-2 text-md">{{item[1].procie}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">GPU</div>
                                            <div class="p-2 text-md">{{item[1].gpu}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Memory</div>
                                            <div class="p-2 text-md">{{item[1].ram}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Storage</div>
                                            <div class="p-2 text-md">{{item[1].storage}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Operating System</div>
                                            <div class="p-2 text-md">{{item[1].os}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">MS Office</div>
                                            <div class="p-2 text-md">{{item[1].office}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">IP Address LAN</div>
                                            <div class="p-2 text-md">{{item[1].ip_lan}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">IP Address WLAN</div>
                                            <div class="p-2 text-md">{{item[1].ip_wlan}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">MAC Address LAN</div>
                                            <div class="p-2 text-md">{{item[1].mac_lan}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">MAC Address WLAN</div>
                                            <div class="p-2 text-md">{{item[1].mac_wlan}}</div>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Property Number</div>
                                            <div class="p-2 text-md">{{item[1].property_number}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Device Name</div>
                                            <div class="p-2 text-md">{{item[1].device_name}}</div>
                                        </div>
                                        <div class="w-full flex">
                                            <div class="p-2 w-5/12 text-md font-semibold">Device Type</div>
                                            <div class="p-2 text-md">{{item[1].device_type}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 md:w-5/12 w-full">
                                <div class="text-lg font-semibold text-center mb-4">QR Code</div>
                                <div class="w-full font-semibold">
                                    <div class="flex">
                                        <qrcode-vue class="mx-auto" :value="qr_value(item[1].device_id)" :size="size" :logo="'img/qr_logo.png'"></qrcode-vue>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 w-full text-center">
                            <div class="text-lg font-bold mb-4">History</div>
                            <div class="flex text-lg font-semibold rounded-t-lg items-center w-full border-2 border-gray-800">
                                <div class="w-full table-cell py-2">Control Number</div>
                                <div class="w-full table-cell py-2">Recommendation</div>
                                <div class="w-full table-cell py-2">Prepared By</div>
                                <div class="w-full table-cell py-2">Date Issued</div>
                                <div class="w-full table-cell py-2">Action</div>
                            </div>
							
							<div v-if="nodiags_history" class="flex border-b-2 border-l-2 border-r-2 border-gray-900 items-center">
                                <div class="w-full table-row py-2 cursor-default font-bold">No diagnosis available</div>
                            </div>
                            <div v-else>
                                <div v-for="diag in diags_history" :key="diag.control_number" class="flex border-b-2 border-l-2 border-r-2 border-gray-900 items-center">
                                    <div class="w-full table-cell py-2 cursor-pointer">{{diag.control_number}}</div>
                                    <div class="w-full table-cell py-2 cursor-pointer">{{diag.recommendation}}</div>
                                    <div class="w-full table-cell py-2 cursor-pointer">{{diag.name}}</div>
                                    <div class="w-full table-cell py-2 cursor-pointer">{{diag.date_issued}}</div>
                                    <div class="w-full table-cell py-2 cursor-pointer"><button @click="view_diags(diag.control_number)" class="p-2 bg-dapyellow-100 rounded-lg w-10 hover:shadow-lg"><i class="far fa-eye"></i> </button></div>
                                </div>
                            </div>
                            <div class="p-4 w-full"></div>
                        </div>
						<div v-if="isLoading" class="w-full h-full flex m-auto z-50 fixed top-0 left-0 bg-gray-900 opacity-75">
                            <img :src="'img/applogo.png'" class="w-32 h-32 spin-logo m-auto">
                        </div>
                    </div>

                </transition>

                <!-- Add Process -->
                <transition name="slide">
                    <div v-if="selected === 1" class="w-full h-full px-6 py-4 bg-gray-300 rounded-lg shadow-xl">
                        <div v-if="currentPage !== 4" class="w-full flex justify-between text-center">
                            <span @click.prevent="pageBack()" class="py-4 md:w-16 w-full cursor-pointer text-dapblue" :class="currentPage !== 0 ? 'opacity-100 cursor-pointer' : 'opacity-25 cursor-not-allowed'"><i class="fas fa-angle-left"></i> Back</span>
                            <div class="hidden md:block w-full py-2 text-lg font-semibold mt-4">Add ICT Equipment</div>
                            <span @click.prevent="pageNext()" class="py-4 md:w-16 w-full cursor-pointer text-dapblue" :class="currentPage === processPages ? 'hidden' : 'block'">Next <i class="fas fa-angle-right"></i></span>
                            <span v-if="reqs.device_id == null" @click.prevent="complete()" class="py-4 md:w-32 w-full cursor-pointer text-dapblue font-bold" :class="currentPage === processPages ? 'block' : 'hidden'">Complete <i class="fad fa-check-circle"></i></span>
                            <span v-else @click.prevent="update()" class="py-4 md:w-32 w-full cursor-pointer text-dapblue font-bold" :class="currentPage === processPages ? 'block' : 'hidden'">Update <i class="fad fa-check-circle"></i></span>
                        </div>
                        <div v-if="currentPage !== 4" class="block md:hidden w-full py-2 text-lg font-semibold mt-4 text-center">Add ICT Equipment</div>
                        
                            <!-- User Details -->
                        <div v-if="currentPage === 0" class="text-lg font-semibold my-2 text-center">
                            <span class="text-md text-dapblue">User Details</span>
                            <div class="my-4">
                                <p class="mb-1">User</p>
                                <input v-model="reqs.user" type="text" class="bg-gray-400 md:w-4/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                            </div>
                            <div class="my-4">
                                <p class="mb-1">Center</p>
                                <select v-model="reqs.center" class="bg-gray-400 md:w-4/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    <option value="N/A">N/A</option>
									<option value="ADMIN">ADMIN</option>
                                    <option value="APOLO">APOLO</option>
                                    <option value="BUDGET">BUDGET</option>
                                    <option value="CANTEEN">CANTEEN</option>
                                    <option value="CFG">CFG</option>
                                    <option value="CLINIC">CLINIC</option>
                                    <option value="COD">COD</option>
                                    <option value="COF">COF</option>
                                    <option value="CORCOM">CORCOM</option>
                                    <option value="CORSEC">CORSEC</option>
                                    <option value="COSM">COSM</option>
                                    <option value="DAPCC">DAPCC</option>
                                    <option value="DAPCC-PASIG">DAPCC-PASIG</option>
                                    <option value="DAPCC-TAGAYTAY">DAPCC-TAGAYTAY</option>
                                    <option value="DSM">DSM</option>
                                    <option value="ESO">ESO</option>
                                    <option value="FINANCE">FINANCE</option>
                                    <option value="GSPDM">GSPDM</option>
                                    <option value="HRMDD">HRMDD</option>
                                    <option value="IAS">IAS</option>
                                    <option value="IMC">IMC</option>
                                    <option value="LEGAL">LEGAL</option>
                                    <option value="LIBRARY">LIBRARY</option>
                                    <option value="OP">OP</option>
                                    <option value="OP-SP">OP-SP</option>
                                    <option value="OSVP-P">OSVP-P</option>
                                    <option value="OSVP-S">OSVP-S</option>
                                    <option value="PDC">PDC</option>
                                    <option value="PDC-PDRO">PDC-PDRO</option>
                                    <option value="PMDP">PMDP</option>
                                    <option value="REGISTRAR">REGISTRAR</option>
                                    <option value="SHDP">SHDP</option>
                                    <option value="SPARTA">SPARTA</option>
                                    <option value="VP-CCC">VP-CCC</option>
                                </select>
                            </div>
                            <div class="my-4">
                                <p class="mb-1">Unit</p>
                                <input v-model="reqs.unit" type="text" class="bg-gray-400 md:w-4/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                            </div>
                        </div>

                        <!-- Device Details -->
                        <div v-else-if="currentPage === 1" class="text-lg font-semibold my-2 text-center">
                            <span class="text-md text-dapblue">Device Details</span>

                            <div class="my-4">
                                <p class="mb-1 ">Device Type</p>
                                
                                <select v-model="reqs.ict_type" class="bg-gray-400 md:w-4/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2">
                                    <option value="pc" selected>PC</option>
                                    <option value="other">Other</option>
                                </select>
                                
                            </div>

                            <!-- Device Others -->
                            <div class="w-full" :class="reqs.ict_type == 'other' ? 'block' : 'hidden'">
                                <div class="my-4">
                                    <p class="mb-1">Property Number</p>
                                    <input v-model="reqs.property_number" type="text" class="md:w-4/12 w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                </div>
                                <div class="my-4">
                                    <p class="mb-1">Device Name</p>
                                    <input v-model="reqs.device_name" class="md:w-4/12 w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                </div>
                                <div class="my-4">
                                    <p class="mb-1">Type</p>
                                    <select v-model="reqs.device_type" class="bg-gray-400 md:w-4/12 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2">
                                        <option value="Printer Only">Printer Only</option>
                                        <option value="3-in-1 Printer">3-in-1 Printer</option>
                                        <option value="Scanner">Scanner</option>
                                        <option value="UPS">UPS</option>
                                        <option value="AVR">AVR</option>
                                    </select>
                                </div>
                                <div v-if="reqs.device_type === '3-in-1 Printer'" class="my-4">
                                    <p class="mb-1">IP Address</p>
                                    <input v-model="reqs.ip" type="text" class="md:w-4/12 w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                </div>
                            </div>

                            <!-- Device PC -->
                            <div :class="reqs.ict_type == 'pc' ? 'block' : 'hidden'">
                                <div class="md:flex block">
                                    <div class="w-full">
                                        <div class="my-4 md:mx-32 mx-0">
                                            <p class="mb-1">Property Number</p>
                                            <input v-model="reqs.property_number" type="text" class="w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                        </div>
                                        <div class="my-4 md:mx-32 mx-0">
                                            <p class="mb-1">Type</p>
                                            <select v-model="reqs.type" class="w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2">
                                                <option value="Desktop">Desktop</option>
                                                <option value="Laptop">Laptop</option>
                                            </select>
                                        </div>
                                        <div class="my-4 md:mx-32 mx-0">
                                            <p class="mb-1">Processor</p>
                                            <input v-model="reqs.procie" type="text" class="w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <div class="my-4 md:mx-32 mx-0">
                                            <p class="mb-1">GPU</p>
                                            <input v-model="reqs.gpu" type="text" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                        </div>
                                        <div class="my-4 md:mx-32 mx-0">
                                            <p class="mb-1">Memory</p>
                                            <input v-model="reqs.ram" type="text" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                        </div>
                                        <div class="my-4 md:mx-32 mx-0">
                                            <p class="mb-1">Storage</p>
                                            <input v-model="reqs.storage" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Device Details PC 2 -->
                        <div v-else-if="currentPage === 2" class="text-lg font-semibold my-2 text-center">
                            <span class="text-md text-dapblue">Device Details (PC Software)</span>

                            <div class="md:flex block">
                                <div class="w-full my-auto">
                                    <div class="my-4 md:mx-32 mx-0">
                                        <p class="mb-1">Operating System</p>
                                        <input v-model="reqs.os" type="text" class="w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                    <div class="my-4 md:mx-32 mx-0">
                                        <p class="mb-1">MS Office</p>
                                        <input v-model="reqs.office" type="text" class="w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="my-4 md:mx-32 mx-0">
                                        <p class="mb-1">IP Adress (LAN)</p>
                                        <input v-model="reqs.ip_lan" type="text" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                    <div class="my-4 md:mx-32 mx-0">
                                        <p class="mb-1">IP Adress (WLAN)</p>
                                        <input v-model="reqs.ip_wlan" type="text" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                    <div class="my-4 md:mx-32 mx-0">
                                        <p class="mb-1">MAC Address (LAN)</p>
                                        <input v-model="reqs.mac_lan" type="text" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                    <div class="my-4 md:mx-32 mx-0">
                                        <p class="mb-1">MAC Address (WLAN)</p>
                                        <input v-model="reqs.mac_wlan" type="text" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div v-else-if="currentPage === 3" class="text-lg font-semibold my-2 text-center">
                            <span class="text-md text-dapblue">Remarks</span>

                            <div class="w-full my-auto">
                                <div class="my-4 md:mx-32 mx-0">
                                    <p class="mb-1">Turn-over Date</p>
                                    <input v-model="reqs.issuance_date" type="date" class="md:w-4/12 w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                </div>
                                <div class="my-4 md:mx-32 mx-0">
                                    <p class="mb-1">Purchase Year</p>
                                    <input v-model="reqs.purchase_year" type="text" class=" md:w-4/12 w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center" maxlength='4' size="4">
                                </div>
                                <div class="my-4 md:mx-32 mx-0">
                                    <p class="mb-1">Status</p>
                                    <input v-model="reqs.remarks" type="text" class=" md:w-4/12 w-full bg-gray-400 p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center">
                                </div>
                            </div>

                        </div>


                        <!-- QR CODE -->
                        <div v-else-if="currentPage === 4" class="text-lg font-semibold my-2 text-center w-full">
                            <div v-if="!isloading">
                                <div class="text-lg font-bold text-dapblue">{{message}}</div><br/>
                                <div class="text-md font-semibold my-6">This is the QR Code generated for the ICT Equipment you added.</div>
                                <div class="flex">
                                    <qrcode-vue class="mx-auto" :value="qr_value(qr_val)" :size="size" :logo="'img/qr_logo.png'"></qrcode-vue>
                                </div>
                                <div class="mt-4">
                                    <button @click.prevent="reset" class="py-2 px-8 bg-dapyellow-100 rounded-md hover:shadow-lg hover:bg-opacity-75 text-dapblue font-semibold">Reset <i class="fad fa-undo-alt"></i></button>
                                </div>
                            </div>
                            <div v-else class="w-full h-full flex m-auto z-50 fixed top-0 left-0 bg-gray-900 opacity-75">
                                <img :src="'img/applogo.png'" class="w-32 h-32 spin-logo m-auto">
                            </div>
                        </div>
                    </div>
                </transition>
            </div>

        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex"
import { mapGetters } from "vuex"
import qrcodeVue from 'qrcode-vue'
import jsPDF from 'jspdf'
export default {
    name: 'Main',
    components: {
        qrcodeVue
    },
    data() {
        return {
            yr_today: new Date().getFullYear(), 
            loading: false,
            view_sg: false,
            display_items: null,
            display_result: null,
            display_search: null,
            pagination: {
                current_page: null,
                next_page: null,
                prev_page: null,
            },
            isloading: false,
            isLoading: false,
            size: 150,
            pages: 1,
            selected: 0,
            i: 0,
            reqs: {
                device_id: null,
                user: '',
                center: '',
                unit: '',
                ict_type: 'pc',
                property_number: '',
                type: '',
                procie: '',
                gpu: '',
                ram: '',
                storage: '',
                os: '',
                office: '',
                ip_lan: '',
                ip_wlan: '',
                mac_lan: '',
                mac_wlan: '',
                device_name: '',
                device_type: '',
                ip: '',
                issuance_date: '',
                purchase_year: '',
                remarks: '',
            },
            ip: false,
            processPages: 3,
            currentPage: 0,
            message: '',
            qr_val: '',
            err: false,
            item: null,
            view_type: '',
            errMsg: '',
            nodata: false,
            display_type: 'pc',
            select_center: 'all',
            display_year: 'all',
            search: '',
            paginate: {
                currentPage: 1,
                perPage: 5,
                pages: 0
            },
            isNextDisabled: null,
            isPrevDisabled: null,
            success:false,
            successMsg: '',
            diags_history: [],
            nodiags_history: false
        }
    },
    computed: {
        ...mapGetters({
            msgRes: 'ict/responseMsg',
            devRes: 'ict/responseDev',
            get_items: 'ict/get_items',
            get_items_status: 'ict/get_items_status'
        }),
        displayedItems () {
            if(this.search != null || this.search != '') {
                return this.paginate_this(this.searching);
            }
            else {
                return this.paginate_this(this.get_items);
            }
        },
        searching() {
            this.paginate.currentPage = 1
            return this.get_items.filter((ss) => {
                return this.search.toLowerCase().split(' ').every(v => ss.property_number.toLowerCase().includes(v)) || this.search.toLowerCase().split(' ').every(v => ss.user.toLowerCase().includes(v));
            });
        },
        years() {
            const year = new Date().getFullYear()
            return Array.from({length: year - 2000}, (value, index) => 2001 + index)
        }
    },
    methods:{
        pageNext() {
            if(this.currentPage < this.processPages) {
                if(this.reqs.ict_type == 'other' && this.currentPage == 1)  {
                    this.currentPage++
                }
                this.currentPage++
            }

        },
        pageBack() {
            if(this.currentPage > 0) {
                if(this.reqs.ict_type == 'other' && this.currentPage == 3)  {
                    this.currentPage--
                }
                this.currentPage--
            }
        },
        qr_value(id) {
            return btoa(id)
        },
        ...mapActions({
            addItem: 'ict/addItem',
            getItems: 'ict/getItems',
            navigateItems: 'ict/navigateItems',
            getItem: 'ict/getItem',
            updateItem: 'ict/updateItem',
            getDiag: 'diags/getDiag',
            checkToken: 'auth/checkToken',
            logoutAction: 'auth/logout'
        }),
        complete() {
            if(this.reqs.property_number != '') {
                this.addItem(this.reqs).then(()=>{
                    if(this.msgRes != '0') {
                        this.message = this.msgRes
                        this.qr_val = this.devRes
                        this.currentPage = 4
                        this.isloading = true
                        document.documentElement.style.overflow = 'hidden'
                        setTimeout(()=> {
                            this.isloading = false
                            document.documentElement.style.overflow = 'auto'     
                        }, 3000)
                    }
                    else {
                        this.err = true
                        this.errMsg = 'Property Number already exists.';
                        setTimeout(() => {
                            this.err = false
                        }, 3000);
                    }
                })
            }
            else {
                this.err = true
                this.errMsg = "Property Number can't be Null. Please, fill out Property Number field."
                setTimeout(()=>{
                    this.err = false
                }, 3000)
            }
        },
        update() {
            if(this.reqs.property_number != '') {
                this.updateItem(this.reqs).then(res=>{
                    if(res.status == 1) {
                        this.display()
                        this.success = true
                        this.successMsg = 'Update Successfully!'
                        this.loading = true
                        document.documentElement.style.overflow = 'hidden'
                        setTimeout(()=> {
                            this.selected = 0
                            this.loading = false
                            document.documentElement.style.overflow = 'auto'  
                            this.success = false   
                        }, 1500)
                    }
                    else {
                        this.err = true
                        this.errMsg = res.message
                        setTimeout(()=>{
                            this.err = false
                        }, 3000)
                    }
                })
            }
            else {
                this.err = true
                this.errMsg = "Property Number can't be Null. Please, fill out Property Number field."
                setTimeout(()=>{
                    this.err = false
                }, 3000)
            }
        },
        reset() {
            this.reqs.user = ''
            this.reqs.center = ''
            this.reqs.unit = ''
            this.reqs.ict_type = 'pc'
            this.reqs.property_number = ''
            this.reqs.type = ''
            this.reqs.procie = ''
            this.reqs.gpu = ''
            this.reqs.ram = ''
            this.reqs.storage = ''
            this.reqs.os = ''
            this.reqs.office = ''
            this.reqs.ip_lan = ''
            this.reqs.ip_wlan = ''
            this.reqs.mac_lan = ''
            this.reqs.mac_wlan = ''
            this.reqs.device_name = ''
            this.reqs.device_type = ''
            this.reqs.ip = ''
            this.reqs.issuance_date = ''
            this.reqs.purchase_year = ''
            this.reqs.remarks = ''
            this.currentPage = 0
            this.message = ''
            this.qr_val = ''
            this.device_id = null
        },
        view(dev_id) {
            this.selected = 2
            this.getItem(dev_id).then(res => {
                var main = res.main
                var sec = res.sec
                sec['ww'] = 'view'
				if(res.diags_history.length == 0) {
                    this.nodiags_history = true
                }
                else {
                    this.nodiags_history = false
                    this.diags_history = res.diags_history
                }
                this.item = main.concat(sec)
            })
        },
        edit(dev_id) {
            this.reset()
            this.selected = 1
            this.getItem(dev_id).then(res => {
                var main = res.main
                var sec = res.sec
                this.item = main.concat(sec)
                this.reqs.device_id = this.item[1].device_id
                this.reqs.user = this.item[0].user
                this.reqs.center = this.item[0].center
                this.reqs.unit = this.item[0].unit
                this.reqs.issuance_date = this.item[0].issuance_date
                this.reqs.purchase_year = this.item[0].purchase_year
                this.reqs.remarks = this.item[0].remarks

                if(this.item[1].device_id.substr(0,2) === 'PC') {
                    this.reqs.ict_type = 'pc'
                    this.reqs.property_number = this.item[1].property_number
                    this.reqs.type = this.item[1].type
                    this.reqs.procie = this.item[1].procie
                    this.reqs.gpu = this.item[1].gpu
                    this.reqs.ram = this.item[1].ram
                    this.reqs.storage = this.item[1].storage
                    this.reqs.os = this.item[1].os
                    this.reqs.office = this.item[1].office
                    this.reqs.ip_lan = this.item[1].ip_lan
                    this.reqs.ip_wlan = this.item[1].ip_wlan
                    this.reqs.mac_lan = this.item[1].mac_lan
                    this.reqs.mac_wlan = this.item[1].mac_wlan
                }
                else {
                    this.reqs.ict_type = 'other'
                    this.reqs.device_name = this.item[1].device_name
                    this.reqs.device_type = this.item[1].device_type
                    this.reqs.ip = this.item[1].ip
                }
            })
        },
        closeView() {
            this.selected = 0
            this.item = null
        },
        display() {
            this.selected = 0
            this.reset()
            var rr = {
                'center':this.select_center,
                'type': this.display_type,
                'year': this.display_year
            }

            this.getItems(rr).then(response=>{
                this.items = this.get_items
                if(this.get_items_status != 0) {
                    if(this.get_items.length == 0) {
                        this.nodata = true
                    }
                    else {
                        this.nodata = false
                    }
                } 
                else {
                    this.nodata = true
                }
            })
        },
        setPages (get_items) {
            if(get_items != null) {
                if(get_items.length > 0) {
                    let numberOfPages = Math.ceil(get_items.length / this.paginate.perPage);
                    this.paginate.pages = numberOfPages
                }
                else {
                    this.paginate.pages = 1
                }
            }
            else {
                let numberOfPages = Math.ceil(this.items.length / this.paginate.perPage);
                this.paginate.pages = numberOfPages
            }
		},
		paginate_this (get_items) {
            this.setPages(get_items)
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
			return get_items.slice(from, to);
        },
        view_diags(get_cn) {
            this.getDiag(get_cn).then(res => {
                const doc = new jsPDF({
                    orientation: 'p',
                    unit: 'mm',
                    format: 'a4'
                });

                // header
                const img = 'data:image/png;base64,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';
                
                doc.addImage(img, 'PNG', 71, 3);
                doc.setFontSize(12);          
                doc.setFont('helvetica','bold');       
                doc.text(88, 25, 'ICT Diagnosis Form');
    
                // body
    
                doc.setFont('helvetica','normal'); 
    
                doc.text(10, 35, 'User:');
                doc.text(34, 35, res.pc.user);
                doc.line(34, 36, 100, 36);
    
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();
                doc.text(113, 35, 'Date Issued:');
                doc.text(150, 35, mm + '/' + dd + '/' + yyyy);
                doc.line(148, 36, 195, 36);
    
                doc.text(10, 40, 'Center/Unit:');
                doc.text(34, 40, res.pc.center);
                doc.line(34, 41, 100, 41);
                
                doc.text(113, 40, 'Control Number:');
                doc.text(150, 40, res.diag.control_number);
                doc.line(148, 41, 195, 41);
                
                doc.text(10, 45, 'ICT:');
                
                if(res.pc.device_id.substr(0,2) == 'OT') {
                    doc.text(34, 45, res.pc.device_type);
                }
                if(res.pc.device_id.substr(0,2) == 'PC'){
                    doc.text(34, 45, res.pc.type);
                }
                doc.line(34, 46, 100, 46);
    
                doc.text(113, 45, 'Property Number:');
                doc.text(150, 45, res.pc.property_number);
                doc.line(148, 46, 195, 46);
    
                doc.text(10, 60, 'Dignosis:');
                doc.text(49, 60, res.diag.diagnosis);
    
                doc.text(10, 80, 'Recommendation:');
                doc.text(49, 80, res.diag.recommendation);
    
                doc.text(10, 95, 'Recommended by:');
    
                doc.text(53, 105, res.rec.name, 'center');
                doc.line(25, 106, 80, 106);
                doc.text(53, 110, res.rec.position, 'center');
    
                doc.text(113, 95, 'Approved by:');
    
                doc.text(159, 105, res.diag.approved_by, 'center');
                doc.line(132, 106, 187, 106);
                doc.text(159, 110, res.diag.approved_position, 'center');
    
                doc.setFontSize(8);          
                doc.setFont('helvetica','normal');   
                doc.text(10, 133, 'COO-IDF, F2,REV.0');
    
                doc.setLineDash([1, 1], 1);
                doc.line(5, 5, 205, 5);  // top
                doc.line(5, 135, 5, 5);  // left
                doc.line(5, 135, 205, 135);  // bottom
                doc.line(205, 135, 205, 5);  // right

                this.isLoading = true
                document.documentElement.style.overflow = 'hidden'
                setTimeout(() => {
                    doc.output('dataurlnewwindow','diagnosis.pdf');
                    this.isLoading = false
                    document.documentElement.style.overflow = 'auto'  
                }, 1500);
            })

        }
    },
    created() {
        this.display()
    },
	watch: {
		items () {
			this.setPages();
		}
	},
	filters: {
		trimWords(value){
			return value.split(" ").splice(0,20).join(" ") + '...';
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