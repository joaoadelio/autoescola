<template>
    <div>
        <qalendar
            :events="events"
            :config="configs"
            :isEditable="false"
            @edit-event="edit"
            @event-was-clicked="clicked"
            @delete-event="deleta"
            @interval-was-clicked="interval"
        />

        <!-- use the modal component, pass in the prop -->
        <transition name="modal">
            <modal v-if="showModal" @close="showModal = false">

                <template v-slot:header>
                    <h1 class="modal-title fs-5">
                        Cancelar Aula
                    </h1>
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
            },
            events: [
                {
                    title: "Aula categoria B",
                    with: "Joab Garmier",
                    time: { start: "2022-11-16 13:00", end: "2022-11-16 13:50" },
                    color: "green",
                    isEditable: true,
                    id: "753944708f0f",
                    description: "Aula categoria B.",
                    disableDnD: ['month', 'week', 'day']
                },
                {
                    title: "Aula categoria A",
                    with: "Yves Cleuder",
                    time: { start: "2022-11-16 13:50", end: "2022-11-16 14:40" },
                    color: "green",
                    isEditable: true,
                    id: "5602b6f589fc",
                    disableDnD: ['month', 'week', 'day']
                },
                {
                    title: "Aula categoria A",
                    with: "Yves Cleuder",
                    time: { start: "2022-11-17 13:50", end: "2022-11-17 14:40" },
                    color: "green",
                    isEditable: true,
                    id: "5602b6f589fc",
                    disableDnD: ['month', 'week', 'day']
                }

            ],
            showModal: false,
            opcoes: {
                aulas: []
            }
        }
    },
    async mounted() {
        await this.obterAulas();
    },
    methods: {
        clicked: function () {
            console.log('clicked')
        },
        edit: function () {
            console.log('edit')
        },
        deleta: function () {
            console.log('deleta')

            this.toggleModal()
        },
        interval: function () {
            console.log('interval')
        },
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        obterAulas: function () {
            axios.get('http://localhost:8008/aulas/todas')
                .then(response => {
                    this.opcoes.aulas = response.data.data;
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
