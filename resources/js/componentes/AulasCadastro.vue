<template>
    <div>
        <div class="row">
            <div class="col-12 mb-3">
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
            <div class="col-12">
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
<!--            <div class="col-12">-->
<!--                <label for="password" class="col-form-label">-->
<!--                    Aluno <span class="text-danger">*</span>-->
<!--                </label>-->
<!--                <input-->
<!--                    type="text"-->
<!--                    class="form-control"-->
<!--                    id="aluno_id"-->
<!--                    v-model="form.name"-->
<!--                    :class="{ 'is-invalid': v$.form.aluno_id?.$errors.length }"-->
<!--                    @blur="v$.form.aluno_id.$touch"-->
<!--                >-->
<!--                <div id="aluno_id" class="invalid-feedback">-->
<!--                    {{ v$.form.aluno_id?.$errors[0]?.$message }}-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</template>

<script>
import {useVuelidate} from '@vuelidate/core';
import {helpers, required} from '@vuelidate/validators';
import moment from 'moment';

function iniciandoForm() {
    return {
        'aluno_id': '',
        'veiculo_id': '',
        'categoria_habilitacaos_id': '',
        'data_agendamento': '',
        'hora_agendamento': '',
        'status': '',
        'valor_credito': ''
    }
}

export default {
    name: "AulasCadastro",
    setup() {
        return {v$: useVuelidate()}
    },
    data() {
        return {
            form: iniciandoForm(),
            alunos: [],
            opcoes: {
                alunos: [],
                veiculos: [],
                horarios: []
            },
            categorias: [],
            amanha: moment().add(1, 'days').format('L')
        }
    },
    async mounted() {
        await this.obterAlunos();
    },
    validations() {
        return {
            form: {
                aluno_id: {
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
        salvar: async function () {
            const result = await this.v$.$validate()

            if (!result) {
                return;
            }

            axios.post('http://localhost:8008/usuarios', this.form)
                .then(response => {
                    console.log(response.data)
                }).catch(error => {
                if (error.response.data.errors) {
                    console.log(error.response.data.errors)
                } else {
                    console.log(error.response.data.message)
                }
                // if(error.response.data.errors) {
                //     Object.keys(error.response.data.errors).map(errKey => {
                //         Object.keys(error.response.data.errors[errKey]).map(eKey => {
                //             this.showErrorMessage(error.response.data.errors[errKey][eKey]);
                //         })
                //     })
                // } else {
                //     this.showErrorMessage('Houve um problema ao tentar salvar os dados! '+error.response.data.message);
                // }
            })
        },
        limparForm: function () {
            this.form = iniciandoForm()
        },
        obterAlunos: function () {
            axios.get('http://localhost:8008/usuarios/obter/aluno')
                .then(response => {
                    this.opcoes.alunos = response.data.data;
                }).catch(error => {
                    if(error.response.data.errors) {
                        Object.keys(error.response.data.errors).map(errKey => {
                            Object.keys(error.response.data.errors[errKey]).map(eKey => {
                                // this.showErrorMessage(error.response.data.errors[errKey][eKey]);
                            })
                        })
                    } else {
                        // this.showErrorMessage('Houve um problema ao tentar salvar os dados! '+error.response.data.message);
                    }
                })
        },
        obterVeiculos: async function () {
            this.categorias = [];
            let aluno = this.opcoes.alunos.find(aluno => aluno.id == this.form.aluno_id);

            aluno.categoria_habilitacao.forEach(categoria => {
                this.categorias.push(categoria.id)
            })

            if (this.categorias.length) {
                axios.post('http://localhost:8008/veiculos/obter', this.categorias)
                    .then(response => {
                        this.opcoes.veiculos = response.data.data;
                    }).catch(error => {
                        // TODO
                    })
            }
        },
        obterHorarios: function () {
            let form = {
                data: this.form.data_agendamento
            }

            if (this.form.data_agendamento) {
                axios.post('http://localhost:8008/horarios', form)
                    .then(response => {
                        this.opcoes.horarios = response.data;
                    }).catch(error => {
                    // TODO
                })
            }
        }
    },
    watch: {
        'form.aluno_id': function (novoValor) {
            if (novoValor) {
                this.obterVeiculos();
            }
        },
        'form.data_agendamento': function (novoValor) {
            if (novoValor) {
                this.obterHorarios();
            }
        }
    }
}
</script>

<style scoped>

</style>
