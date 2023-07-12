<template>
  <v-row>
    <v-tabs @click="exibirAtividadesPorStatus" v-model="tab" align-tabs="title" class="mx-auto mt-10">
      <v-tab>
        Atividades Pendentes
      </v-tab>
      <v-tab>
        Atividades em Andamento
      </v-tab>
      <v-tab>
        Atividades Concluídas
      </v-tab>
    </v-tabs>
  </v-row>
  <v-container>
    <v-row class="block-md-column">
      <v-col v-if="tab == 0" v-for="tarefa in tarefas" cols="3">
        <v-card class="mt-6 ms-12 border" :title="tarefa.nome_tarefa" :subtitle="tarefa.tempo_tarefa">
          <v-card-actions>
            <v-btn @click="iniciarTarefa(tarefa.id)" class="mx-auto">Iniciar tarefa</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col v-if="tab == 1" v-for="tarefa in tarefas" cols="4">
        <v-card :loading="tarefa.loading" class="mt-6 ms-12 border" :title="tarefa.nome_tarefa"
        :subtitle="tarefa.tempo_tarefa">
        <v-card-actions>
          <v-btn :disabled="disabledBotoes" @click="comecarContagem(tarefa.id)" class="mx-auto">Começar contagem</v-btn>
          <v-btn @click="pararContagem(tarefa.id)" class="mx-auto">Terminar</v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <v-col v-if="tab == 2" v-for="tarefa in tarefas" cols="4">
      <v-card class="mt-6 ms-12 text-center border" :title="tarefa.nome_tarefa">
        Tempo de conclusão: <b>{{ tarefa.tempo_tarefa_finalizada }}</b> <br>
      </v-card>
    </v-col>
    <v-row class="text-center mt-12" v-if="tarefas.length < 1">
      <v-col>
        Você ainda não tem tarefas
      </v-col>
    </v-row>
  </v-row>
</v-container>
<v-col v-if="display" class="position-absolute " style="right: 0; bottom: 0;" cols="3">
  <v-alert closable :title="textoAlerta" variant="outlined"></v-alert>
</v-col>
</template>
<script >
import { defineComponent } from 'vue'
import axios from 'axios'
export default defineComponent({
  name: 'App',
  data() {
    return {
      tab: null,
      checkbox: false,
      tarefas: [],
      mudancaStatus: 0,
      disabledBotoes: false,
      loading: false,
      textoAlerta: '',
      display: false,
      cronometro: '',
      tempoInicial: 0,
      tempoFinal: '',
      _token: ''
    }
  },
  mounted() {
    this.exibirAtividadesPorStatus(),
    this.token()
  },
  methods: {
    exibirAtividadesPorStatus() {
      axios.get(`http://127.0.0.1:8000/api/index/tarefa/${this.tab}`).then(response => {
        this.tarefas = response.data
      })

    },
    iniciarTarefa(id) {
      this.textoAlerta = "Tarefa iniciada!"
      this.display = true
      setTimeout(() => {
        this.display = false
      }, 1000);
      if (this.tab == 0) {
        this.mudancaStatus = 1
        axios.put(`http://127.0.0.1:8000/api/update/tarefa/${id}`, {
          status: this.mudancaStatus,
          _token: this._token
        }).then(response => {
          let novasAtividadesAposIniciar = this.tarefas.filter(tarefa => tarefa.id != id)
          this.tarefas = novasAtividadesAposIniciar
        })

      }
    },
    comecarContagem(id) {
      this.textoAlerta = 'Começou a contagem da sua tarefa'
      this.display = true
      setTimeout(() => {
        this.display = false
      }, 2000);
      this.mudancaStatus = 2
      this.loading = true
      const index = this.tarefas.findIndex((tarefa) => tarefa.id == id)
      this.tarefas[index] = {
        ...this.tarefas[index],
        loading: this.loading
      }
      this.tempoInicial = this.tarefas[index].tempo_tarefa


      // MANIPULAÇÃO DO TEMPO
      let tempoFuturo = new Date()
      let minutos = this.tarefas[index].tempo_tarefa.substr(0, 2)
      let segundos = this.tarefas[index].tempo_tarefa.substr(3, 5)
      tempoFuturo.setHours('00')
      tempoFuturo.setMinutes(minutos)
      tempoFuturo.setSeconds(segundos)
      let novoMinuto = tempoFuturo.getMinutes();
      let novoSegundo = tempoFuturo.getSeconds();
      this.disabledBotoes = true

      // CONTADOR
      this.cronometro = setInterval(() => {
        this.tarefas[index].tempo_tarefa = novoMinuto + ':' + --novoSegundo
        if (novoMinuto < 1 && novoSegundo == 0) {
          axios.put(`http://127.0.0.1:8000/api/update/tarefa/${id}`, {
            status: this.mudancaStatus
          }).then(response => {
            let novasAtividadesAposIniciar = this.tarefas.filter(tarefa => tarefa.id != id)
            this.tarefas = novasAtividadesAposIniciar
          })
          this.disabledBotoes = false
          this.loading = false
          this.textoAlerta = 'Atividade concluída'
          this.display = true
          setTimeout(() => {
            this.display = false
          }, 2000);
          clearInterval(this.cronometro)
        }
        else if (novoMinuto >= 1 && novoSegundo == 0) {
          novoMinuto--
          novoSegundo = 60
        }
      }, 1000);
    },
    pararContagem(id) {
      this.mudancaStatus = 2
      const index = this.tarefas.findIndex((tarefa) => tarefa.id == id)
      clearInterval(this.cronometro)
      this.tempoFinal = this.tarefas[index].tempo_tarefa
      this.tarefas[index].loading = false


      let minutosTempoInicial = this.tempoInicial.substr(0, 2)
      let minutosTempoFinal = this.tempoInicial.substr(0, 2)
      minutosTempoInicial = parseInt(minutosTempoInicial)
      minutosTempoFinal = parseInt(minutosTempoFinal)
      let resultadoMinutosTotais = minutosTempoFinal - minutosTempoInicial

      let segundosTempoInicial = this.tempoInicial.substr(3, 5)
      let segundosTempoFinal = this.tempoFinal.substr(3, 5)
      let segundosTotais = segundosTempoInicial - segundosTempoFinal;
      let tempoTotalFinal = resultadoMinutosTotais + 'm e ' + segundosTotais + 's';

      console.log(tempoTotalFinal);
      axios.put(`http://127.0.0.1:8000/api/update/tarefa/${id}`, {
        status: this.mudancaStatus,
        tempo: tempoTotalFinal
      }).then(response => {
        let novasAtividadesAposIniciar = this.tarefas.filter(tarefa => tarefa.id != id)
        this.tarefas = novasAtividadesAposIniciar
      })

      let tempoTotal = new Date();
      tempoTotal.setMinutes()
    },
    async token () {
      await axios.get('http://127.0.0.1:8000/api/token').then(response => {
        this._token = response.data._token
      })
    }
  },
  computed: {

  }
})

</script> 