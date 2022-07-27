<template>
    <div class="col mb-5">
        <div class="card h-100">
            <!-- Product image-->
            <img class="card-img-top" :src="product.attributes.image" :alt="product.attributes.name"/>
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder"><a class="btn-link" :href="'/product/' + product.id">{{ product.attributes.name }}</a></h5>
                    <!-- Product price-->
                    ${{ product.attributes.price }}
                </div>
            </div>
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center" >
                <add-to-cart :product=product></add-to-cart>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AddToCart from "../cart/AddToCart.vue";

export default {
    components: {
        AddToCart
    },
    props: ['product'],
}
</script>
<style>
 .btn-link{
     color: inherit;
     text-decoration: none;
 }
 .card-img-top {
     max-height: 150px !important;
 }
</style>
