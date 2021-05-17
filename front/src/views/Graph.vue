<template>
  <div>
    <Network v-show="current_graph" />
    <div id="no-item" v-if="!current_graph">Please select or create a new graph ! 😇</div>
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'
import Network from "@/components/Network";
export default {
  name: "Home",
  components: {
    Network,
  },
  computed: {
    current_graph() {
      return this.$store.getters.current_graph !== null ? true : false;
    }
  }
};
</script>

<style scoped>
#toggle-btn {
  position: absolute;
  top: 20px;
  right: 40px;
}
#no-item {
  height: 100vh;
  width: 100%;
  margin: 0 auto;
  font-size: xx-large;
  display: flex;
  justify-content: center;
  align-content: center;
  align-items: center;
}
#sidebar-right {
  background-color: #dddddd !important;
}
</style>
