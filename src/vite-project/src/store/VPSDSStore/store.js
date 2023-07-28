import { useRequestGenerator } from "../../helpers/request"
import { formatDate } from "../../helpers/formatDate";
import axios from 'axios'

const VPSDSStore = {
    namespaced: true,
    state: () => ({
        services: [],
        total: 0,
        loading: false,
        page: 1,
        date: new Date(),
        total: 0,
    }),
    getters:
    {

    },
    mutations: {
        setServices(state, services) {
            state.services = services
        },
        setTotal(state, total) {
            state.total = total
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
        setTicketStatus(context, payload)
        {
            console.log(payload)
            const params = useRequestGenerator('Tickets', [`serviceid=${payload.serviceid}`, `val=${payload.val}`, `column=${payload.param}`])
            axios.post(params)
        },
        loadData(context) {
            return new Promise((resolve, reject) => {
                context.commit('setLoading', true) //run loading

                const params = useRequestGenerator('ServerList', [`page=${context.state.page}`,
                `date=${formatDate(context.state.date.toDateString()) ?? ''}`])

                axios
                    .get(params)
                    .then((response) => {
                        if (response.data) {
                            let data =  response.data.data
                            data.forEach((item, index) => {
                                if (!data[index].ticketsstatus) {
                                    data[index].ticketsstatus =  {};
                                    data[index].ticketsstatus['suspensionticket'] = false;
                                    data[index].ticketsstatus['terminationticket'] = false;
                                    data[index].ticketsstatus['notes'] = '';
                                }
                              });
                            context.commit('setServices', data)
                            context.commit('setTotal', response.data.total)
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