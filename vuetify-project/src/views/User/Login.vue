<template>
    <v-container class="mt-12">
        <v-card style="height: 500px;">
            <h1 style="text-align: center;">Login</h1>
            <form @submit.prevent="login()">
                <v-row class="mt-12">
                    <v-col class="mx-auto" cols="6">
                        <v-text-field v-model="email" type="email" label="Email" prepend-icon=""></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="mx-auto" cols="6">
                        <v-text-field v-model="password" type="password" label="Senha" prepend-icon=""></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="mx-auto" cols="6">
                        <v-btn type="submit">
                            Entrar
                        </v-btn>
                    </v-col>
                </v-row>
            </form>
        </v-card>

    </v-container>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import {useStore} from 'vuex'
export default defineComponent({
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            _token: ''
        }
    },
    mounted () {
        this.token()
    },
    methods: {
        token () {
            axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie').then(response => {

            })
        },
        login() {
            axios.post('http://127.0.0.1:8000/api/login', {
                email: this.email,
                password: this.password
            }).then(response => {
                this.store.commit('INSERE_USUARIO_LOGADO', response.data)
                console.log(this.store.state);
                this.$router.push('/')
            })
        }
    },
    setup (){
        const store = useStore();
        return {
            store
        }
    }
})
</script>