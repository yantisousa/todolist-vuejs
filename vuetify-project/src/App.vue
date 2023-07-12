<template>
  <v-app :theme="classeParaModoEscuro">
    <v-app-bar flat color="#2196F3">
      <v-app-bar-title class="text-h6">My to-do List</v-app-bar-title>

    </v-app-bar>
    <v-main>
      <router-view></router-view>
    
      <v-container>
      </v-container>
    </v-main>
    <v-navigation-drawer>
      <v-card class="mx-auto" max-width="300">
        <v-list>
          <v-list-subheader>Menu</v-list-subheader>
          <hr>
          <v-list-item><router-link style="text-decoration: none;" to="/"> Minhas Tarefas</router-link></v-list-item>
          <v-divider :thickness="2"></v-divider>
          <v-list-item><router-link style="text-decoration: none;" to="/cadastro">Cadastrar Tarefa</router-link></v-list-item>
          <v-divider :thickness="2"></v-divider>
          <v-list-item @click="logout()">Sair da conta</v-list-item>
          <v-divider :thickness="2"></v-divider>
          <v-list-item><v-switch label="Modo Escuro" @click="mudarParaModoEscuro"
              v-model="checkbox"></v-switch></v-list-item>
        </v-list>
      </v-card>
    </v-navigation-drawer>
    <!-- <v-date-picker v-model="picker"></v-date-picker> -->
  </v-app>
</template>
<script >
import { defineComponent } from 'vue'
import axios from 'axios'
export default defineComponent({
  name: 'App',
  data() {
    return {
      picker: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      tab: null,
      checkbox: false,
      classeParaModoEscuro: ''
    }
  },
  methods: {
    mudarParaModoEscuro() {
      if (this.checkbox == false) {
        this.classeParaModoEscuro = 'dark'
      } else {
        this.classeParaModoEscuro = ''
      }
    },
    logout () {
      axios.get('http://127.0.0.1:8000/api/logout').then(respose => {
        console.log('deslogou');
      })
    }
  }
})

</script> 
