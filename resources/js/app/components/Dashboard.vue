<template>
    <div>
        <div class="pt-24 mx-auto w-full font-sans">
            <div class="w-full py-4 md:px-16 px-8">
                <span class="text-dapblue font-bold text-2xl">Dashboard</span>

                <!-- <column-chart :data="data"></column-chart> -->
                <div class="w-full p-4 md:flex md:justify-between block">
                    <div class="w-full md:flex md:justify-between block items-center">
                        <div class="md:w-64 w-full h-28 bg-gray-300 block p-4 rounded-md shadow-2xl mx-auto">
                            <div class="text-sm text-green-700 font-semibold">PC Monthly added</div>
                            <div class="text-md font-semibold py-1 ml-4">Desktop: {{pc_ict.desktop}}</div>
                            <div class="text-md font-semibold py-1 ml-4">Laptop: {{pc_ict.laptop}}</div>
                        </div>
                        <div class="md:w-64 w-full max-h-full bg-gray-300 block p-4 rounded-md shadow-2xl mt-8 md:mt-0 mx-auto">
                            <div class="text-sm text-blue-700 font-semibold">Other Device Monthly added</div>
                            <div class="text-md font-semibold py-1 ml-4">Printer: {{others_ict.printer}}</div>
                            <div class="text-md font-semibold py-1 ml-4">3-in-1 Printer: {{others_ict.printer2}}</div>
                            <div class="text-md font-semibold py-1 ml-4">Scanner: {{others_ict.scanner}}</div>
                            <div class="text-md font-semibold py-1 ml-4">UPS: {{others_ict.ups}}</div>
                            <div class="text-md font-semibold py-1 ml-4">AVR: {{others_ict.avr}}</div>
                        </div>
                    </div>
                    <div class="w-full p-8 md:ml-8 ml-0 md:mt-0 mt-8">
                        <div class="text-xl font-semibold px-4 pb-6">Monthly Diagnosis</div>
                        <column-chart v-if="show" :data="column_data" xtitle="Devices" ytitle="Number"></column-chart>
                    </div>
                </div>

                <div class="float-right w-64 flex">
                    <label class="w-64 my-2">Select display: </label>
                    <select v-model="select_chart_display" @change="chart_display()" class="bg-gray-400 w-full p-1 rounded-lg focus:bg-gray-200 border-dapblue border-2 text-center focus:outline-none">
                        <option value="per_center">per Center</option>
                        <option value="per_group">per Group</option>
                    </select>

                </div>
                
                <div v-if="select_chart_display == 'per_center'" class="w-full p-4 mt-6">
                    <div class="text-3xl font-bold px-4 pb-6 w-full text-center">Total PC per Center</div>
                    <bar-chart v-if="show" :data="pc_per_center_data" height="1500px"></bar-chart>
                </div>

                <div v-if="select_chart_display == 'per_group'" class="w-full p-4 mt-6">
                    <div class="flex justify-between my-4">
                        <div class="w-full p-4">
                            <div class="text-3xl font-bold px-4 pb-6 w-full text-center">Total PC per Group (POG)</div>
                            <bar-chart v-if="show" :data="pc_per_group_pog_data" height="550px"></bar-chart>
                        </div>
                        <div class="w-full p-4">
                            <div class="text-3xl font-bold px-4 pb-6 w-full text-center">Total PC per Group (SERVICES)</div>
                            <bar-chart v-if="show" :data="pc_per_group_services_data" height="550px"></bar-chart>
                        </div>
                    </div>
                    <div class="my-4">
                        <div class="w-full p-4">
                            <div class="text-3xl font-bold px-4 pb-6 w-full text-center">Total PC per Group (CORP)</div>
                            <bar-chart v-if="show" :data="pc_per_group_corp_data" height="500px"></bar-chart>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex"
