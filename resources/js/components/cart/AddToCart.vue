<template>
    <div>
        <a class="btn btn-outline-dark mt-auto" @click="addToCart(product)">{{ message }}</a>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    props: ['product'],
    data() {
        return {
            message: 'Add to cart',
        }
    },
    methods: {
        ...mapActions(["addCart"]),

        addToCart(product) {
            product.quantity = 1;

            this.$store.dispatch('addCart', product)
                .then(() => console.log("success"))
                .catch(err => console.log(err))
        },
    },
}
</script>
