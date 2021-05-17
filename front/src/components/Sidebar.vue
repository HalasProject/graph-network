<template>
  <div>
    <div>
      <b-row id="toggle-btn" class="justify-content-md-center">
        <b-col align-self="baseline">
          <b-button @click="navigate()" variant="info">{{
            currentRoute
          }}</b-button></b-col
        >
        <b-col align-self="baseline">
          <b-button v-b-toggle.sidebar-right>About Graph ❓</b-button>
        </b-col>
      </b-row>

      <b-sidebar id="sidebar-right" title="Graph Info" right shadow>
        <div class="px-3 py-2">
          <b>Graph Name:</b>
          <p>
            {{ $store.getters.current_graph.name || "" }}
          </p>
          <b>Description:</b>
          <p>
            {{ $store.getters.current_graph.description || "" }}
          </p>
          <b>Date creation:</b>
          <p>
            {{ $store.getters.current_graph.created_at || "" }}
          </p>
          <b>Nodes:</b>
          <p>
            {{ getTotalNodes || 0 }}
          </p>
          <b>Relation:</b>
          <p>
            {{ getTotalRelation || 0 }}
          </p>
          <b-row class="mx-4">
            <b-col>
              <b-button
                variant="secondary"
                @click="$store.commit('TOGGLE_MODAL', 'EDIT')"
                >Edit</b-button
              ></b-col
            >
            <b-col>
              <b-button
                variant="danger"
                @click="$store.dispatch('DELETE_GRAPH')"
                >Delete</b-button
              ></b-col
            >
          </b-row>
        </div>
      </b-sidebar>
    </div>
  </div>
</template>

<script>
export default {
  name: "Sidebar",

  data() {
    return {
      modalShow: false,
    };
  },
  computed: {
    currentRoute() {
      return this.$route.name === "Table" ? "Graph 💹" : "Table 🗄";
    },
    current_graph_name() {
      return this.$store.getters.current_graph?.name;
    },
    getTotalNodes() {
      return this.$store.getters.current_graph.nodes?.length ?? 0;
    },
    getTotalRelation() {
      let a = this.$store.getters.current_graph?.nodes?.map(
        (item) => item.relations?.length
      );
      if (a) {
        return a.reduce((a, b) => a + b, 0);
      } else {
        return 0;
      }
    },
  },
  methods: {
    navigate() {
      if (this.$route.name === "Table") {
        this.$router.push({ name: "Graph" });
      } else {
        this.$router.push({ name: "Table" });
      }
    },
  },
};
</script>

<style scoped>
#toggle-btn {
  position: absolute;
  top: 20px;
  right: 40px;
  white-space: nowrap
}
#toggle-btn-2 {
  position: absolute;
  top: 20px;
  right: 15%;
}

#sidebar-right {
  background-color: #dddddd !important;
}
</style>
