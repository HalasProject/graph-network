<template>
  <div>
    <b-modal
      :visible="true"
      :title="title"
      :ok-title="modalType == 'EDIT' ? 'Save' : 'Create'"
      @show="resetModal"
      @hidden="hideModal"
      @ok="positifAction()"
    >
      <div>
        <b-form>
          <b-form-group
            id="input-group-1"
            label="Graph Name:"
            label-for="input-1"
          >
            <b-form-input
              id="input-1"
              v-model="graph.name"
              type="text"
              placeholder="Enter Name"
              required
            ></b-form-input>
          </b-form-group>
          <b-form-group
            id="textarea"
            label="Graph Description:"
            label-for="textarea"
          >
            <b-form-textarea
              id="textarea"
              v-model="graph.description"
              placeholder="Graph Description"
              rows="3"
              max-rows="6"
            ></b-form-textarea>
          </b-form-group>
        </b-form>
      </div>
    </b-modal>
  </div>
</template>


<script>
export default {
  data() {
    return {
      graph: {
        name: "",
        description: "",
      },
    };
  },
  computed: {
    title() {
      if (this.modalType == "EDIT") {
        return this.$store.getters.current_graph?.name;
      } else {
        return "Create new graph";
      }
    },
    modalType() {
      return this.$store.state.modalType;
    },
  },
  methods: {
    positifAction() {
      if (this.modalType == "EDIT") {
        this.$store.dispatch("UPDATE_GRAPH", this.graph);
      } else if (this.modalType == "NEW") {
        this.$store.dispatch("CREATE_GRAPH", this.graph);
      }
    },
    resetModal() {
      if (this.modalType == "EDIT") {
        this.graph.name = this.$store.getters.current_graph?.name;
        this.graph.description = this.$store.getters.current_graph?.description;
      }
    },
    hideModal() {
      this.$store.commit("TOGGLE_MODAL");
    },
  },
};
</script>
