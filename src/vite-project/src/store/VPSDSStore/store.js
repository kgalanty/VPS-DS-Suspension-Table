import { useRequestGenerator } from "../../helpers/request"
import axios from 'axios'

const VPSDSStore = {
    namespaced: true,
    state: () => ({
        services: [],
        total: 0,
        loading: false,
        page: 1,
        date: new Date()
    }),
    getters:
    {

    },
    mutations: {
        setServices(state, services) {
            state.services = services
        },
        setLoading(state, loading) {
            state.loading = loading
        },
        setDate(state, date) {
            state.date = date
        }
    },
    actions:
    {
        loadData(context) {
            return new Promise((resolve, reject) => {
                context.commit('setLoading', true) //run loading

                const params = useRequestGenerator('VPSDSTable', [`page=${context.state.page}`,
                `date=${context.state.date ?? ''}`])

                axios
                    .get('addonmodules.php?' + params)
                    .then((response) => {
                        context.commit('setChats', { 'total': 0 })
                        if (response) {
                            context.commit('setServices', response.data)
                            context.commit('setLoading', false)
                            resolve()
                        }


                    })
                    .catch(() => {
                        context.commit('setServices', [])
                        context.commit('setLoading', false)
                        reject('Failed to download data. Check if you are logged in and have permission.')
                        return
                        //console.log(e)
                    });

            })
        }
    }
}
export default VPSDSStore