import Vue from 'vue'
import Router from 'vue-router'
import store from './store'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import Products from './components/products/Products.vue'
import Product from './components/products/ProductDetail.vue'
import Cart from './components/cart/ProductsShoppingCart.vue'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            name: 'home',
            path: '/',
            component: Products
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {guest: true}
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {guest: true}
        },
        {
            path: '/product/:id',
            name: 'product',
            component: Product,
        },
        {
            path: '/cart',
            name: 'cart',
            component: Cart,
            meta: { requireAuth: true }
        },
    ]
});

// middleware
router.beforeEach((to, from, next) => {
    // check if the route requires authentication and user is not logged in
    if (to.matched.some((record) => record.meta.requireAuth)) {
        if (store.getters.isLoggedIn) {
            next();
            return;
        }
        next("/login");
    } else {
        next();
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.guest)) {
        if (store.getters.isLoggedIn) {
            next("/");
            return;
        }
        next();
    } else {
        next();
    }
});

export default router;
