require('./bootstrap');
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import router from './routes'
import store from './store'
import App from './layouts/App'

axios.defaults.withCredentials = false
axios.defaults.baseURL = 'http://localhost:8000/api/'

const token = localStorage.getItem('token')
if (token) {
    axios.defaults.headers.common['Authorization'] = token
}

// manage error and expire token
axios.interceptors.response.use(undefined, function (error) {
    if (error) {
        const originalRequest = error.config;
        if (error.response.status === 401 && !originalRequest._retry) {

            originalRequest._retry = true;
            store.commit('statusCode', error.response.status);
            store.dispatch('logout')
            return router.push('/login')
        }

        if (error.response.status === 400) {
            store.commit('handleError', error.response.data.errors);
        } else {
            console.log(error.response.status)
            store.commit('handleError', JSON.parse(error.response.data.error));
        }

        store.commit('statusCode', error.response.status);
    }
})

Vue.use(VueAxios, axios)
Vue.use(VueRouter)

const app = new Vue({
    store,
    el: '#app',
    components: {App},
    router
});
