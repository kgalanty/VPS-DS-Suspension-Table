<template>
<div>
  <TicketTplTable />
</div>
</template>
<style scoped>

</style>
<script>
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'
//import { mapActions, mapState } from "vuex";
import TicketTplTable from '../components/Tables/TicketTplTable.vue'

export default {
  name: "Tickets",
  components: { TicketTplTable },
  methods: {  },
  mounted() {
    
  },
  computed: {
   
  },
  data() {
    return {
    };
  },
};
</script>
