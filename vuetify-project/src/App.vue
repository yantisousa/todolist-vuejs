<template>
  <v-app :theme="classeParaModoEscuro">
    <v-app-bar flat color="#2196F3">
      <v-app-bar-title class="text-h6">My to-do List</v-app-bar-title>
      <v-list class="bg-black">
        <v-list-item prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg" title="USER"
          subtitle="sandra_a88@gmailcom"></v-list-item>
      </v-list>
    </v-app-bar>
    <v-main>
      <router-view></router-view>

      <v-container>
      </v-container>
    </v-main> 
    <v-navigation-drawer >
      <Navigation v-if="store.state.usuarioLogado" />

    </v-navigation-drawer>

  </v-app>
</template>
<script >
import { defineComponent } from 'vue'
import api from '@/api/api.js'
import Navigation from './views/Navigation.vue'
import { useStore } from 'vuex'
export default defineComponent({
  name: 'App',
  components: {
    Navigation
  },
  data() {
    return {
      tab: null,
      checkbox: false,
      classeParaModoEscuro: '',
      token: "",
      usuarioLogado: false
    }
  },
  mounted() {
    this.verificacaoUsuarioLogado()
  },
  methods: {
    verificacaoUsuarioLogado() {
      let token = localStorage.getItem('token')
      api.get('/usuarioLogado', {
        headers: {
          'Authorization': 'Bearer ' + token,
          'Content-Type': 'application/json'
        }
      }).then(response => {
        this.store.commit('INSERE_USUARIO_LOGADO', response.data)
        console.log(response.data);
      }).catch(error => {
        this.store.commit('INSERE_USUARIO_LOGADO', false)
      })
    },

    mudarParaModoEscuro() {
      if (this.checkbox == false) {
        this.classeParaModoEscuro = 'dark'
      } else {
        this.classeParaModoEscuro = ''
      }
    },
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
