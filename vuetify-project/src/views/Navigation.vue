<template>
    <v-card  class="mx-auto" max-width="300">
        <v-list>
            <v-list-subheader>Menu</v-list-subheader>
            <hr>
            <v-list-item to="/"> Minhas Tarefas</v-list-item>
            <v-divider :thickness="2"></v-divider>
            <v-list-item to="/cadastro">Cadastrar Tarefa</v-list-item>
            <v-divider :thickness="2"></v-divider>
            <v-list-item @click="logout()">Sair da conta</v-list-item>
            <v-divider :thickness="2"></v-divider>
            <v-list-item><v-switch label="Modo Escuro" @click="mudarParaModoEscuro"
                    v-model="checkbox"></v-switch></v-list-item>
        </v-list>
    </v-card>
</template>
<script >
import { defineComponent } from 'vue'
import api from '@/api/api.js'
import { useStore } from 'vuex'
export default defineComponent({
    name: 'App',
    data() {
        return {
            token: "",
        }
    },
    methods: {
        logout() {
            this.token = localStorage.getItem('token')
            api.get('/logout',
                {
                    headers: {
                        "Authorization": "Bearer " + this.token,
                        "Content-Type": 'application/json'
                    }
                }
            ).then(respose => {
                this.$router.push('/login')
                localStorage.removeItem('token')
                this.store.commit('INSERE_USUARIO_LOGADO', false)
                this.token = ''
            })
        }

    },
    setup() {
        const store = useStore();
        return {
            store
        }
    }
})

</script> 
