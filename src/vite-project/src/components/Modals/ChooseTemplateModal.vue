<template>
  <form action="">
    <div class="modal-card" style="width: 800px">
      <header class="modal-card-head">
        <p class="modal-card-title">Select Ticket Template</p>
        <button type="button" class="delete" @click="$emit('close')" />
      </header>
      <section class="modal-card-body">
        <b-message 
            title="Info with icon" 
            type="is-info" 
            has-icon 
            :closable="false"
            >
            Remember to switch checkbox of appropriate suspension/terminate status in the table behind after opening the ticket.
        </b-message>

        <ul>
          <li v-for="tpl in templates" :key="tpl.id">
            <b-radio
              v-model="templateSelected"
              name="name"
              :native-value="tpl.id"
              >{{ tpl.name }}</b-radio
            >
          </li>
        </ul>
      </section>
      <footer class="modal-card-foot">
        <b-button label="Close" @click="$emit('close')" />
        <b-button label="Open Ticket" :disabled="!templateSelected" type="is-primary" @click="OpenTicket"/>
      </footer>
    </div>
  </form>
</template>
    
<script>
import { mapActions, mapState } from "vuex";
import { defineComponent } from "vue";
export default defineComponent({
  name: "ChooseTemplateModal",
  props: {},
  computed: {
    ...mapState("ticketstpl", ["templates", "total", "loading"]),
  },
  methods: {
    ...mapActions("ticketstpl", ["loadData"]),
    OpenTicket()
    {
        window.location = 'supporttickets.php?action=open&userid='+this.$attrs.uid+'&modulefrom=vpsds&hid='+this.$attrs.hid+'&tplid='+this.templateSelected
    }
  },
  mounted() {
    this.loadData({ getall: 1 });
  },
  data() {
    return {
      templateSelected: null,
    };
  },
});
</script>
<style>
</style>