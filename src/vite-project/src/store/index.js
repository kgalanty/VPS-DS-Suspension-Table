import Vue from 'vue'
import Vuex from 'vuex'
import VPSDSStore from './VPSDSStore/store.js'
import HandledVPSDSStore from './HandledVPSDSStore/store.js'

Vue.use(Vuex)
export default new Vuex.Store({
    state: {},
    mutations: {},
    modules:
    {
        vpsds: VPSDSStore,
        hvpsds: HandledVPSDSStore
    }

})
