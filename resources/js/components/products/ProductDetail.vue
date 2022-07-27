<template>
    <div>
        <div class="container py-5">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body row">
                        <div class="col-md-6">
                            <div class="pro-img-details">
                                <img :src="product.attributes.image" alt="">
                            </div>
                        </div>
                        <div class="col-md-6 py-5 px-3">
                            <h2 class="pro-d-title">
                                {{ product.attributes.name }}
                            </h2>
                            <p>
                                {{ product.attributes.description }}
                            </p>
                            <div class="m-bot15"><strong>Price : </strong> <span
                                class="pro-price"> ${{ product.attributes.price }}</span></div>
                            <div class="container-add-bottom">
                                <add-to-cart :product=product></add-to-cart>
                            </div>
                        </div>
                    </div>
                </section>
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
    data() {
        return {
            product: null,
        }
    },
    created() {
        this.productGet();
    },

    methods: {
        productGet() {
            axios.get('/product/' + this.$route.params.id).then((res) => {
                this.product = res.data.data;
            });
        },
    },
}
</script>

<style>

.prod-cat li a {
    border-bottom: 1px dashed #d9d9d9;
}

.prod-cat li a {
    color: #3b3b3b;
}

.prod-cat li ul {
    margin-left: 30px;
}

.prod-cat li ul li a {
    border-bottom: none;
}

.prod-cat li ul li a:hover, .prod-cat li ul li a:focus, .prod-cat li ul li.active a, .prod-cat li a:hover, .prod-cat li a:focus, .prod-cat li a.active {
    background: none;
    color: black;
}

.product-list img {
    width: 100%;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
}

.product-list .pro-img-box {
    position: relative;
}

.adtocart i {
    color: #fff;
    font-size: 25px;
    line-height: 42px;
}

.product-list .price {
    color: #fc5959;
    font-size: 15px;
}

.pro-img-details {
    margin-left: -15px;
}

.pro-img-details img {
    width: 100%;
}

.pro-d-title {
    font-size: 2em;
    margin-top: 0;
    margin-bottom: 1em;
}

.product_meta span {
    display: block;
    margin-bottom: 10px;
}

.product_meta a, .pro-price {
    color: #fc5959;
}

.pro-price, .amount-old {
    font-size: 18px;
    padding: 0 10px;
}

.pro-img-list a {
    float: left;
    margin-right: 10px;
    margin-bottom: 10px;
}

.container-add-bottom {
    display: flex;
    align-items: end;
    justify-content: end;
}
</style>
