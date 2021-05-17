<template>
  <div>
    <div id="mynetwork"></div>
  </div>
</template>

<script>
import "vis-network/styles/vis-network.min.css";
import { Network } from "vis-network";
import { DataSet } from "vis-data/peer/esm/vis-data";

let network;
export default {
  name: "Network",
  data() {
    var self = this;
    return {
      netdata: {
        nodes: null,
        edges: null,
      },
      options: {
        interaction: { hover: true, multiselect: false },
        manipulation: {
          enabled: true,
          addNode: function (data, callback) {
            let tooltip = prompt("Please enter a tooltip for current Node");
            if (tooltip) {
              self.$store.dispatch("ADD_NODE", tooltip).then((data) => {
                callback({
                  id: data.id,
                  label: `${data.id}`,
                  title: data.tooltip,
                });
              });
            }
          },
          deleteNode: function (data, callback) {
            console.log(data);
            self.$store.dispatch("DELETE_NODE", data.nodes[0]).then(() => {
              callback(data);
            });
          },
          editNode: function (data, callback) {
            let newprompt = prompt("Update tooltip:", data.title);
            if (newprompt !== null) {
              data.title = `${newprompt.toString()}`;
              self.$store.dispatch("UPDATE_NODE", data).then(() => {
                callback(data);
              });
            }
          },
          deleteEdge: function (data, callback) {
            console.log(data);
            self.$store.dispatch("DELETE_EDGE", data.edges[0]).then(() => {
              callback(data);
            });
          },
          addEdge: function (data, callback) {
            if (data.from == data.to) {
              return;
            }

            self.$store.dispatch("ADD_EDGE", data).then((res) => {
              callback({
                from: res.node_id,
                to: res.related_node_id,
                id: res.id,
              });
            });
            network.addEdgeMode();
          },
        },
      },
    };
  },
  computed: {
    current_graph() {
      return this.$store.getters.current_graph;
    },
  },
  watch: {
    current_graph(newValue) {
      if (newValue !== null) {
        this.update_data(newValue);
      }
    },
    netdata(newValue, oldValue) {
      console.log({ newValue: newValue, oldValue: oldValue });
    },
  },
  methods: {
    update_data(newValue) {
      let nodes = [];
      let edges = [];

      newValue?.nodes?.forEach((item) => {
        nodes.push({
          id: item.id,
          label: `${item.id}`,
          title: item.tooltip,
        });
        if (item.relations) {
          item.relations.forEach((edge) => {
            edges.push({
              id: edge.id,
              from: item.id,
              to: edge.related_node_id,
            });
          });
        }
      });
      this.netdata.nodes = new DataSet(nodes);
      this.netdata.edges = new DataSet(edges);
      network.setData(this.netdata);
    },
  },
  mounted: function () {
    var container = document.getElementById("mynetwork");
    network = new Network(container, this.netdata, this.options);
    // this.update_data(this.current_graph);
  },
};
</script>

<style>
div.vis-network button.vis-close {
  top: 1% !important;
  left: 50% !important;
  right: 0px !important;
}

#mynetwork {
  height: 100vh;
  padding: 24px;
  position: relative;
  cursor: grab;
}

#footer-network {
  position: absolute;
  bottom: 0;
  left: 0;
}
</style>