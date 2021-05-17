import Vue from 'vue'
import Vuex from 'vuex'
import { Notyf } from 'notyf';
import { API } from '../api'
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    graphs: [],
    currentGraph: null,
    showModal: false,
    modalType: 'NEW' // NEW OR EDIT
  },
  mutations: {
    SET_GRAPH(state, graph) {
      if (!graph && state.graphs.length > 0) {
        state.currentGraph = state.graphs[0];
      } else if (graph) {
        state.currentGraph = graph
      }
    },
    UPDATED_DATA(state, graph) {
      let { name, description } = graph
      let index = state.graphs.findIndex(item => item.id == graph.id)

      state.graphs[index].name = name;
      state.graphs[index].description = description;

      state.currentGraph.name = name;
      state.currentGraph.description = description;
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
    async GET_ALL_GRAPHS({ state }) {
      return new Promise((resolve, reject) => {
        fetch(API.graph.all, { method: "GET" })
          .then((response) => response.json())
          .then((graphs) => {
            state.graphs = graphs.data;
            resolve(true);
          }).catch((error) => {
            new Notyf().error({ message: 'Please Check The API Endpoint !', dismissible: true, duration: 5000 * Math.exp(8) })
            reject(error)
          });
      })
    },

    DELETE_GRAPH({ getters, state }) {
      fetch(API.graph.delete.replace(':id', getters.current_graph.id), {
        method: 'DELETE', mode: 'cors'
      }).then((response) => response.json())
        .then((res) => {
          new Notyf().success(res.message)
          state.graphs.splice(state.graphs.findIndex((item) => item.id === getters.current_graph.id), 1)

          state.currentGraph = null;


        }).catch((error) => {
          new Notyf().error(error)
        })
    },

    async GET_GRAPH_STAT({ state }, id) {
      return new Promise((resolve, reject) => {
        fetch(API.graph.one_stat.replace(':id', id), {
          method: "GET",
        })
          .then((response) => response.json())
          .then((data) => {
            state.currentGraph = data.data;
            resolve(data.data)
          }).catch((error) => {
            reject(error)
          });
      })

    },

    UPDATE_GRAPH({ commit, getters }, data) {
      fetch(API.graph.update.replace(':id', getters.current_graph.id), {
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
      fetch(API.graph.create, {
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
    },

    ADD_NODE({ state, getters }, tooltip) {
      return new Promise((resolve, reject) => {
        fetch(API.node.create, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ graph_id: getters.current_graph.id, tooltip })
        }).then((response) => response.json()).then((res) => {
          res.data.relations = [];
          state.currentGraph.nodes.push(res.data)
          new Notyf().success(res.message)
          resolve(res.data)
        }).catch((error) => {
          reject(error)
        })
      })
    },

    UPDATE_NODE({ getters }, data) {
      getters.current_graph
      return new Promise((resolve, reject) => {
        fetch(API.node.update.replace(':id', data.id), {
          method: 'PUT',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ tooltip: data.title })
        }).then((response) => response.json())
          .then((res) => {
            new Notyf().success(res.message)
            resolve(true)
          }).catch((error) => {
            reject(error)
          })
      })
    },

    DELETE_NODE({ state, getters }, id) {
      getters.current_graph
      return new Promise((resolve, reject) => {
        fetch(API.node.delete.replace(':id', id), {
          method: 'DELETE',
        }).then((response) => response.json()).then((res) => {
          state.currentGraph.nodes.splice(state.currentGraph.nodes.findIndex(item => item.id == id), 1)
          new Notyf().success(res.message)
          resolve(true)
        }).catch((error) => {
          reject(error)
        })
      })

    },

    ADD_EDGE({ state, getters }, data) {
      getters.current_graph
      return new Promise((resolve, reject) => {
        fetch(API.node.create_edge, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ node_id: data.from, related_node_id: data.to })
        }).then((response) => response.json()).then((res) => {
          new Notyf().success(res.message)
          state.currentGraph.nodes.find(item => item.id === data.from).relations.push(res.data)
          resolve(res.data)
        }).catch((error) => {
          reject(error)
        })
      })
    },

    DELETE_EDGE({ state, getters }, id) {
      getters.current_graph
      return new Promise((resolve, reject) => {
        fetch(API.node.delete_edge.replace(':id', id), {
          method: 'DELETE',
        }).then((response) => response.json()).then((res) => {
          state.currentGraph.nodes.forEach(
            (item) => item.relations
              .splice(item.relations.findIndex(relation => relation.id == id), 1)
          )

          new Notyf().success(res.message)
          resolve(true)
        }).catch((error) => {
          reject(error)
        })
      })

    }


  },
  modules: {
  }
})
