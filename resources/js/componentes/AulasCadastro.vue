<template>
    <div class="card-body">
        <div class="row">
            <div class="col-12 mb-3" v-if="!controle">
                <label for="categoria_habilitacao" class="form-label">
                    Aluno <span class="text-danger">*</span>
                </label>
                <select
                    class="form-control"
                    :class="{ 'is-invalid': v$.form.aluno_id?.$errors.length }"
                    v-model="form.aluno_id"
                    @blur="v$.form.aluno_id.$touch"
                >
                    <option
                        v-for="aluno in opcoes.alunos"
                        :value="aluno.id"
                    >
                        {{ aluno.name }}
                    </option>
                </select>
                <div id="aluno_id" class="invalid-feedback">
                    {{ v$.form.aluno_id?.$errors[0]?.$message }}
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="categoria_habilitacaos_id" class="form-label">
                    Categoria <span class="text-danger">*</span>
                </label>
                <select
                    class="form-control"
                    :class="{ 'is-invalid': v$.form.categoria_habilitacaos_id?.$errors.length }"
                    v-model="form.categoria_habilitacaos_id"
                    @blur="v$.form.categoria_habilitacaos_id.$touch"
                    :disabled="!form.aluno_id"
                >
                    <option
                        v-for="categoria in opcoes.categorias"
                        :value="categoria.id"
                    >
                        {{ categoria.categoria }}
                    </option>
                </select>
                <div id="categoria_habilitacaos_id" class="invalid-feedback">
                    {{ v$.form.categoria_habilitacaos_id?.$errors[0]?.$message }}
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="veiculo_id" class="form-label">
                    Veículo <span class="text-danger">*</span>
                </label>
                <select
                    class="form-control"
                    :class="{ 'is-invalid': v$.form.veiculo_id?.$errors.length }"
                    v-model="form.veiculo_id"
                    @blur="v$.form.veiculo_id.$touch"
                    :disabled="!opcoes.veiculos.length"
                >
                    <option
                        v-for="veiculo in opcoes.veiculos"
                        :value="veiculo.id"
                    >
                        {{ veiculo.descricao }}
                    </option>
                </select>
                <div id="veiculo_id" class="invalid-feedback">
                    {{ v$.form.veiculo_id?.$errors[0]?.$message }}
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="data_agendamento" class="col-form-label">
                    Data <span class="text-danger">*</span>
                </label>
                <Datepicker
                    v-model="form.data_agendamento"
                    :class="{ 'is-invalid': v$.form.data_agendamento?.$errors.length }"
                    @blur="v$.form.data_agendamento.$touch"
                    modelType="format"
                    format="dd/MM/yyyy"
                    :hide-navigation="['time']"
                    :year-range="['2022','2023']"
                    :start-date="amanha"
                    :min-date="amanha"
                    :disabled-week-days="[0]"
                    :disabled="!form.veiculo_id"
                    esc-close
                    auto-position
                    auto-apply
                ></Datepicker>
                <div id="data_agendamento" class="invalid-feedback">
                    {{ v$.form.data_agendamento?.$errors[0]?.$message }}
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="data_agendamento" class="col-form-label">
                    Horário <span class="text-danger">*</span>
                </label>

                <div v-if="opcoes.horarios.length">
                    <span v-for="(horario, index) in opcoes.horarios">
                        <input
                            v-model="form.hora_agendamento"
                            type="radio"
                            class="btn-check"
                            :id="`hora-${index}`"
                            :key="`hora-${index}`"
                            :value="horario.hora"
                            :disabled="horario.status"
                        >
                        <label
                            class="btn btn-outline-primary"
                            :for="`hora-${index}`"
                            :key="`hora-${index}`"
                            style="margin-right: 10px"
                        >
                            {{ horario.hora }}
                        </label>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-center">
        <button
            type="submit"
            class="btn btn-success"
            style="margin-right: 10px"
            @click.prevent="salvarAula"
            :disabled="desabilitaCadastro"
        >
            Salvar
        </button>
        <button class="btn btn-outline-danger" @click.prevent="cancelar">Cancelar</button>
    </div>
</template>

<script>
import {useVuelidate} from '@vuelidate/core';
import {helpers, required} from '@vuelidate/validators';
import moment from 'moment';
import { useToast } from "vue-toastification";
import APP_URL from '../utils/url';

function iniciandoForm() {
    return {
        'aluno_id': '',
        'veiculo_id': '',
        'categoria_habilitacaos_id': '',
        'data_agendamento': '',
        'hora_agendamento': '',
        'status': 'Agendada',
        'valor_credito': 1
    }
}

