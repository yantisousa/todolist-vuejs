import { createStore } from "vuex";


export default createStore({
    state: {
        usuarioLogado: []
    },
    mutations: {
        'INSERE_USUARIO_LOGADO'(state, payload){
            state.usuarioLogado = payload
        },
        'REMOVE_USUARIO_LOGADO'(state){
            state.usuarioLogado = []
        }
    }
})