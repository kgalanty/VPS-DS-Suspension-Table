<template>
<span>
  <b-icon :icon="icon" size="is-small" :type="type"></b-icon>
</span>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
  name: "DomainStatus",
  props:
  {
    status: String
  },
  computed:
  {
    type()
    {
      if(this.status === 'Active')
      {
        return 'is-success'
      }
      else if(this.status == 'Suspended')
      {
        return 'is-warning'
      }
      else if(this.status == 'Terminated' || this.status == 'Cancelled')
      {
        return 'is-danger'
      }
    }
  },
  methods: {
    
  },
  mounted() {
  },
  data() {
    return {
        icon: 'circle',
    };
  },
});
</script>
<style>
</style>