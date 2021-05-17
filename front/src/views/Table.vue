<template>
  <div id="table" >
    <b-table striped hover :items="items"></b-table>
  </div>
</template>

<script>
export default {
  name: "Table",
  computed: {
    items() {
      let tab = [];
      this.$store.getters.current_graph.nodes?.forEach((item) => {
        let node = { "Node ID": item.id, Tooltip: item.tooltip };
        let relations = [];
        item.relations?.forEach((relation) => {
          relations.push(relation.related_node_id);
        });
        node["Neighbors"] = relations;
        tab.push(node);
      });
      return tab;
    },
  },
};
</script>

<style>
#table {
  height: 100vh;
  overflow-y: scroll;
  margin-top: 89px !important;
}
</style>