<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="card form-holder">
                    <div class="card-body pt-5 pb-2">
                        <h1 class="text-muted mb-4">Login</h1>
                        <form action="" method="post" @submit.prevent="submit">
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" name="" class="form-control" placeholder="Usuario"
                                       v-model="form.email"/>
                            </div>
                            <div class="form-group my-3">
                                <label>Contraseña</label>
                                <input type="password" name="" class="form-control" placeholder="Contraseña"
                                       v-model="form.password"/>
                            </div>
                            <p v-if="showError" class="text-danger">El usuario o contraseña son incorrectas</p>
                            <div class="row">
                                <div class="col-6 text-right">
                                    <input type="submit" class="btn btn-primary pr-5 pl-5 my-3" value=" Confirm "/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'Login',
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            showError: false,
        }
    },
    computed: {
        isLoggedIn: function () {
            return this.$store.getters.isLoggedIn
        },
    },
    methods: {
        ...mapActions(["login"]),

        submit: function () {
            this.$store.dispatch('login', this.form)
                .then((res) => {
                    if (! this.isLoggedIn) {
                        this.showError = true
                        return;
                    }

                    this.$router.push('/')
                })
                .catch(err => this.showError = true)
        }
    }
}
</script>

<style>
.form-holder {
    margin-top: 20%;
    margin-bottom: 20%;
}
</style>
