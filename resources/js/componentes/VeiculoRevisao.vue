<template>
    <div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            Revisão Detran
                        </div>
                        <div class="col-6" style="text-align: end">
                            <a
                                type="button"
                                class="btn btn-outline-primary"
                                @click="toggleModal()"
                            >
                                <i class="fa fa-plus"></i>
                                Cadastrar Revisão
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped" v-if="agendamentos.length">
                        <thead>
                            <th>Veículo</th>
                            <th>Placa</th>
                            <th>Ano Fabricação / Modelo</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Ações</th>
                        </thead>
                        <tbody>
                            <tr v-for="agendamento in agendamentos">
                                <td>{{ agendamento.veiculo.descricao }}</td>
                                <td>{{ agendamento.veiculo.placa }}</td>
                                <td>{{ agendamento.veiculo.ano_fabricacao }} / {{ agendamento.veiculo.ano_modelo }}</td>
                                <td>{{ moment(agendamento.data_agendamento).format('D/M/YYYY') }}</td>
                                <td>{{ agendamento.hora_agendamento }}</td>
                                <td>
                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger"
                                        title="Cancelar agendamento"
                                        @click.prevent="cancelarAgendamento(agendamento.id)"
                                        :disabled="loading.agendamento.deletar"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="p-5 text-center" v-else>
                        Não há nenhum agendamento
                    </div>
                </div>
            </div>
        </div>

        <transition name="modal">
            <modal v-if="showModal" @close="showModal = false">
                <template v-slot:header>
                    <h1 class="modal-title fs-5">
                        {{ acao === 'cadastrar' ? 'Cadastrar Revisão Detran' : 'Cancelar Aula' }}
                    </h1>
                </template>
                <template v-slot:body>
                    <div v-if="acao === 'deletar'">
                        // IMPLEMNTAR
                    </div>

                    <div v-else>
                        <div class="col-12 mb-3">
                            <label for="categoria_habilitacaos_id" class="form-label">
                                Veículo <span class="text-danger">*</span>
                            </label>
                            <select
                                class="form-control"
                                :class="{ 'is-invalid': v$.form.veiculo_id?.$errors.length }"
                                v-model="form.veiculo_id"
                                @blur="v$.form.veiculo_id.$touch"
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
                                <span v-for="(horario, index) in opcoes.horarios" :key="`hora-${index}`">
                                    <input
                                        v-model="form.hora_agendamento"
                                        type="checkbox"
                                        class="btn-check"
                                        :id="`hora-${index}`"
                                        :value="horario.hora"
                                        :disabled="horario.status"
                                        autocomplete="off"
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
                </template>
                <template v-slot:footer>
                    <button
                        type="button"
                        class="btn btn-outline-success"
                        @click.prevent="acaoAgendamento"
                        :disabled="loading.agendamento.cadastrar"
                    >
                        Confirmar
                    </button>
                </template>
            </modal>
        </transition>
    </div>

</template>

<script>
import moment from 'moment';
import {useToast} from "vue-toastification";
import {useVuelidate} from "@vuelidate/core";
import {helpers, required} from "@vuelidate/validators";
import APP_URL from "../utils/url";

export default {
    name: "VeiculoRevisaoCadastro",
    setup() {
        const toast = useToast();

        return {
            toast,
            v$: useVuelidate(),
            moment
        }
    },
    data () {
        return {
            acao: 'cadastrar',
            showModal: false,
            amanha: moment().format('L'),
            agendamentos: [],
            form: {
                veiculo_id: '',
                data_agendamento: '',
                hora_agendamento: []
            },
            opcoes: {
                veiculos: [],
                horarios: []
            },
            loading: {
                agendamento: {
                    cadastrar: false,
                    deletar: false
                }
            }
        }
    },
    async mounted() {
        await this.obterAgendamentos();
        await this.obterVeiculos();
    },
    validations() {
        return {
            form: {
                veiculo_id: {
                    required: helpers.withMessage('Este campo não pode estar vazio', required)
                },
                data_agendamento: {
                    required: helpers.withMessage('Este campo não pode estar vazio', required)
                },
                hora_agendamento: {
                    required: helpers.withMessage('Este campo não pode estar vazio', required)
                }
            }
        }
    },
    methods: {
        acaoAgendamento: function () {
            return this.acao === 'deletar' ? this.cancelarAgendamento() : this.cadastrarAgendamento();
        },
        obterAgendamentos: function () {
            axios.get(APP_URL + '/veiculos/revisao/todos')
                .then(response => {
                    this.agendamentos = response.data.data;
                }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                })
        },
        obterVeiculos: function () {
            axios.post(APP_URL + '/veiculos/obter')
                .then(response => {
                    this.opcoes.veiculos = response.data.data
                }).catch(error => {
                this.mostraToastMensagem(error.response.data.message, 'error');
            })
        },
        obterHorarios: function () {
            let form = {
                data: this.form.data_agendamento,
                veiculo_id: this.form.veiculo_id
            };

            if (this.form.data_agendamento) {
                axios.post(APP_URL + '/horarios', form)
                    .then(response => {
                        this.opcoes.horarios = response.data;
                    }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                })
            }
        },
        toggleModal: function (acao = 'cadastrar') {
            this.acao = acao;

            this.showModal = !this.showModal;
        },
        cadastrarAgendamento: function () {
            this.loading.agendamento.cadastrar = true;

            axios.post(APP_URL + '/veiculos/revisao', this.form)
                .then(response => {
                    this.mostraToastMensagem(response.data.message, 'success');

                    this.toggleModal();
                }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                }).finally(() => {
                    this.loading.agendamento.cadastrar = false;
                })
        },
        cancelarAgendamento: function (id) {
            this.loading.agendamento.deletar = true;

            axios.delete(APP_URL + '/veiculos/revisao/' + id)
                .then(async response => {
                    await this.obterAgendamentos();

                    this.mostraToastMensagem(response.data.message, 'success');
                }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                }).finally(() =>{
                    this.loading.agendamento.deletar = false;
                })
        },
        mostraToastMensagem: function (msg, type) {
            this.toast[type](msg);
        },
    },
    watch: {
        'form.data_agendamento': async function (novoValor) {
            if (novoValor) {
                this.obterHorarios();
            }
        }
    }
}
</script>

<style scoped>

</style>
