<template>
    <section>
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop</h1>
                    <p class="lead fw-normal text-white-50 mb-0"> Welcome to our store <b>{{ user.name }}</b></p>
                </div>
            </div>
        </header>
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <material-collection tag="div"
                                     class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <product-card
                        v-for="(product, index) in products" :key="index"
                        :product="product"
                        :data-index="index"
                    >
                    </product-card>
                </material-collection>
            </div>
        </section>
    </section>
</template>

<script>
import materialCollection from '../animations/MaterialCollection.vue'
import productCard from "./ProductCard.vue";
import {mapGetters} from "vuex";

export default {
    components: {
        materialCollection,
        productCard,
    },
    data() {
        return {
            products: [],
        }
    },
    created() {
        this.productsGet();
    },
    computed: {
        ...mapGetters({user: "getUser"}),
    },
    methods: {
        productsGet() {
            axios.get('/products').then((res) => {
                this.products = res.data.data;
            });
        },
    },
}
</script>
