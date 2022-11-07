<template>
<div>
    <div class="modal" data-bs-backdrop="static" tabindex="-1" :id="id ? id : 'modal-novo-usuario'">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="usuario">
                        Editiar usuário - <span class="bg-info">#{{ usuario.name }}</span>
                    </h5>
                    <h5 class="modal-title" v-else>Criar novo usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="name" class="col-form-label">Nome <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                :class="{ 'is-invalid': v$.form.name?.$errors.length }"
                                @blur="v$.form.name.$touch"
                                v-model="form.name"
                            >
                            <div id="name" class="invalid-feedback">
                                {{ v$.form.name?.$errors[0]?.$message }}
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="email" class="col-form-label">Email <span
                                class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                v-model="form.email"
                                :class="{ 'is-invalid': v$.form.email?.$errors.length }"
                                @blur="v$.form.email.$touch"
                            >
                            <div id="name" class="invalid-feedback">
                                {{ v$.form.email?.$errors[0]?.$message }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="categoria_habilitacao" class="form-label">Categoria Habilitação <span
                                class="text-danger">*</span></label>
                            <select
                                class="form-control"
                                :class="{ 'is-invalid': v$.form.categoria_habilitacao?.$errors.length }"
                                v-model="form.categoria_habilitacao"
                                @blur="v$.form.categoria_habilitacao.$touch"
                            >
                                <option
                                    v-for="categoria in categoriaHabilitacao"
                                    :value="categoria.id"

                                >
                                    {{ categoria.categoria }}
                                </option>
                            </select>
                            <div id="name" class="invalid-feedback">
                                {{ v$.form.categoria_habilitacao?.$errors[0]?.$message }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="password" class="col-form-label">Senha <span
                                class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                id="password"
                                v-model="form.password"
                                :class="{ 'is-invalid': v$.form.password?.$errors.length }"
                                @blur="v$.form.password.$touch"
                            >
                            <div id="name" class="invalid-feedback">
                                {{ v$.form.password?.$errors[0]?.$message }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="cpf" class="col-form-label">CPF <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control"
                                id="cpf"
                                v-model="form.cpf"
                                :class="{ 'is-invalid': v$.form.cpf?.$errors.length }"
                                @blur="v$.form.cpf.$touch"
                            >
                            <div id="name" class="invalid-feedback">
                                {{ v$.form.cpf?.$errors[0]?.$message }}
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="rg" class="col-form-label">RG</label>
                            <input
                                type="text"
                                class="form-control"
                                id="rg"
                                name="rg"
                                v-model="form.rg"
                            >
                        </div>
                        <div class="col-12">
                            <label for="grupo" class="form-label">Grupo <span class="text-danger">*</span></label>
                            <select
                                class="form-control"
                                v-model="form.grupo"
                                :class="{ 'is-invalid': v$.form.grupo?.$errors.length }"
                                @blur="v$.form.grupo.$touch"
                            >
                                <option v-for="(role, index) in roles" :value="index">{{ role }}</option>
                            </select>
                            <div id="name" class="invalid-feedback">
                                {{ v$.form.grupo?.$errors[0]?.$message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" @click.prevent="submit">Salvar</button>
                    <button type="button" class="btn btn-outline-danger" ref="closeModal" data-bs-dismiss="modal" @click="clearForm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {useVuelidate} from '@vuelidate/core';
import {helpers, required, email, minLength} from '@vuelidate/validators';
import { useToast } from "vue-toastification";

function iniciandoForm() {
    return {
        'name': '',
        'email': '',
        'password': '',
        'cpf': '',
        'rg': '',
        'grupo': '',
        'categoria_habilitacao': ''
    }
}

export default {
    name: "UsuarioForm",
    props: [
        'categoriaHabilitacao',
        'roles',
        'usuario',
        'id'
    ],
    setup() {
        const toast = useToast();

        return {
            v$: useVuelidate(),
            toast
        }
    },
    data() {
        return {
            form: iniciandoForm()
        }
    },
    validations() {
        return {
            form: {
                name: { required: helpers.withMessage('Este campo não pode estar vazio', required) },
                email:{
                    required: helpers.withMessage('Este campo não pode estar vazio', required),
                    email: helpers.withMessage('O valor não é um endereço de e-mail válido', email)
                },
                password: {
                    required: helpers.withMessage('Este campo não pode estar vazio', required),
                    minLength: helpers.withMessage('Este campo deve ter pelo menos 6 caracteres', minLength(6))
                },
                cpf: { required: helpers.withMessage('Este campo não pode estar vazio', required) },
                grupo: { required: helpers.withMessage('Este campo não pode estar vazio', required) },
                categoria_habilitacao: { required: helpers.withMessage('Este campo não pode estar vazio', required) }
            }

        }
    },
    methods: {
        submit: async function () {
            const result = await this.v$.$validate()
            if (!result) {

                return;
            }

            axios.post('http://localhost:8008/usuarios', this.form)
                .then(async response => {
                    await this.showMessage(response.data.message);
                    await this.fecharModal();

                    setTimeout(function (){
                        window.location.href = '';
                    }, 3000);
                }).catch(error => {
                if(error.response.data.errors) {
                    Object.keys(error.response.data.errors).map(errKey => {
                        Object.keys(error.response.data.errors[errKey]).map(eKey => {
                            this.showMessage(error.response.data.errors[errKey][eKey], 'error');
                        })
                    })
                } else {
                    this.showMessage(error.response.data.message, 'error');
                }
            })
        },
        showMessage: function (msg, type = 'success', timeout = 3000) {
            this.toast[type](msg, {
                timeout: 3000,
                newestOnTop: true
            });
        },
        clearForm: function () {
            this.form = iniciandoForm();
        },
        fecharModal: async function () {
            this.$refs.closeModal.click();
        }
    }
}
</script>

<style scoped>

</style>
