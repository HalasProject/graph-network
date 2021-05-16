<template>
  <div>
    <div id="mynetwork"></div>

    <div id="footer-network">
      <h2 id="eventSpanHeading"></h2>
      <pre id="eventSpanContent"></pre>
    </div>
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
    return {
      datax: {
        nodes: null,
        edges: null,
      },
      options: {
        interaction: { hover: true },
        manipulation: {
          enabled: true,
          addNode: function (data,callback) {
            // filling in the popup DOM elements
            callback()
            console.log("add", data);
          },
          editNode: function (data,callback) {
            callback();
            // filling in the popup DOM elements
            console.log("edit", data);
          },
          addEdge: function (data, callback) {
            console.log("add edge", data);
            if (data.from == data.to) {
              var r = confirm("Do you want to connect the node to itself?");
              if (r === true) {
                callback(data);
              }
            } else {
              callback(data);
            }
            // after each adding you will be back to addEdge mode
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
      fetch(`${process.env.VUE_APP_API}/graphs/${newValue.id}/statistics`, {
        method: "GET",
      })
        .then((response) => response.json())
        .then((data) => {
          let nodes = [];
          let edges = [];
          data.data.nodes.forEach((item) => {
            nodes.push({
              id: item.id,
              label: `${item.id}`,
              title: item.tooltip,
            });
            if (item.relations) {
              item.relations.forEach((edge) => {
                edges.push({ from: item.id, to: edge.id });
              });
            }
          });
          this.datax.nodes = new DataSet(nodes);
          this.datax.edges = new DataSet(edges);
          network.setData(this.datax);
        });
    },
    datax(newValue, oldValue) {
      console.log({ newValue: newValue, oldValue: oldValue });
    },
  },
  mounted: function () {
    var container = document.getElementById("mynetwork");
    network = new Network(container, this.datax, this.options);
    network.on("click", function (params) {
      params.event = "[original event]";
      document.getElementById("eventSpanHeading").innerText = "Click event:";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
      console.log(
        "click event, getNodeAt returns: " + this.getNodeAt(params.pointer.DOM)
      );
    });
    network.on("doubleClick", function (params) {
      params.event = "[original event]";
      document.getElementById("eventSpanHeading").innerText =
        "doubleClick event:";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
    });
    network.on("oncontext", function (params) {
      params.event = "[original event]";
      document.getElementById("eventSpanHeading").innerText =
        "oncontext (right click) event:";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
    });
    network.on("dragStart", function (params) {
      // There's no point in displaying this event on screen, it gets immediately overwritten
      params.event = "[original event]";
      console.log("dragStart Event:", params);
      console.log(
        "dragStart event, getNodeAt returns: " +
          this.getNodeAt(params.pointer.DOM)
      );
    });
    network.on("dragging", function (params) {
      params.event = "[original event]";
      document.getElementById("eventSpanHeading").innerText = "dragging event:";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
    });
    network.on("dragEnd", function (params) {
      params.event = "[original event]";
      document.getElementById("eventSpanHeading").innerText = "dragEnd event:";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
      console.log("dragEnd Event:", params);
      console.log(
        "dragEnd event, getNodeAt returns: " +
          this.getNodeAt(params.pointer.DOM)
      );
    });
    network.on("controlNodeDragging", function (params) {
      params.event = "[original event]";
      document.getElementById("eventSpanHeading").innerText =
        "control node dragging event:";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
    });
    network.on("controlNodeDragEnd", function (params) {
      params.event = "[original event]";
      document.getElementById("eventSpanHeading").innerText =
        "control node drag end event:";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
      console.log("controlNodeDragEnd Event:", params);
    });
    network.on("zoom", function (params) {
      document.getElementById("eventSpanHeading").innerText = "zoom event:";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
    });
    network.on("showPopup", function (params) {
      console.log(this.datax);
      document.getElementById("eventSpanHeading").innerText =
        "showPopup event: ";
      document.getElementById("eventSpanContent").innerText = JSON.stringify(
        params,
        null,
        4
      );
    });
    network.on("afterDrawing", (e) => {
      console.log("drawing", e);
    });
    network.on("hidePopup", function () {
      console.log("hidePopup Event");
    });
    network.on("select", function (params) {
      console.log("select Event:", params);
    });
    network.on("selectNode", function (params) {
      console.log("selectNode Event:", params);
    });
    network.on("selectEdge", function (params) {
      console.log("selectEdge Event:", params);
    });
    network.on("deselectNode", function (params) {
      console.log("deselectNode Event:", params);
    });
    network.on("deselectEdge", function (params) {
      console.log("deselectEdge Event:", params);
    });
    network.on("hoverNode", function (params) {
      console.log("hoverNode Event:", params);
    });
    network.on("hoverEdge", function (params) {
      console.log("hoverEdge Event:", params);
    });
    network.on("blurNode", function (params) {
      console.log("blurNode Event:", params);
    });
    network.on("blurEdge", function (params) {
      console.log("blurEdge Event:", params);
    });
  },
};
</script>

<style scoped>
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