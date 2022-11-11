<template>
    <div>
        <qalendar
            :events="events"
            :config="configs"
            :isEditable="false"
            @edit-event="selecionaAula($event, 'editar')"
            @delete-event="selecionaAula($event, 'deletar')"
        />
        <transition name="modal">
            <modal v-if="showModal" @close="showModal = false">
                <template v-slot:header>
                    <h1 class="modal-title fs-5">
                        {{ acao === 'editar' ? 'Editar Aula' : 'Cancelar Aula' }}
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

                    <div v-else></div>
                </template>
                <template v-slot:footer>
                    <button type="button" class="btn btn-outline-success" @click.prevent="acaoAula">Confirmar</button>
                </template>
            </modal>
        </transition>
    </div>
</template>

<script>
import {useToast} from "vue-toastification";
import {useVuelidate} from "@vuelidate/core";

export default {
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
            events: [],
            showModal: false,
            opcoes: {},
            modalData: [],
            acao: ''
        }
    },
    async mounted() {
        await this.obterAulas();
    },
    methods: {
        acaoAula: function () {
            return this.acao === 'editar' ? this.editarAula() : this.cancelarAula()
        },
        selecionaAula: function (aulaId, acao) {
            this.acao = acao;

            this.modalData = this.events.find(evento => evento.id == aulaId);

            this.toggleModal()
        },
        cancelarAula: function () {
            if (this.modalData.id) {
                axios.delete('http://localhost:8008/aulas/' + this.modalData.id)
                    .then(async response => {
                        this.mostraToastMensagem(response.data.message, 'success');

                        this.toggleModal();
                        await this.obterAulas();
                    }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                })
            }
        },
        editarAula: function () {
          alert('boa');
        },
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        obterAulas: function () {
            axios.get('http://localhost:8008/aulas/todas')
                .then(response => {
                    this.events = response.data.data;
                }).catch(error => {
                    this.mostraToastMensagem(error.response.data.message, 'error');
                })
        },
        mostraToastMensagem: function (msg, type) {
            this.toast[type](msg);
        }
    }
}
</script>
