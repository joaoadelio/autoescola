import './bootstrap';
import '../sass/app.scss'

/**
 * Iniciando o VueJS
 */
import { createApp } from 'vue/dist/vue.esm-bundler';

/**
 * Componentes em vuejs
 */
import {Qalendar} from "qalendar";
import Datepicker from '@vuepic/vue-datepicker';

import Toast from "vue-toastification";

import moment from 'moment';

import AulasCadastro from "./componentes/AulasCadastro.vue";
import UsuarioCalendario from "./componentes/UsuarioCalendario.vue";
import Modal from "./componentes/Modal.vue";
import VeiculoRevisao from "./componentes/VeiculoRevisao.vue";

/**
 * Style componenets vuejs
 */
import '../../node_modules/qalendar/dist/style.css';
import '@vuepic/vue-datepicker/dist/main.css';
import "vue-toastification/dist/index.css";

const app = createApp({})

app.config.globalProperties.$filters = {
    timeAgo(date) {
        return moment(date).fromNow()
    },
}

app.component('Qalendar', Qalendar);
app.component('Datepicker', Datepicker);
app.component('UsuarioCalendario', UsuarioCalendario);
app.component('AulasCadastro', AulasCadastro);
app.component('Modal', Modal);
app.component('VeiculoRevisao', VeiculoRevisao);

app.use(Toast).mount('#app');
