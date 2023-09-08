import { useRequestGenerator } from "../../helpers/request"
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
        sorting_field: '',
        sorting_order: '',
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
        },
        setPage(state, page) {
            state.page = page
        },
        setSortingField(state, val) {
            state.sorting_field = val
        },
        setSortingOrder(state, val) {
            state.sorting_order = val
        },
    },
    actions:
    {
        setTicketStatus(context, payload) {
            return new Promise((resolve, reject) => {
                const params = useRequestGenerator('TicketsStatus', [])
                axios.post(params, payload).then(() => { resolve() })
                    .catch((e) => {
                        reject('Error in setting ticket status: ' + e)
                        return
                    });
            })
        },
        loadData(context) {
            return new Promise((resolve, reject) => {
                context.commit('setLoading', true) //run loading

                const params = useRequestGenerator('ServerList', [`page=${context.state.page}`, `withtickets=1`
                    , `sort=${context.state.sorting_field}`, `orderBy=${context.state.sorting_order}`])

                axios
                    .get(params)
                    .then((response) => {
                        if (response.data) {
                            let data = response.data.data

                            data.forEach((item, index) => {
                                if (!data[index].ticketsstatus) {
                                    data[index].ticketsstatus = {};
                                    data[index].ticketsstatus['suspensionticket'] = false;
                                    data[index].ticketsstatus['terminationticket'] = false;
                                    data[index].ticketsstatus['color'] = 'fff';
                                    data[index].ticketsstatus['notes'] = '';
                                }
                            });
                            context.commit('setServices', data)
                            context.commit('setTotal', response.data.total)
                            context.commit('setLoading', false)
                            resolve()
                        }


                    })
                    .catch((e) => {
                        console.log(e)
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