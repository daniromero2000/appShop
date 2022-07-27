<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="card form-holder">
                    <div class="card-body pt-4 pb-2">
                        <h1 class="text-muted mb-4">Register</h1>
                        <form action="" method="post" @submit.prevent="submit">
                            <div class="form-group my-2">
                                <label>Nombre</label>
                                <input type="text" name="" class="form-control" placeholder="Nombre"
                                       v-model="form.name"/>
                            </div>
                            <div class="form-group my-2">
                                <label>Correo</label>
                                <input type="email" name="" class="form-control" placeholder="Correo"
                                       v-model="form.email"/>
                            </div>
                            <div class="form-group my-2">
                                <label>Contraseña</label>
                                <input type="password" name="" class="form-control" placeholder="Contraseña"
                                       v-model="form.password"/>
                            </div>
                            <div class="form-group my-2">
                                <label>Confirmar Contraseña</label>
                                <input type="password" name="" class="form-control" placeholder="Confirmar Contraseña"
                                       v-model="form.password_confirmation"/>
                            </div>
                            <div class="row">
                                <div v-if="errorsForm.length">
                                    <div class="text-danger d-block">Validar campos
                                        <br>
                                        <span>Por favor, corrija el(los) siguiente(s) error(es):</span>
                                        <ul>
                                            <li v-for="error in errorsForm">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col text-left">
                                    <input type="submit" class="btn btn-primary pr-5 pl-5" value=" Confirm "/>
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
    name: 'Register',
    data() {
        return {
            errorsForm: [],
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
        }
    },
    computed: {
        ...mapGetters({errors: "getError"}),
        showError() {
            return this.$store.getters.getError;
        }
    },
    methods: {
        ...mapActions(["Register"]),
        submit: function () {
            this.errorsForm = [];

            if (!this.form.name) {
                this.errorsForm.push('El nombre es obligatorio.');
            }

            if (!this.form.email) {
                this.errorsForm.push('El correo es obligatorio.');
            }

            if (!this.form.password) {
                this.errorsForm.push('La contraseña es obligatoria.');
            }

            if (!this.form.password_confirmation) {
                this.errorsForm.push('Se debe confirmar la contraseña.');
            }

            let data = {
                name: this.form.name,
                email: this.form.email,
                password: this.form.password,
                password_confirmation: this.form.password_confirmation,
            };

            this.$store.dispatch('Register', data)
                .then(() => console.log('error'))
                .catch(err => {
                    this.showError = true;
                })
        },
    },
}
</script>
<style>
.form-holder {
    margin-top: 20%;
    margin-bottom: 20%;
}
</style>
