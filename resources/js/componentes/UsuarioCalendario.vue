<template>
    <div>
        <qalendar
            :events="events"
            :config="configs"
            :isEditable="false"
            @edit-event="selecionaAula($event, acaoEditar)"
            @delete-event="selecionaAula($event, 'deletar')"
        />
        <transition name="modal">
            <modal v-if="showModal" @close="showModal = false">
                <template v-slot:header>
                    <h1 class="modal-title fs-5">
                        {{ acao === 'editar' ? 'Alterar agendamento' : controle ? 'Auditar aula' : 'Cancelar Aula' }}
                        <span class="bg-warning bold">{{ `#${this.modalData.id}` }}</span>
                    </h1>
                </template>
                <template v-slot:body>
                    <div v-if="acao === 'deletar'">
                        Dados <br>
                        <div>
                            <span class="bold">Instrutor: </span>{{ `${this.modalData.with}` }} <br>
                            <span class="bold">Data: </span>{{ `${this.modalData.time.start}` }}
                        </div>
                    </div>

                    <div v-else>
                        <div class="row" v-if="controle === 0">
                            <div class="col-12 mb-3">
                                <div class="bg-warning rounded p-2 text-center">
                                        <span style="color: black; font-size: 18px">
                                            Atenção! Este reagandamento irá gerar uma taxa, você pode acompanhar no menu
                                            "Pagamento de taxas".
                                        </span>
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
                                        style="margin-right: 10px; margin-bottom: 10px"
                                    >
                                        {{ horario.hora }}
                                    </label>
                                </span>
                                </div>
                            </div>
                        </div>

                        <div v-else>
                            <div class="row">
                                <div class="col-12">
                                    <label for="veiculo_id" class="form-label">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select
                                        class="form-control"
                                        :class="{ 'is-invalid': v$.form.status?.$errors.length }"
                                        v-model="form.status"
                                        @blur="v$.form.status.$touch"
                                        :disabled="!opcoes.status.length"
                                    >
                                        <option
                                            v-for="status in opcoes.status"
                                            :value="status"
                                        >
                                            {{ status }}
                                        </option>
                                    </select>
                                    <div id="veiculo_id" class="invalid-feedback">
                                        {{ v$.form.status?.$errors[0]?.$message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-slot:footer>
                    <button
                        type="button"
                        class="btn btn-outline-success"
                        @click.prevent="acaoAula"
                        :disabled="loading.aula.atualizar"
                    >
                        Confirmar
                    </button>
                </template>
            </modal>
        </transition>
    </div>
</template>

<script>
import {useToast} from "vue-toastification";
import {useVuelidate} from "@vuelidate/core";
import moment from "moment/moment";
import {helpers, required, requiredIf} from "@vuelidate/validators";
import APP_URL from "../utils/url";

export default {
    props: {
      controle: {
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
            configs: {
                defaultMode: 'month',
                locale: 'pt-BR',
                isSilent: false,
                style: {
                    colorSchemes: {
                        primary: {
                            color: '#fff',
                            backgroundColor: '#0d6efd',
                        },
                        success: {
                            color: '#fff',
                            backgroundColor: '#198754',
                        },
                        danger: {
                            color: '#fff',
                            backgroundColor: '#dc3545',
                        },
                        warning: {
                            color: '#fff',
                            backgroundColor: '#fd7e14',
                        },
                        secondary: {
                            color: '#fff',
                            backgroundColor: '#6c757d',
                        },
                        yellow: {
                            color: '#fff',
                            backgroundColor: '#ffc107',
                        }
                    }
                },
            },
            amanha: moment().format('L'),
            events: [],
            showModal: false,
            acaoEditar: this.controle ? 'auditar' : 'editar',
            form: {
                status: '',
                data_agendamento: '',
                hora_agendamento: '',
            },
            opcoes: {
                horarios: [],
                status: [
                    'Finalizada',
                    'Falta'
                ]
            },
            loading: {
                aula: {
                    atualizar: false
                }
            },
            modalData: [],
            acao: ''
        }
    },
    async mounted() {
        await this.obterAulas();
    },
    validations() {
        return {
            form: {
                data_agendamento: {
                    required: requiredIf(function () {
                        return this.acao === 'editar' ? helpers.withMessage('Este campo não pode estar vazio', required) : false
                    })
                },
                status: {
                    required: this.acao === 'auditar' ? helpers.withMessage('Este campo não pode estar vazio', required) : false
                },

            }
        }
    },
    methods: {
        obterAulas: function () {
            axios.get(APP_URL + '/aulas/todas')
                .then(response => {
                    this.events = response.data.data;
                }).catch(error => {
                this.mostraToastMensagem(error.response.data.message, 'error');
            })
        },
        acaoAula: function () {
            return this.acao === 'editar' ? this.editarAula() : (this.acao === 'auditar' ? this.auditarAula() : this.cancelarAula())
        },
        selecionaAula: function (aulaId, acao) {
            this.acao = acao;

            this.modalData = this.events.find(evento => evento.id == aulaId);

            this.toggleModal()
        },
        cancelarAula: function () {
            if (this.modalData.id) {
                axios.delete(APP_URL + '/aulas/' + this.modalData.id)
                    .then(async response => {
                        this.mostraToastMensagem(response.data.message, 'success');

                        this.toggleModal();
                        await this.obterAulas();
                    }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                })
            }
        },
        obterHorarios: function () {
            let form = {
                aula_id: this.modalData.id
            }

            axios.post(APP_URL + '/horarios', form)
                .then(response => {
                    this.opcoes.horarios = response.data;
                }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                })
        },
        editarAula: async function () {
            const result = await this.v$.$validate();

            if (!result) {
                return;
            }

            this.loading.aula.atualizar = true;

            axios.put(APP_URL + '/aulas/' + this.modalData.id, this.form)
                .then(async response => {
                    this.mostraToastMensagem(response.data.message, 'success');

                    await this.obterAulas();
                    this.toggleModal();
                }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                }).finally(() => {
                    this.loading.aula.atualizar = false;
                })
        },
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        mostraToastMensagem: function (msg, type) {
            this.toast[type](msg);
        },
        auditarAula: async function () {
            const result = await this.v$.$validate();

            if (!result) {
                return;
            }

            console.log('boa')

            let form = {
                aula_id: this.modalData.id,
                status: this.form.status
            }

            this.loading.aula.atualizar = true;

            axios.post(APP_URL + '/aulas/auditar/', form)
                .then(async response => {
                    this.mostraToastMensagem(response.data.message, 'success');

                    this.toggleModal();
                    await this.obterAulas();
                }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                }).finally(() => {
                    this.loading.aula.atualizar = false;
                })
        }
    },
    watch: {
        'form.data_agendamento': async function (novoValor) {
            if (novoValor) {
                this.obterHorarios();
            }
        },
    }
}
</script>

<style>
.bg-yellow {
    color: #fff;
    background-color: #ffc107;
}
</style>
