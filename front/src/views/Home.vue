<template>
  <div>
    <GraphModal v-if="$store.state.showModal"></GraphModal>
    <b-row>
      <b-col cols="2"> <Navigation /></b-col>
      <b-col> <Network /></b-col>
    </b-row>
    <Sidebar v-if="$store.getters.current_graph !== null" />
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'
import Network from "@/components/Network";
import Navigation from "@/components/Navigation";
import Sidebar from "@/components/Sidebar";
import GraphModal from "@/components/GraphModal";
export default {
  name: "Home",
  components: {
    GraphModal,
    Sidebar,
    Navigation,
    Network,
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
