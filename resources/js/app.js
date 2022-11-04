import './bootstrap';

import '../sass/app.scss'

// import { createApp } from "vue";
import { createApp } from 'vue/dist/vue.esm-bundler';
import UsuarioForm from "./componenetes/UsuarioForm.vue";

const app = createApp({});

app.component('UsuarioForm', UsuarioForm)
app.mount('#app');
