<template>
  <article
    style="
      background: rgb(47, 14, 126);
      color: #c1bbe3;
      padding: 5px;
      border-radius: 5px;
    "
    class="container is-widescreen"
  >
    <div class="columns">
      <div
        class="column is-family-sans-serif"
        style="font-size: 20px; text-align: left; margin: 10px 0"
      >
        Handled services
      </div>
      <div class="column is-two-thirds">
        <b-input
          v-show="searchField"
          v-model="searchValue"
          placeholder="Search here"
          @input="doSearch"
          type="search"
          ref="searchField"
          icon="magnify"
        ></b-input>
      </div>
    </div>

    <b-table
      detailed
      :total="total"
      :data="services"
      paginated
      backend-pagination
      backend-sorting
      @page-change="onPageChange"
      :per-page="20"
      :loading="this.loading"
      :row-class="colorRows"
      @sort="onSort"
    >
      <template #detail="props">
        <div class="columns is-mobile is-vcentered">
          <div class="column is-narrow">
            <p class="bd-notification is-primary"><strong>Product</strong></p>
          </div>
          <div class="column is-narrow">
            <p class="bd-notification is-primary">
              {{ props.row.product_name }}
            </p>
          </div>
        </div>
        <div class="columns is-mobile is-vcentered">
          <div class="column is-narrow">
            <p class="bd-notification is-primary">
              <strong>Client since</strong>
            </p>
          </div>
          <div class="column is-narrow">
            <p class="bd-notification is-primary">
              {{ props.row.client_datecreated }}
            </p>
          </div>
        </div>
        <div class="columns is-mobile is-vcentered">
          <div class="column is-narrow">
            <p class="bd-notification is-primary"><strong>Color</strong></p>
          </div>
          <div class="column is-narrow">
            <p class="bd-notification is-primary">
              <b-select
                v-model="props.row.ticketsstatus.color"
                placeholder="Color"
                @input="
                  setTicketStatus(
                    props.row.id,
                    props.row.ticketsstatus.color,
                    'color'
                  )
                "
              >
                <option value="white">-White-</option>
                <option value="green">Green</option>
                <option value="yellow">Yellow</option>
                <option value="red">Red</option>
              </b-select>
            </p>
          </div>
        </div>
        <div class="columns is-mobile is-vcentered">
          <div class="column is-narrow">
            <p class="bd-notification is-primary"><strong>Delete</strong></p>
          </div>
          <div class="column is-narrow">
            <p class="bd-notification is-primary">
              <b-button
                type="is-danger"
                @click="setDeleted(props.row.id)"
                icon-right="delete"
              />
            </p>
          </div>
        </div>
      </template>
      <template #empty style="text-align: center">
        <span v-if="loading === false">
          <p>No services here.</p>
        </span>
        <b-message type="is-info" has-icon v-if="loading">
          Loading data...
        </b-message>
      </template>
      <b-table-column field="client" label="Name" v-slot="props" width="100">
        {{ props.row.client_firstname }} {{ props.row.client_lastname }}
      </b-table-column>
      <b-table-column
        field="hostname"
        label="Hostname"
        v-slot="props"
        width="100"
        centered
      >
        {{ props.row.domain }}
      </b-table-column>
      <b-table-column
        field="link"
        label="Link to Product/Service"
        v-slot="props"
        width="40"
        centered
        ><b-button type="is-primary" @click="openService(props.row.id)"
          >Open Service</b-button
        >
      </b-table-column>
      <b-table-column
        field="service_status"
        label="Service Status"
        v-slot="props"
        width="50"
        centered
      >
        <b-tooltip :label="props.row.domainstatus"
          ><DomainStatus :status="props.row.domainstatus"
        /></b-tooltip>
      </b-table-column>
      <b-table-column
        field="suspensionticketdate"
        label="Suspension Ticket"
        v-slot="props"
        width="50"
        centered
        sortable
      >
        {{ formatDateShort(props.row.ticketsstatus.suspensionticketdate) }}
      </b-table-column>
      <b-table-column
        field="suspension_status"
        label="Suspension Ticket Opened"
        v-slot="props"
        width="100"
        centered
      >
        <b-checkbox
          v-model="props.row.ticketsstatus.suspensionticket"
          true-value="1"
          false-value="0"
          @input="
            setTicketStatus(
              props.row.id,
              props.row.ticketsstatus.suspensionticket,
              'suspensionticket'
            )
          "
        />
      </b-table-column>
      <b-table-column
        field="terminationticketdate"
        label="Termination Ticket"
        v-slot="props"
        centered
        width="100"
        sortable
      >
        {{ formatDateShort(props.row.ticketsstatus.terminationticketdate) }}
      </b-table-column>
      <b-table-column
        field="termination_status"
        label="Termination Ticket Opened"
        v-slot="props"
        width="100"
        centered
      >
        <b-checkbox
          v-model="props.row.ticketsstatus.terminationticket"
          true-value="1"
          false-value="0"
          @input="
            setTicketStatus(
              props.row.id,
              props.row.ticketsstatus.terminationticket,
              'terminationticket'
            )
          "
        />
      </b-table-column>
      <b-table-column
        field="notes"
        label="Notes"
        v-slot="props"
        centered
        width="250"
      >
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
        <!-- <b-button type="is-primary" outlined icon-right="pencil" /> -->
      </b-table-column>
      <b-table-column label="Actions" v-slot="props" width="50">
        <b-button
          label="Open Ticket"
          type="is-primary"
          size="is-small"
          :aria-expanded="props.open"
          @click="openTicketModal(props.row.id, props.row.userid)"
        />
        <b-button
          label="Delete entry"
          type="is-primary"
          size="is-small"
          :aria-expanded="props.open"
          @click="markAsDeleted(props.row.id)"
        />
      </b-table-column>
    </b-table>
  </article>
