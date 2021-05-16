import Vue from 'vue'
import Vuex from 'vuex'
import { Notyf } from 'notyf';



Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    graphs: [],
    currentGraph: null,
    showModal: false,
    modalType: 'NEW' // NEW OR EDIT
  },
  mutations: {
    UPDATE_GRAPH(state, graph) {
      state.currentGraph = graph
    },
    FILL_GRAPHS(state, graphs) {
      state.graphs = graphs
    },
    REMOVE_GRAPH(state, graph) {
      state.graphs.splice(state.graphs.indexOf(graph), 1)
      state.currentGraph = null;
    },
    UPDATED_DATA(state, graph) {
      let index = state.graphs.findIndex(item => item.id == graph.id)
      state.graphs[index] = graph;
      state.currentGraph = graph;
    },
    TOGGLE_MODAL(state, type) {
      state.showModal = !state.showModal;
      if (type) {
        state.modalType = type;
      }
    }
  },
  getters: {
    graphs(state) {
      return state.graphs;
    },
    current_graph(state) {
      return state.currentGraph ?? null;
    }
  },
  actions: {
    GET_ALL_GRAPHS({ commit }) {
      fetch(`${process.env.VUE_APP_API}/graphs`, { method: "GET" })
        .then((response) => response.json())
        .then((graphs) => {
          commit('FILL_GRAPHS', graphs.data);
        });
    },
    DELETE_GRAPH({ commit, getters }) {
      fetch(`${process.env.VUE_APP_API}/graph/${getters.current_graph.id}`, { method: 'DELETE', mode: 'cors' }).then((response) => response.json()).then((res) => {
        new Notyf().success(res.message)
        commit('REMOVE_GRAPH', getters.current_graph)
      })
    },
    UPDATE_GRAPH({ commit, getters }, data) {
      fetch(`${process.env.VUE_APP_API}/graph/${getters.current_graph.id}/edit`, {
        method: 'PUT',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      }).then((response) => response.json()).then((res) => {
        new Notyf().success(res.message)
        commit('UPDATED_DATA', res.data)
      })
    },
    CREATE_GRAPH({ dispatch }, data) {
      fetch(`${process.env.VUE_APP_API}/graph`, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      }).then((response) => response.json()).then((res) => {
        new Notyf().success(res.message)
        dispatch('GET_ALL_GRAPHS')
      })
    }
  },
  modules: {
  }
})
