import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: {},
        error: '',
        cart: JSON.parse(localStorage.getItem('cart')) || [],
        totalProducts: localStorage.getItem('totalProducts') || 0,
        statusCode: 0
    },
    mutations: {
        authRequest(state) {
            state.status = 'loading'
        },
        authSuccess(state, token) {
            state.status = 'success'
            state.token = token
        },
        setUser(state, user) {
            state.user = user
        },
        handleError(state, error) {
            state.error = error
        },
        logout(state) {
            state.status = ''
            state.token = ''
        },
        setCart(state, cart) {
            state.cart = cart
        },
        setTotalProducts(state, total) {
            state.totalProducts = total
        },
        cleanCart(state) {
            state.cart = [];
            state.totalProducts = 0;
        },
        statusCode(state, code) {
            state.statusCode = code;
        },
    },
    actions: {
        login({commit}, user) {
            return axios.post('login', user)
                .then(response => {
                    const token = 'Bearer ' + response.data.access_token
                    const user = response.data.user

                    commit('authSuccess', token, user)
                    commit('setUser', user)
                    commit('handleError', '')
                    localStorage.setItem('token', token)
                    axios.defaults.headers.common['Authorization'] = token
                    commit('statusCode', 200)
                })
                .catch(err => {
                    localStorage.removeItem('token')
                });
        },
        Register({commit}, user) {
            commit('authRequest')
            return axios.post('register', user)
                .then(response => {
                    const token = 'Bearer ' + response.data.access_token
                    const user = response.data.user

                    commit('authSuccess', token, user)
                    commit('handleError', '')
                    localStorage.setItem('token', token)
                    axios.defaults.headers.common['Authorization'] = token
                    commit('statusCode', 200)
                })
                .catch(err => {
                    localStorage.removeItem('token')
                });
        },
        logout({commit}) {
            return new Promise((resolve, reject) => {
                commit('logout')
                localStorage.removeItem('token')
                delete axios.defaults.headers.common['Authorization']
                resolve()
            })
        },
        getUser({commit}) {
            return axios
                .get("user")
                .then(response => {
                    commit('setUser', response.data)
                })
                .catch(() => {
                    localStorage.removeItem("authToken");
                });
        },
        removeProduct({commit, state}, {id, quantity}) {
            const index = state.cart.findIndex(p => p.id === id);

            if (index !== -1) {
                let totalProducts = state.totalProducts - parseInt(quantity)
                state.cart.splice(index, 1);

                commit('setCart', state.cart)
                commit('setTotalProducts', totalProducts)
                localStorage.setItem('cart', JSON.stringify(state.cart));
                localStorage.setItem('totalProducts', totalProducts);
            }
        },
        addCart({commit, state}, productSave) {
            let existProduct = state.cart.find(cart => cart.id === productSave.id);

            if (existProduct) {
                existProduct.quantity++
            } else {
                state.cart.push(productSave)
            }

            state.totalProducts++

            commit('setCart', state.cart)
            commit('setTotalProducts', state.totalProducts)

            localStorage.setItem('cart', JSON.stringify(state.cart));
            localStorage.setItem('totalProducts', state.totalProducts);
        },
        CrateOrder({commit}) {
            return axios.post('order', {"cart": this.state.cart})
                .then(response => {
                    if (this.state.statusCode === 401 || this.state.statusCode === 400) {
                        return;
                    }

                    commit('cleanCart')
                    commit('statusCode', 200)

                    localStorage.removeItem("cart");
                    localStorage.removeItem("totalProducts");
                })
                .catch(err => {
                    commit('handleError', err)
                });
        },
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        getUser: state => state.user,
        getError: state => state.error,
        getCart: state => state.cart,
    }
})
