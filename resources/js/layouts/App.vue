<template>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <router-link to="/" class="navbar-brand"> Shop</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link active">Home</router-link>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <button v-if="isLoggedIn" class="btn btn-outline-secondary mx-2" type="submit"
                                @click="logout()">
                            Logout
                        </button>
                        <router-link to="/login" v-if="!isLoggedIn">
                            <button class="btn btn-primary mx-1" type="submit">
                                Login
                            </button>
                        </router-link>
                        <router-link to="/register" v-if="!isLoggedIn">
                            <button class="btn btn-outline-secondary mx-2" type="submit">
                                Register
                            </button>
                        </router-link>
                        <router-link to="/cart">
                            <button class="btn" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                Cart
                                <span class="badge bg-dark text-white ms-1 rounded-pill">{{ productsCount }}</span>
                            </button>
                        </router-link>
                    </form>
                </div>
            </div>
        </nav>
        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "App",
    data() {
        return {}
    },
    computed: {
        isLoggedIn: function () {
            return this.$store.getters.isLoggedIn
        },
        productsCount() {
            return this.$store.state.totalProducts;
        }
    },
    created() {
        if (this.isLoggedIn) {
            this.$store.dispatch('getUser');
        }
    },
    methods: {
        async logout() {
            await this.$store.dispatch('logout')
            await this.$router.push('/login')
        }
    },
}
</script>

