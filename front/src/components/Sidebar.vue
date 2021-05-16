<template>
  <div>
    <div>
      <b-button id="toggle-btn" v-b-toggle.sidebar-right
        >About Graph 📃</b-button
      >
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
          <b-row class="mx-4">
            <b-col>
              <b-button
                variant="secondary"
                @click="$store.commit('TOGGLE_MODAL','EDIT')"
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
    current_graph_name() {
      return this.$store.getters.current_graph?.name;
    },
  },
};
</script>

<style scoped>
#toggle-btn {
  position: absolute;
  top: 20px;
  right: 40px;
}

#sidebar-right {
  background-color: #dddddd !important;
}
</style>
