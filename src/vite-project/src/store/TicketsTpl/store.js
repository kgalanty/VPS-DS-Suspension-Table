import { useRequestGenerator } from "../../helpers/request"
import { formatDate } from "../../helpers/formatDate";
import axios from 'axios'

const TicketsTpl = {
    namespaced: true,
    state: () => ({
        templates: [],
        template: {},
        loading: false,
        page: 1,
        total: 0,
    }),
    getters:
    {

    },
    mutations: {
        setTemplates(state, templates) {
            state.templates = templates
        },
        setTemplate(state, template) {
            state.template = template
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
        loadSingle(context, tplid){
            return new Promise((resolve, reject) => {

                const params = useRequestGenerator('Tickets', [`id=${tplid}`
                ])

                 axios
                    .get(params)
                    .then((response) => {
                        if (response.data) {
                            let data =  response.data.data
                            context.commit('setTemplate', data)
                            resolve()
                        }


                    })
                    .catch(() => {
                        context.commit('setTemplate', {})
                        reject('Failed to download data. Check if you are logged in and have permission.')
                        return
                        //console.log(e)
                    });

            })
        },
        delete(context, tplid)
        {
            return new Promise((resolve, reject) => {
                context.commit('setLoading', true) //run loading

                const params = useRequestGenerator('Tickets', [`action=delete`])

                axios
                    .post(params, {id: tplid})
                    .then((response) => {
                        if (response.data) {
                            let data =  response.data.data
                            console.log(data)
                            context.commit('setTemplates', data)
                            
                            context.commit('setLoading', false)
                            resolve()
                        }


                    })
                    .catch(() => {
                        context.commit('setLoading', false)
                        reject('Failed to download data. Check if you are logged in and have permission.')
                        return
                        //console.log(e)
                    });

            })
        },
        loadData(context)
        {
            return new Promise((resolve, reject) => {
                context.commit('setLoading', true) //run loading

                const params = useRequestGenerator('Tickets', [`page=${context.state.page}`
                ])

                axios
                    .get(params)
                    .then((response) => {
                        if (response.data) {
                            let data =  response.data.data
                            console.log(data)
                            context.commit('setTemplates', data)
                            context.commit('setTotal', response.data.total)
                            context.commit('setLoading', false)
                            resolve()
                        }


                    })
                    .catch(() => {
                        context.commit('setTemplates', [])
                        context.commit('setLoading', false)
                        reject('Failed to download data. Check if you are logged in and have permission.')
                        return
                        //console.log(e)
                    });

            })
        },
        save(context, payload) {
            console.log(payload)
            return new Promise((resolve, reject) => {
                context.commit('setLoading', true) //run loading

                const params = useRequestGenerator('Tickets', [])

                axios
                    .post(params, payload)
                    .then((response) => {
                        if (response.data) {
                            context.commit('setLoading', false)
                            resolve()
                        }


                    })
                    .catch(() => {
                        context.commit('setLoading', false)
                        reject('Failed to download data. Check if you are logged in and have permission.')
                        return
                        //console.log(e)
                    });

            })
        }
    }
}
export default TicketsTpl