export default {
    name: "AulasCadastro",
    props: {
        controle: {
            type: Number
        },
        usuarioId: {
            type: Number
        }
    },
    setup() {
        const toast = useToast();

        return {
            toast,
            v$: useVuelidate()
        }
    },
    data() {
        return {
            form: iniciandoForm(),
            alunos: [],
            opcoes: {
                alunos: [],
                veiculos: [],
                horarios: [],
                categorias: []
            },
            categorias: [],
            amanha: moment().add(1, 'days').format('L'),
            desabilitaCadastro: false,
            loading: {
                cadastro: false
            }
        }
    },
    async mounted() {
        if (!this.controle) {
            await this.obterAlunos();
        } else {
            this.form.aluno_id = this.usuarioId
        }
    },
    validations() {
        return {
            form: {
                aluno_id: {
                    required: helpers.withMessage('Este campo não pode estar vazio', required)
                },
                categoria_habilitacaos_id: {
                    required: helpers.withMessage('Este campo não pode estar vazio', required)
                },
                veiculo_id: {
                    required: helpers.withMessage('Este campo não pode estar vazio', required)
                },
                data_agendamento: {
                    required: helpers.withMessage('Este campo não pode estar vazio', required)
                }
            }
        }
    },
    methods: {
        salvarAula: async function () {
            const result = await this.v$.$validate();

            if (!result) {
                return;
            }

            this.loading.cadastro = true;

            axios.post(`${APP_URL}/aulas`, this.form)
                .then(response => {
                    this.mostraToastMensagem(response.data.message, 'success');

                    setTimeout(function () {
                        window.location = `${APP_URL}/inicio`
                    }, 1500)
                }).catch(error => {
                    if (error.response.data.errors) {
                        Object.keys(error.response.data.errors).map(errKey => {
                            Object.keys(error.response.data.errors[errKey]).map(eKey => {
                                this.mostraToastMensagem(error.response.data.errors[errKey][eKey], 'error');
                            })
                        })
                    } else {
                        this.mostraToastMensagem(error.response.data.message, 'error');
                    }
                }).finally(() => {
                    this.loading.cadastro = false;
                })
        },
        obterAlunos: function () {
            axios.get(`${APP_URL}/usuarios/obter/aluno`)
                .then(response => {
                    this.opcoes.alunos = response.data.data;
                }).catch(error => {
                if (error.response.data.errors) {
                    Object.keys(error.response.data.errors).map(errKey => {
                        Object.keys(error.response.data.errors[errKey]).map(eKey => {
                            this.mostraToastMensagem(error.response.data.errors[errKey][eKey], 'error');
                        })
                    })
                } else {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                }
            })
        },
        obterCategorias: async function () {
            axios.post(`${APP_URL}/categorias`, {alunoId: this.form.aluno_id})
                .then(response => {
                    this.opcoes.categorias = response.data.data;
                }).catch(error => {
                    // TODO
                })
        },
        obterVeiculos: async function () {
            this.categorias = [
                this.form.categoria_habilitacaos_id
            ];

            axios.post(`${APP_URL}/veiculos/obter`, this.categorias)
                .then(response => {
                    this.opcoes.veiculos = response.data.data;
                }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                })
        },
        obterHorarios: function () {
            let form = {
                data: this.form.data_agendamento,
                veiculo_id: this.form.veiculo_id
            }

            if (this.form.data_agendamento) {
                axios.post(`${APP_URL}/horarios`, form)
                    .then(response => {
                        this.opcoes.horarios = response.data;
                    }).catch(error => {
                    // TODO
                    })
            }
        },
        validaQuantidadeAulasAluno: function () {
            this.desabilitaCadastro = false;

            let form = {
                aluno_id: this.form.aluno_id,
                data: this.form.data_agendamento,
                categoria_habilitacao_id: this.form.categoria_habilitacaos_id
            };

            axios.post(`${APP_URL}/aulas/data/aluno`, form)
                .then(response => {
                    this.opcoes.horarios = response.data;
                }).catch(error => {
                    this.desabilitaCadastro = true;
                    this.mostraToastMensagem(error.response.data.message, 'error');
                })
        },
        mostraToastMensagem: function (msg, type) {
            this.toast[type](msg);
        },
        cancelar: function () {
            return window.location = `${APP_URL}/inicio`
        }
    },
    watch: {
        'form.aluno_id': function (novoValor) {
          if (novoValor) {
              this.obterCategorias();
          }
        },
        'form.categoria_habilitacaos_id': function (novoValor) {
            if (novoValor) {
                this.obterVeiculos();
            }
        },
        'form.data_agendamento': async function (novoValor) {
            if (novoValor) {
                await this.validaQuantidadeAulasAluno();
                this.obterHorarios();
            }
        },
        'form.veiculo_id': function (novoValor) {
            if (novoValor) {
                this.obterHorarios();
            }
        },
    }
}
</script>
