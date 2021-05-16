<template>
  <div>
    <div style="border-right: 1px solid #dfdfdf">
      <b-list-group id="navigation">
        <b-list-group-item
          active
          style="border-radius: 0px !important"
          class="d-flex justify-content-center align-items-center"
        >
          All Graphs ({{ graphs.length }})
        </b-list-group-item>
        <b-list-group-item
          @click="$store.commit('TOGGLE_MODAL','NEW')"
          style="border-radius: 0px !important; cursor: pointer"
          class="d-flex bg-success text-white justify-content-center align-items-center"
        >
          Create new ✨
        </b-list-group-item>
        <b-list-group-item
          v-for="graph in graphs"
          :key="graph.id"
          class="d-flex graph-item justify-content-between align-items-center"
          :class="{ 'active-graph': current_graph_id == graph.id }"
          @click="$store.commit('UPDATE_GRAPH', graph)"
        >
          {{ graph.name }}
        </b-list-group-item>
      </b-list-group>
    </div>
  </div>
</template>

<script>
export default {
  name: "Navigation",

  data() {
    return {
      modalShow: false,
    };
  },
  computed: {
    graphs() {
      return this.$store.getters.graphs;
    },
    current_graph_id() {
      return this.$store.getters.current_graph?.id ?? null;
    },
  },
};
</script>

<style scoped lang="scss">
#navigation {
  overflow-y: auto;
  height: 100vh;
}
.list-group-item:first-child {
  border-top-left-radius: initial !important;
  border-top-right-radius: initial !important;
}
.graph-item {
  cursor: pointer;
  border-radius: 0px;
  &:hover {
    background-color: rgb(60 55 62);
    color: white;
  }
}

.active-graph {
  background-color: rgb(60 55 62);
  color: white;
}
</style>