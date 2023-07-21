<template>
<div><SuspensionTable />
</div>
</template>
<style scoped>

</style>
<script>
// @ is an alias to /src
//import HelloWorld from '@/components/HelloWorld.vue'
//import { mapActions, mapState } from "vuex";
import SuspensionTable from '../components/Tables/SuspensionTable.vue'
export default {
  name: "Home",
  components: { SuspensionTable },
  methods: {  },
  mounted() {
    
  },
  computed: {
   
  },
  data() {
    return {
      // perPage: 25,
      // datetimeFromFilter: null,
      // datetimeToFilter: null,
      // total: 5,
    };
  },
};
</script>
