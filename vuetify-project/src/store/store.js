import { createStore } from "vuex";


export default createStore({
    state: {
        usuarioLogado: []
    },
    mutations: {
        'INSERE_USUARIO_LOGADO'(state, payload){
            console.log(payload);
            state.usuarioLogado = payload
        }
    }
})