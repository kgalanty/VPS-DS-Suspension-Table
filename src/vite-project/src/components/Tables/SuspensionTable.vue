<template>
  <article
    style="
      background: rgb(66 65 118);
      color: #c1bbe3;
      padding: 5px;
      border-radius: 5px;
    "
    class="container"
  >
    <span
      class="is-family-sans-serif"
      style="display: flex; flex: 1; margin: 10px 0; font-size: 20px"
    >
     Date of services displayed: <b-datepicker
        v-model="date"
        style=""
        placeholder="Type or select a date..."
        icon="calendar-today"
      >
      </b-datepicker>
    </span>
    <b-table
      :total="total"
      :data="services"
      paginated
      backend-pagination
      backend-sorting
      @page-change="onPageChange"
      :per-page="25"
      :loading="this.loading"
    >
      <template #empty style="text-align: center">
        <span v-if="loading === false">
          <p>No entries for given criteria. Try to loosen the filters.</p>
        </span>
        <b-message type="is-info" has-icon v-if="loading">
          Loading data...
        </b-message>
      </template>
      <b-table-column field="client" label="Name" v-slot="props" width="100">
        {{ props.row.client }}
      </b-table-column>
      <b-table-column
        field="hostname"
        label="Hostname"
        v-slot="props"
        width="100"
      >
        {{ props.row.hostname }}
      </b-table-column>
      <b-table-column
        field="link"
        label="Link to Product/Service"
        v-slot="props"
        width="100"
      >
        {{ props.row.link }}
      </b-table-column>
      <b-table-column
        field="suspension_ticket"
        label="Suspension Ticket"
        v-slot="props"
        width="100"
      >
        {{ props.row.link }}
      </b-table-column>
      <b-table-column
        field="suspension_status"
        label="Suspension Status"
        v-slot="props"
        width="100"
      >
        {{ props.row.link }}
      </b-table-column>
      <b-table-column
        field="termination"
        label="Date on which the service will be sent for termination"
        v-slot="props"
        width="150"
      >
        {{ props.row.termination }}
      </b-table-column>
    </b-table>
  </article>
</template>

<script>
import { defineComponent } from "vue";
import { mapState, mapActions } from "vuex";
export default defineComponent({
  name: "SuspensionTable",
  components: {},
  computed: {
    ...mapState("vpsds", ["services", "total", "date", "loading"]),
  },
  methods: {
    onPageChange(page) {},
    ...mapActions("vpsds", ["loadData"]),
  },
  mounted() {
    let date = new Date();
    date.setDate(date.getDate() - 1);
    this.$store.commit("vpsds/setDate", date);
    this.loadData();
  },
  data() {
    return {
      perPage: 25,
    };
  },
});
</script>
<style>
.is-empty {
  text-align: center;
}
.extrapointscolumn,
.cellcenter {
  display: block;
  text-align: center;
}
.centernoblock {
  text-align: center;
}
.emailTable {
  overflow-wrap: anywhere !important;
  word-wrap: anywhere !important;
  hyphens: auto !important;
}

#chatlisttable .table {
  border-collapse: collapse !important;
}
#chatlisttable .table td {
  border: 1px solid rgb(255, 255, 255);
  margin: 3px;
}
#chatlisttable th span {
  margin: 0 auto;
  text-align: center;
}
#chatlisttable th {
  border: 0;
}
.table {
  overflow: hidden;
}
.btable {
  font-size: 0.9rem;
  padding: -20px;
}
.btable th {
  background: white;
  font-size: 0.6rem;
  color: white !important;
  text-transform: uppercase;
  text-align: center !important;
}
</style>