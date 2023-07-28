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
  {},
  methods: {
    calculateStatus()
    {
      this.icon = 'circle'
      if(this.status === 'Active')
      {
        this.type = 'is-success'
      }
      else if(this.status == 'Suspended')
      {
        this.type = 'is-warning'
      }
      else if(this.status == 'Terminated' || this.status == 'Cancelled')
      {
        this.type = 'is-danger'
      }
    }
  },
  mounted() {
    this.calculateStatus();
  },
  data() {
    return {
        icon: '',
        type: '',
    };
  },
});
</script>
<style>
</style>