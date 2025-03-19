import { createStore } from 'vuex'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

export default createStore({
    state: {
        user: null,
        isAuthenticated: false
    },
    mutations: {
        SET_USER(state, user) {
            state.user = user
            state.isAuthenticated = !!user
        },
        CLEAR_AUTH(state) {
            state.user = null
            state.isAuthenticated = false
        }
    },
    actions: {
        initializeAuth({ commit }) {
            return new Promise((resolve, reject) => {
                if (window.location.pathname === '/login') {
                    resolve()
                    return
                }

                axios.get('/api/user')
                    .then(response => {
                        commit('SET_USER', response.data)
                        resolve()
                    })
                    .catch(error => {
                        commit('CLEAR_AUTH')
                        reject(error)
                    })
            })
        },

        async login({ commit }, credentials) {
            try {
                const response = await axios.post('/login', credentials)
                commit('SET_USER', response.data.user)
                router.visit('/dashboard')
                return response.data
            } catch (error) {
                commit('CLEAR_AUTH')
                throw error
            }
        },

        async logout({ commit }) {
            try {
                await axios.post('/logout')
                commit('CLEAR_AUTH')
                router.visit('/login')
            } catch (error) {
                console.error('Logout error:', error)
                router.visit('/login')
            }
        }
    },
    getters: {
        isAuthenticated: state => !!state.user,
        user: state => state.user
    }
}) 