import { mapGetters } from "vuex"
export default {
    name: 'Dashboard',
    data() {
        return {
            select_chart_display: 'per_center',
            column_data: [
                ['Desktop', 0], 
                ['Laptop', 0], 
                ['Printer', 0],
                ['Scanner', 0],
                ['UPS/AVR', 0],
            ],
            pc_ict: {
                'desktop': 0,
                'laptop': 0
            },
            others_ict: {
                'printer': 0,
                'printer2': 0,
                'scanner': 0,
                'ups': 0,
                'avr': 0,
            },
            show: false,
            pc_per_group_pog_data: [
                {
                    name: 'Laptop', 
                    data: {
                        'CFG': 0,
                        'COD': 0,
                        'OP': 0,
                        'PDC': 0,
                        'PDC_PDRO': 0,
                        'PMDP': 0,
                        'SHDP': 0,
                    }
                },
                {
                    name: 'Desktop', 
                    data: {
                        'CFG': 0,
                        'COD': 0,
                        'OP': 0,
                        'PDC': 0,
                        'PDC_PDRO': 0,
                        'PMDP': 0,
                        'SHDP': 0,
                    }
                }
            ],
            pc_per_group_services_data: [
                {
                    name: 'Laptop', 
                    data: {
                        'ADMIN': 0,
                        'BUDGET': 0,
                        'DAPCC': 0,
                        'DAPCC_TAGAYTAY': 0,
                        'DAPCC_PASIG': 0,
                        'FINANCE': 0,
                        'HRMDD': 0,
                        'LIBRARY': 0,
                        'OSVP_S': 0,
                        'OSVP_P': 0,
                    }
                },
                {
                    name: 'Desktop', 
                    data: {
                        'ADMIN': 0,
                        'BUDGET': 0,
                        'DAPCC': 0,
                        'DAPCC_TAGAYTAY': 0,
                        'DAPCC_PASIG': 0,
                        'FINANCE': 0,
                        'HRMDD': 0,
                        'LIBRARY': 0,
                        'OSVP_S': 0,
                        'OSVP_P': 0,
                    }
                }
            ],
            pc_per_group_corp_data: [
                {
                    name: 'Laptop', 
                    data: {
                        'COF': 0,
                        'COSM': 0,
                        'IAS': 0,
                        'IMC': 0,
                        'LEGAL': 0,
                        'OP': 0,
                    }
                },
                {
                    name: 'Desktop', 
                    data: {
                        'COF': 0,
                        'COSM': 0,
                        'IAS': 0,
                        'IMC': 0,
                        'LEGAL': 0,
                        'OP': 0,
                    }
                }
            ],
            pc_per_center_data: [
                {
                    name: 'Laptop', 
                    data: {
                        'ADMIN': 0,
                        'APOLO': 0,
                        'BUDGET': 0,
                        'CANTEEN': 0,
                        'CFG': 0,
                        'CLINIC': 0,
                        'COD': 0,
                        'COF': 0,
                        'CORCOM': 0,
                        'CORSEC': 0,
                        'COSM': 0,
                        'DAPCC': 0,
                        'DAPCC_TAGAYTAY': 0,
                        'DAPCC_PASIG': 0,
                        'DSM': 0,
                        'ESO': 0,
                        'FINANCE': 0,
                        'GSPDM': 0,
                        'HRMDD': 0,
                        'IAS': 0,
                        'IMC': 0,
                        'LEGAL': 0,
                        'LIBRARY': 0,
                        'OP': 0,
                        'OSVP_S': 0,
                        'OSVP_P': 0,
                        'PDC': 0,
                        'PDC_PDRO': 0,
                        'PMDP': 0,
                        'REGISTRAR': 0,
                        'SHDP': 0,
                        'SPARTA': 0,
                        'VP_CCC': 0
                    }
                },
                {
                    name: 'Desktop', 
                    data: {
                        'ADMIN': 0,
                        'APOLO': 0,
                        'BUDGET': 0,
                        'CANTEEN': 0,
                        'CFG': 0,
                        'CLINIC': 0,
                        'COD': 0,
                        'COF': 0,
                        'CORCOM': 0,
                        'CORSEC': 0,
                        'COSM': 0,
                        'DAPCC': 0,
                        'DAPCC_TAGAYTAY': 0,
                        'DAPCC_PASIG': 0,
                        'DSM': 0,
                        'ESO': 0,
                        'FINANCE': 0,
                        'GSPDM': 0,
                        'HRMDD': 0,
                        'IAS': 0,
                        'IMC': 0,
                        'LEGAL': 0,
                        'LIBRARY': 0,
                        'OP': 0,
                        'OSVP_S': 0,
                        'OSVP_P': 0,
                        'PDC': 0,
                        'PDC_PDRO': 0,
                        'PMDP': 0,
                        'REGISTRAR': 0,
                        'SHDP': 0,
                        'SPARTA': 0,
                        'VP_CCC': 0
                    }
                }
            ],
            per_center_data: [
                ['ADMIN', 0],
                ['APOLO', 0],
                ['BUDGET', 0],
                ['CANTEEN', 0],
                ['CFG', 0],
                ['CLINIC', 0],
                ['COD', 0],
                ['COF', 0],
                ['CORCOM', 0],
                ['CORSEC', 0],
                ['COSM', 0],
                ['DAPCC', 0],
                ['DAPCC_TAGAYTAY', 0],
                ['DAPCC_PASIG', 0],
                ['DSM', 0],
                ['ESO', 0],
                ['FINANCE', 0],
                ['GSPDM', 0],
                ['HRMDD', 0],
                ['IAS', 0],
                ['IMC', 0],
                ['LEGAL', 0],
                ['LIBRARY', 0],
                ['OP', 0],
                ['OSVP_S', 0],
                ['OSVP_P', 0],
                ['PDC', 0],
                ['PDC_PDRO', 0],
                ['PMDP', 0],
                ['REGISTRAR', 0],
                ['SHDP', 0],
                ['SPARTA', 0],
                ['VP_CCC', 0]
            ]
        }
    },
    computed: {
        ...mapGetters({
            get_pc_permonth: 'dashboard/get_pc_data_permonth',
            get_others_permonth: 'dashboard/get_others_data_permonth',
            get_diagnose_pc_permonth: 'dashboard/get_diagnose_pc_data_permonth',
            get_diagnose_others_permonth: 'dashboard/get_diagnose_others_data_permonth',
            get_pc: 'dashboard/get_pc_data',
            get_others: 'dashboard/get_others_data',
            get_status: 'dashboard/get_status',
        })
    },
    methods: {
        ...mapActions({
            index: 'dashboard/index',
            checkToken: 'auth/checkToken',
            logoutAction: 'auth/logout'
        }),
        chart_display(){
            if(this.select_chart_display == 'per_center') {

            }
        },
        get_datas() {
            this.index().then(() => {
                for(var i = 0; i < this.get_pc_permonth.length; i++) {
                    if(this.get_pc_permonth[i].type == 'Desktop') {
                        this.pc_ict.desktop++
                    }
                    else if(this.get_pc_permonth[i].type == 'Laptop') {
                        this.pc_ict.laptop++
                    }
                }

                for(var i = 0; i < this.get_pc_permonth.length; i++) {
                    if(this.get_pc_permonth[i].device_type == 'Printer Only') {
                        this.others_ict.printer++
                    }
                    else if(this.get_pc_permonth[i].device_type == '3-in-1 Printer') {
                        this.others_ict.printer2++
                    }
                    else if(this.get_pc_permonth[i].device_type == 'Scanner') {
                        this.others_ict.scanner++
                    }
                    else if(this.get_pc_permonth[i].device_type == 'UPS') {
                        this.others_ict.ups++
                    }
                    else if(this.get_pc_permonth[i].device_type == 'AVR') {
                        this.others_ict.avr++
                    }
                }



                for(var i = 0; i < this.get_diagnose_pc_permonth.length; i++) {
                    if(this.get_diagnose_pc_permonth[i].type == 'Desktop') {
                        this.column_data[0][1] = this.column_data[0][1] + 1
                    }
                    else if(this.get_diagnose_pc_permonth[i].type == 'Laptop') {
                        this.column_data[1][1] = this.column_data[1][1] + 1
                    }
                }

                for(var i = 0; i < this.get_diagnose_others_permonth.length; i++) {
                    if(this.get_diagnose_others_permonth[i].device_type == 'Printer Only') {
                        this.column_data[2][1]++
                    }
                    else if(this.get_diagnose_others_permonth[i].type == '3-in-1 Printer') {
                        this.column_data[2][1]++
                    }
                    else if(this.get_diagnose_others_permonth[i].type == 'Scanner') {
                        this.column_data[3][1]++
                    }
                    else if(this.get_diagnose_others_permonth[i].type == 'UPS') {
                        this.column_data[4][1]++
                    }
                    else if(this.get_diagnose_others_permonth[i].type == 'AVR') {
                        this.column_data[4][1]++
                    }
                }

                for (let i = 0; i < this.get_pc.length; i++) {
                    if(this.get_pc[i].center == 'ADMIN') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.ADMIN++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.ADMIN++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.ADMIN++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.ADMIN++
                        }
                    }
                    if(this.get_pc[i].center == 'APOLO') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.APOLO++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.APOLO++
                        }
                    }
                    if(this.get_pc[i].center == 'BUDGET') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.BUDGET++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.BUDGET++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.BUDGET++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.BUDGET++
                        }
                    }
                    if(this.get_pc[i].center == 'CANTEEN') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.CANTEEN++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.CANTEEN++
                        }
                    }
                    if(this.get_pc[i].center == 'CFG') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.CFG++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.CFG++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_pog_data[0].name) {
                            this.pc_per_group_pog_data[0].data.CFG++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_pog_data[1].name){
                            this.pc_per_group_pog_data[1].data.CFG++
                        }
                    }
                    if(this.get_pc[i].center == 'CLINIC') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.CLINIC++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.CLINIC++
                        }
                    }
                    if(this.get_pc[i].center == 'COD') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.COD++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.COD++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_pog_data[0].name) {
                            this.pc_per_group_pog_data[0].data.COD++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_pog_data[1].name){
                            this.pc_per_group_pog_data[1].data.COD++
                        }
                    }
                    if(this.get_pc[i].center == 'COF') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.COF++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.COF++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_corp_data[0].name) {
                            this.pc_per_group_corp_data[0].data.COF++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_corp_data[1].name){
                            this.pc_per_group_corp_data[1].data.COF++
                        }
                    }
                    if(this.get_pc[i].center == 'CORCOM') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.CORCOM++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.CORCOM++
                        }
                    }
                    if(this.get_pc[i].center == 'CORSEC') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.CORSEC++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.CORSEC++
                        }
                    }
                    if(this.get_pc[i].center == 'COSM') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.COSM++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.COSM++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_corp_data[0].name) {
                            this.pc_per_group_corp_data[0].data.COSM++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_corp_data[1].name){
                            this.pc_per_group_corp_data[1].data.COSM++
                        }
                    }
                    if(this.get_pc[i].center == 'DAPCC') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.DAPCC++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.DAPCC++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.DAPCC++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.DAPCC++
                        }
                    }
                    if(this.get_pc[i].center == 'DAPCC-TAGAYTAY') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.DAPCC_TAGAYTAY++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.DAPCC_TAGAYTAY++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.DAPCC_TAGAYTAY++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.DAPCC_TAGAYTAY++
                        }
                    }
                    if(this.get_pc[i].center == 'DAPCC-PASIG') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.DAPCC_PASIG++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.DAPCC_PASIG++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.DAPCC_PASIG++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.DAPCC_PASIG++
                        }
                    }
                    if(this.get_pc[i].center == 'DSM') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.DSM++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.DSM++
                        }
                    }
                    if(this.get_pc[i].center == 'ESO') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.ESO++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.ESO++
                        }
                    }
                    if(this.get_pc[i].center == 'FINANCE') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.FINANCE++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.FINANCE++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.FINANCE++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.FINANCE++
                        }
                    }
                    if(this.get_pc[i].center == 'GSPDM') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.GSPDM++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.GSPDM++
                        }
                    }
                    if(this.get_pc[i].center == 'HRMDD') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.HRMDD++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.HRMDD++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.HRMDD++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.HRMDD++
                        }
                    }
                    if(this.get_pc[i].center == 'IAS') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.IAS++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.IAS++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_corp_data[0].name) {
                            this.pc_per_group_corp_data[0].data.IAS++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_corp_data[1].name){
                            this.pc_per_group_corp_data[1].data.IAS++
                        }
                    }
                    if(this.get_pc[i].center == 'IMC') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.IMC++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.IMC++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_corp_data[0].name) {
                            this.pc_per_group_corp_data[0].data.IMC++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_corp_data[1].name){
                            this.pc_per_group_corp_data[1].data.IMC++
                        }
                    }
                    if(this.get_pc[i].center == 'LEGAL') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.LEGAL++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.LEGAL++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_corp_data[0].name) {
                            this.pc_per_group_corp_data[0].data.LEGAL++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_corp_data[1].name){
                            this.pc_per_group_corp_data[1].data.LEGAL++
                        }
                    }
                    if(this.get_pc[i].center == 'LIBRARY') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.LIBRARY++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.LIBRARY++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.LIBRARY++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.LIBRARY++
                        }
                    }
                    if(this.get_pc[i].center == 'OP') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.OP++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.OP++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_corp_data[0].name) {
                            this.pc_per_group_corp_data[0].data.OP++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_corp_data[1].name){
                            this.pc_per_group_corp_data[1].data.OP++
                        }
                    }
                    if(this.get_pc[i].center == 'OSVP-S') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.OSVP_S++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.OSVP_S++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.OSVP_S++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.OSVP_S++
                        }
                    }
                    if(this.get_pc[i].center == 'OSVP-P') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.OSVP_P++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.OSVP_P++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_services_data[0].name) {
                            this.pc_per_group_services_data[0].data.OSVP_P++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_services_data[1].name){
                            this.pc_per_group_services_data[1].data.OSVP_P++
                        }
                    }
                    if(this.get_pc[i].center == 'PDC') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.PDC++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.PDC++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_pog_data[0].name) {
                            this.pc_per_group_pog_data[0].data.PDC++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_pog_data[1].name){
                            this.pc_per_group_pog_data[1].data.PDC++
                        }
                    }
                    if(this.get_pc[i].center == 'PDC-PDRO') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.PDC_PDRO++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.PDC_PDRO++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_pog_data[0].name) {
                            this.pc_per_group_pog_data[0].data.PDC_PDRO++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_pog_data[1].name){
                            this.pc_per_group_pog_data[1].data.PDC_PDRO++
                        }
                    }
                    if(this.get_pc[i].center == 'PMDP') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.PMDP++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.PMDP++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_pog_data[0].name) {
                            this.pc_per_group_pog_data[0].data.PMDP++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_pog_data[1].name){
                            this.pc_per_group_pog_data[1].data.PMDP++
                        }
                    }
                    if(this.get_pc[i].center == 'REGISTRAR') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.REGISTRAR++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.REGISTRAR++
                        }
                    }
                    if(this.get_pc[i].center == 'SHDP') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.SHDP++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.SHDP++
                        }

                        if(this.get_pc[i].type == this.pc_per_group_pog_data[0].name) {
                            this.pc_per_group_pog_data[0].data.SHDP++
                        }
                        if(this.get_pc[i].type == this.pc_per_group_pog_data[1].name){
                            this.pc_per_group_pog_data[1].data.SHDP++
                        }
                    }
                    if(this.get_pc[i].center == 'SPARTA') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.SPARTA++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.SPARTA++
                        }
                    }
                    if(this.get_pc[i].center == 'VP-CCC') {
                        if(this.get_pc[i].type == this.pc_per_center_data[0].name) {
                            this.pc_per_center_data[0].data.VP_CCC++
                        }
                        if(this.get_pc[i].type == this.pc_per_center_data[1].name){
                            this.pc_per_center_data[1].data.VP_CCC++
                        }
                    }
                    
                    
                }
                this.show = true
            })
        }
    },
    created() {
        this.get_datas()
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