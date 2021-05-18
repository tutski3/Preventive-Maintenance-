<template>
    <div id="main" class="antialiased">
        <div v-if="authenticated">
            <navside/>
        
        </div>
          <router-view></router-view>
    </div>
</template>


<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import navside from './components/NavSide'

export default {
    name: 'App',
    data() {
        return {
            selected: 0,
            showmenu: false,
            showmenu2: false
        }
    },
    computed:{
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
        })
    },
    mounted() {

    }
}
</script>

<style scoped>
.rotate {
    animation:rotate-back .3s ease;
    animation-timing-function: cubic-bezier(.8,0,.5,.8);
}

@keyframes rotate {
    from { -webkit-transform: rotate(0deg) } 
    to { -webkit-transform: rotate(360deg) } 
}

.rotate-back {
    animation:rotate .3s ease;
    animation-timing-function: cubic-bezier(.8,0,.5,.8);
}

@keyframes rotate-back {
    from { -webkit-transform: rotate(360deg) } 
    to { -webkit-transform: rotate(0deg) } 
}
</style>