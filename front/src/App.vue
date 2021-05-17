<template>
  <div id="app">
    <div v-show="loading" class="bodyloader">
      <div class="loader">
        <br />
        <div class="text-center">Importings Graph ...</div>
      </div>
    </div>
    <div v-show="!loading">
      <GraphModal v-if="$store.state.showModal"></GraphModal>
      <b-row>
        <b-col cols="2"> <Navigation /></b-col>
        <b-col>
          <keep-alive><router-view /></keep-alive>
        </b-col>
      </b-row>
      <Sidebar v-if="$store.getters.current_graph !== null" />
    </div>
  </div>
</template>

<script>
import Navigation from "@/components/Navigation";
import Sidebar from "@/components/Sidebar";
import GraphModal from "@/components/GraphModal";
export default {
  data() {
    return {
      loading: true,
    };
  },
  components: {
    GraphModal,
    Sidebar,
    Navigation,
  },
  created: function () {
      this.$store.dispatch("GET_ALL_GRAPHS").then(() => {
      if (this.$store.getters.graphs.length > 0) {
        this.$store
          .dispatch("GET_GRAPH_STAT", this.$store.getters.graphs[0].id)
          .then(() => {
            this.loading = false;
          });
      }
    });
  },
};
</script>

<style>

html,body{
  overflow: hidden;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  box-sizing: border-box;
  overflow: hidden;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}

.loader {
  position: relative;
  width: 300px;
  min-height: 8px;
}

.bodyloader {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #1e1f26;
  width: 100vw;
  height: 100vh;
}

.loader::before {
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  width: 300px;
  min-height: 8px;
  background-color: rgba(11, 11, 11, 0.5);
}

.loader::after {
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  width: 30px;
  min-height: 8px;
  background-color: orange;
  animation: load 1s linear infinite;
}

@keyframes load {
  0% {
    left: 0;
    width: 0px;
  }
  50% {
    left: 150px;
    width: 150px;
  }
  100% {
    left: 300px;
    width: 0px;
  }
}


/*
 *  STYLE 10
 */

*::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #f5f5f5;
}

*::-webkit-scrollbar {
  width: 10px;
  background-color: #f5f5f5;
}

*::-webkit-scrollbar-thumb {
  background-color: #aaa;

  background-image: -webkit-linear-gradient(
    90deg,
    rgba(0, 0, 0, 0.2) 25%,
    transparent 25%,
    transparent 50%,
    rgba(0, 0, 0, 0.2) 50%,
    rgba(0, 0, 0, 0.2) 75%,
    transparent 75%,
    transparent
  );
}
</style>
