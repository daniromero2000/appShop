<template>
    <div>
        <div class="container py-5">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-9">
                        <div class="ibox">
                            <div class="ibox-title">
                                <span class="pull-right">(<strong>{{ products.length }}</strong>) items</span>
                                <h5>Items in your cart</h5>
                            </div>
                            <div class="ibox-content" v-for="(product, index) in products" :key="index">
                                <div class="table-responsive">
                                    <table class="table shoping-cart-table">
                                        <tbody>
                                        <tr>
                                            <td width="90">
                                                <div class="cart-product-imitation">
                                                    <img class="w-100" :src="product.attributes.image"
                                                         :alt="product.attributes.name"/>
                                                </div>
                                            </td>
                                            <td class="desc">
                                                <h3>
                                                    <a href="#" class="text-navy">
                                                        {{ product.attributes.name }}
                                                    </a>
                                                </h3>
                                                <p class="small">
                                                    {{ product.attributes.description }}
                                                </p>

                                                <div class="m-t-sm">
                                                    <a href="#" class="text-danger" @click="removeProduct(product.id, product.quantity)"><i
                                                        class="fa fa-trash"></i> Remove
                                                        item</a>
                                                </div>
                                            </td>

                                            <td>
                                                ${{ product.attributes.price }}
                                            </td>
                                            <td width="65">
                                                <input type="text" class="form-control" readonly
                                                       :value="product.quantity">
                                            </td>
                                            <td>
                                                <h4>
                                                    ${{ product.attributes.price * product.quantity }}
                                                </h4>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="ibox-content">
                                <form action="" method="post" @submit.prevent="submit">
                                    <button type="submit" class="btn btn-primary pull-right"><i
                                        class="fa fa fa-shopping-cart"></i>
                                        Checkout
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Cart Summary</h5>
                            </div>
                            <div class="ibox-content">
                    <span>
                        Total
                    </span>
                                <h2 class="font-bold">
                                    {{ total }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import materialCollection from '../animations/MaterialCollection.vue'
import productCard from "../products/ProductCard";
import {mapActions, mapGetters} from "vuex";

export default {
    components: {
        materialCollection,
        productCard,
    },
    data() {
        return {}
    },
    created() {
    },
    computed: {
        ...mapGetters({products: "getCart",}),
        isLoggedIn: function () {
            return this.$store.getters.isLoggedIn
        },
        total() {
            let total = 0;
            this.products.forEach(product => {
                total += parseInt(product.attributes.price) * product.quantity
            })

            return `$${total}`;
        },
    },
    methods: {
        ...mapActions(["CrateOrder"]),
        removeProduct(id, quantity) {
            this.$store.dispatch('removeProduct', {id, quantity})
                .then(() => console.log("success"))
                .catch(err => console.log(err))
        },
        submit: function () {
            if (!this.isLoggedIn) {
                this.$router.push('/login')
                return;
            }

            if (this.products.length < 1) {
                this.$router.push('/')
                return;
            }

            this.$store.dispatch('CrateOrder')
                .then((res) => {
                    this.$router.push('/')
                })
                .catch(err => {
                    this.$router.push('/login')
                    this.showError = true;
                })
        }
    },
}
</script>
<style>
h3 {
    font-size: 16px;
}

.text-navy {
    color: #1ab394;
}

.cart-product-imitation {
    text-align: center;
    height: 80px;
    width: 80px;
}

.ecommerce .tag-list {
    padding: 0;
}

.ecommerce .fa-star {
    color: #d1dade;
}

.ecommerce .fa-star.active {
    color: #f8ac59;
}

.ecommerce .note-editor {
    border: 1px solid #e7eaec;
}

table.shoping-cart-table {
    margin-bottom: 0;
}

table.shoping-cart-table tr td {
    border: none;
    text-align: right;
}

table.shoping-cart-table tr td.desc,
table.shoping-cart-table tr td:first-child {
    text-align: left;
}

table.shoping-cart-table tr td:last-child {
    width: 80px;
}

.ibox {
    clear: both;
    margin-bottom: 25px;
    margin-top: 0;
    padding: 0;
}

.ibox.collapsed .ibox-content {
    display: none;
}

.ibox:after,
.ibox:before {
    display: table;
}

.ibox-title {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #ffffff;
    border-color: #e7eaec;
    border-image: none;
    border-style: solid solid none;
    border-width: 3px 0 0;
    color: inherit;
    margin-bottom: 0;
    padding: 14px 15px 7px;
    min-height: 48px;
}

.ibox-content {
    background-color: #ffffff;
    color: inherit;
    padding: 15px 20px 20px 20px;
    border-color: #e7eaec;
    border-image: none;
    border-style: solid solid none;
    border-width: 1px 0;
}

</style>
