<template>
    <v-container class="mt-12">
        <v-card style="height: 500px;" class="border">
            <h1 style="text-align: center;">Cadastro</h1>
            <form @submit.prevent="cadastrar()">
                <v-row class="mt-12">
                    <v-col class="mx-auto" cols="6">
                        <v-text-field v-model="nome" type="text" label="Nome" prepend-icon=""></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="">
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
                            Criar Conta
                        </v-btn>
                    </v-col>
                </v-row>
            </form>
        </v-card>

    </v-container>
</template>
<script>
import { defineComponent } from 'vue';
import axios from 'axios'
export default defineComponent({
    name: 'CadastroUsuario',
    data() {
        return {
            nome: '',
            email: '',
            password: '',
            _token: ''
        }
    },
    mounted (){
        this.token()
    },
    methods: {
        async token () {
            await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie',
            {
                withCredentials: true
            }
            ).then(response => {
                console.log(response.data);
                
            })
        },
        cadastrar() {
            axios.post('http://127.0.0.1:8000/api/store/user', {
             
                name: this.nome, 
                email: this.email,
                password: this.password
            }).then(response => {
                this.$router.push('/login')
            })
        },
    }
})
</script>