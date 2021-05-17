<template>
  <div>
    <Network />
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'
import Network from "@/components/Network";
export default {
  name: "Home",
  components: {
    Network
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