</template>

<script>
import { defineComponent } from "vue";
import { mapState, mapActions } from "vuex";
import {
  addDays,
  currentDateTime,
  formatDateShort,
} from "../../helpers/formatDate.js";
import {
  showSuspensionTicketDate,
  showTerminationTicketDate,
  setTicketStatus,
  OnTablePageChange,
  OnTableSorting,
} from "../../helpers/tickets";
import DomainStatus from "../DomainStatus.vue";
import { openTicketModal } from "../../helpers/modals";

export default defineComponent({
  name: "HandledSuspensionTable",
  components: { DomainStatus },
  created() {},
  computed: {
    ...mapState("hvpsds", [
      "services",
      "total",
      "loading",
      "sorting_field",
      "sorting_order"
    ]),
    searchValue: {
      get() {
        return this.$store.state.hvpsds.search_value;
      },
      set(val) {
        this.$store.commit("hvpsds/setSearchValue", val);
      },
    },
  },

  methods: {
    ...mapActions("hvpsds", ["loadData", "setTicketStatus"]),
    setDeleted(serviceid) {
      this.setTicketStatus(serviceid, currentDateTime(), "deleted_at").then(
        () => {
          this.loadData();
        }
      );
    },
    colorRows(row) {
      return row.ticketsstatus ? "row-" + row.ticketsstatus.color : "row-white";
    },
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
      return setTicketStatus(serviceid, val, column);
    },
    onPageChange(page) {
      OnTablePageChange(page);
      this.loadData();
    },
    onSort(field, order) {
      OnTableSorting(field, order);
      this.loadData();
    },
    openService(id) {
      window.open("clientsservices.php?id=" + id, "_blank");
    },
    openTicketModal(hid, uid) {
      openTicketModal(hid, uid, this);
    },
    formatDateShort(date) {
      return formatDateShort(date);
    },
    handleSearchBar(e) {
      if (e.keyCode === 114 || (e.ctrlKey && e.keyCode === 70)) {
        e.preventDefault();
        this.searchField = !this.searchField;
        if(this.searchField === true)
        {
          this.$refs.searchField.focus();
        }
      }
    },
    doSearch()
    {
      clearTimeout(this.searchDelayTimer);
          this.searchDelayTimer = setTimeout(()=> {
            this.loadData();
          }, 1000); 
    }
  },

  mounted() {
    this.loadData();
    window.addEventListener("keydown", this.handleSearchBar);
  },
  data() {
    return {
      searchField: false,
      searchDelayTimer: null,
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
  margin: 0 auto;
}
</style>