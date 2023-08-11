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
      Templates for tickets&nbsp;<b-button
        type="is-primary"
        outlined
        inverted
        @click="$router.push('/tickettemplates/new')"
        >Add New</b-button
      >
    </span>
    <b-table
      :total="total"
      :data="templates"
      paginated
      backend-pagination
      backend-sorting
      @page-change="onPageChange"
      :per-page="25"
      :loading="this.loading"
    >
      <template #empty style="text-align: center">
        <span v-if="loading === false">
          <p class="empty">
            No entries for given criteria. Try to loosen the filters.
          </p>
        </span>
        <b-message type="is-info" has-icon v-if="loading">
          Loading data...
        </b-message>
      </template>
      <b-table-column field="name" label="Name" v-slot="props">
        {{ props.row.name }}
      </b-table-column>
      <b-table-column field="title" label="Ticket Title" v-slot="props">
        {{ props.row.title }}
      </b-table-column>
      <b-table-column
        field="actions"
        label="Actions"
        width="300"
        v-slot="props"
        centered
      >
        <div class="buttons" style="margin: 0 auto; text-align: center">
          <b-button
            type="is-standard"
            icon-left="pencil"
            @click="editTemplate(props.row.id)"
            >Edit
          </b-button>
          <b-button
            type="is-danger"
            icon-left="delete"
            @click="deleteTemplate(props.row.id)"
            >Delete</b-button
          >
        </div>
      </b-table-column>
    </b-table>
  </article>
</template>

<script>
import { defineComponent } from "vue";
import { mapState, mapActions } from "vuex";
import { OnTablePageChange } from "../../helpers/tickets";

export default defineComponent({
  name: "TicketTplTable",
  components: {},
  created() {},
  computed: {
    ...mapState("ticketstpl", ["templates", "total", "loading"]),
  },
  // watch:
  // {
  //   date()
  //   {
  //     this.loadData()
  //   }
  // },
  methods: {
    ...mapActions("ticketstpl", ["loadData", "delete"]),
    editTemplate(id) {
      this.$router.push(`/tickettemplates/edit/${id}`);
    },
    deleteTemplate(id) {
      this.$buefy.dialog.confirm({
        message: "Are you sure you wish to delete this template?",
        onConfirm: () => {
          this.delete(id).then((result) => {
            if (result === 1) {
              this.$buefy.toast.open({
                message: "Deleted successfuly",
                type: "is-success",
              });
            } else if (result.error) {
              this.$buefy.toast.open({
                message: result.error,
                type: "is-danger",
              });
            }
          });
        },
      });
    },
    onPageChange(page) {
      OnTablePageChange(page);
      this.loadData();
    },
  },
  mounted() {
    this.loadData();
  },
  data() {
    return {};
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