<template>
  <article
    style="
      background: rgb(66 65 118);
      color: #c1bbe3;
      padding: 5px;
      border-radius: 5px;
    "
    class="container is-widescreen"
  >
    <span
      class="is-family-sans-serif"
      style="display: flex; flex: 1; margin: 10px 0; font-size: 20px"
    >
      Templates for tickets&nbsp;<b-button type="is-primary" outlined inverted @click="$router.push('/tickettemplates/new')">Add New</b-button>
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
          <p class="empty">No entries for given criteria. Try to loosen the filters.</p>
        </span>
        <b-message type="is-info" has-icon v-if="loading">
          Loading data...
        </b-message>
      </template>
      <b-table-column field="name" label="Name" v-slot="props" >
        {{ props.row.name }} 
      </b-table-column>
      <b-table-column
        field="actions"
        label="Actions"
        v-slot="props"
        width="100" centered
      >
        {{ props.row.domain }}
      </b-table-column>
      <b-table-column field="notes" label="Notes" v-slot="props" width="250" centered>
        <b-input
          v-model="props.row.ticketsstatus.notes"
          @input="
            setTicketStatus(
              props.row.id,
              props.row.ticketsstatus.notes,
              'notes'
            )
          "
          :value="props.row.ticketsstatus.notes"
          size="is-small"
          type="textarea"
        ></b-input>
      </b-table-column>
    </b-table>
  </article>
</template>

<script>
import { defineComponent } from "vue";
import { mapState, mapActions } from "vuex";
import { addDays } from "../../helpers/formatDate.js";
import {
  showSuspensionTicketDate,
  showTerminationTicketDate,
  setTicketStatus,
  OnTablePageChange,
} from "../../helpers/tickets";

export default defineComponent({
  name: "TicketTplTable",
  components: {  },
  created() {},
  computed: {
    ...mapState("vpsds", ["services", "total", "loading"]),
    date: {
      get() {
        return this.$store.state.vpsds.date;
      },
      set(val) {
        this.$store.commit("vpsds/setDate", val);
      },
    },
  },
  // watch:
  // {
  //   date()
  //   {
  //     this.loadData()
  //   }
  // },
  methods: {
    ...mapActions("vpsds", ["loadData"]),

    addDays(date, days) {
      return addDays(date, days);
    },
    showSuspensionTicketDate(nextduedate, clientcreated, isvpsds) {
      return showSuspensionTicketDate(nextduedate, clientcreated, isvpsds);
    },
    showTerminationTicketDate(nextduedate, clientcreated, isvpsds) {
      return showTerminationTicketDate(nextduedate, clientcreated, isvpsds);
    },
    setTicketStatus(serviceid, val, column) {
      setTicketStatus(serviceid, val, column);
    },
    onPageChange(page) {
      OnTablePageChange(page);
      this.loadData();
    },
    openService(id) {
      window.open(
        "https://my.tmdhosting.com/admin/clientsservices.php?id=" + id,
        "_blank"
      );
    },
    initDate() {
      let date = new Date();
      date.setDate(date.getDate() - 1);
      this.$store.commit("vpsds/setDate", date);
    },
  },
  mounted() {
    this.initDate();
    this.loadData();
  },
  data() {
    return {
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