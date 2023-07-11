<template>
    <v-container>
        <form @submit.prevent="salvar()">
            <v-row>
                <v-col cols='3' class="mx-auto">
                    Qual nome da atividade?
                    <v-text-field v-model="nomeDaAtividade"></v-text-field>
                </v-col>
                <v-col cols='3' class="mx-auto">
                    Qual sua descrição sobre a atividade?
                    <v-text-field v-model="descricaoAtividade"></v-text-field>
                </v-col>
                <v-col cols='4' class="mx-auto">
                    Quanto tempo vai demorar sua atividade?
                    <v-text-field v-model="tempoDaAtividade" type="time" slot="activator"></v-text-field>
                </v-col>
                <v-col class="mt-11 ">
                    <v-btn type="submit" class="bg-grey">Cadastrar</v-btn>
                </v-col>
            </v-row>
            <v-alert v-if="alert" v-model="alert" text="Tarefa cadastrada com sucesso!" class="bg-green text-center"></v-alert>

        </form>
    </v-container>
</template>
<script>
import { defineComponent } from 'vue';
import axios from 'axios'
export default defineComponent({
    name: 'Cadastro',
    data() {
        return {
            nomeDaAtividade: '',
            tempoDaAtividade: '',
            descricaoAtividade: '',
            alert: false
        }
    },
    methods: {
        salvar() {
            axios.post('http://127.0.0.1:8000/api/cadastro/tarefa', {
                nome: this.nomeDaAtividade,
                tempo: this.tempoDaAtividade,
                descricao: this.descricaoAtividade
            }).then(response => {
                this.nomeDaAtividade = ''
                this.tempoDaAtividade = ''
                this.alert = true
                setTimeout(() => {
                    this.alert = false
                }, 2000);
            })
        }
    }
})
</script>