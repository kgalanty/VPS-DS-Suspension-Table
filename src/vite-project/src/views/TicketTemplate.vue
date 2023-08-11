<template>
  <div>  <h1 class="title">{{ pageTitle }}</h1>
    <section class="section">
      <h2 class="subtitle">
        <article class="media">
          <div class="media-content">
            <div class="field">
              <p class="control">
                <div class="tile is-ancestor">
  <div class="tile has-text-white is-4">
    Ticket template name
  </div>
  <div class="tile is-child ">
    <b-field :type="validation.name" message="This field must not be empty">
    <b-input type="text"
     required
     v-model="name" 
     expanded 
     ></b-input></b-field>
  </div>
</div>
              </p>
            </div>
          </div>
        </article>
        <article class="media">
         
          <div class="media-content">
            <div class="field">
              <p class="control">
                <div class="tile is-ancestor">
  <div class="tile has-text-white is-4">
    Ticket title
  </div>
  <div class="tile is-child ">
    <b-field :type="validation.title" message="This field must not be empty"><b-input type="text" v-model="title" expanded 
    required></b-input></b-field>
  </div>
</div>
              </p>
            </div>
          </div>
        </article>
        <article class="media">
          <div class="media-content">
            <div class="field">
              <p class="control">
                <div class="tile is-ancestor">
                  <div class="tile has-text-white is-4">
                    Ticket content
                  </div>
                  <div class="tile is-child ">
                    <b-field :type="validation.content" message="This field must not be empty">
                      <b-input required v-model="content" expanded type="textarea">
                      </b-input>
                    </b-field>
                  </div>
                </div>
              </p>
            </div>
            <nav class="level">
              <div class="level-left">
                  <div class="level-item">
                    <b-button type="is-primary" @click="back"> Back to list </b-button>
                  </div>
              </div>
              <div class="level-right">
                <div class="level-item">
                    <b-button type="is-primary" @click="submit">Save</b-button>
                </div>
              </div>
            </nav>
          </div>
        </article>
      </h2>
    </section>
  </div>
</template>
<style scoped>
.section {
  background-color: rgb(66 65 118);
  width: 90%;
  margin: 0 auto;
}
.media-left {
  color: white;
}
.is-expanded {
  width: 100%;
}
</style>
<script>
import { mapActions, mapState } from "vuex";
export default {
  name: "TicketTemplate",
  components: {},
  methods: {
    ...mapActions("ticketstpl", ["loadSingle"]),
    back()
    {
      this.$router.push("/tickettemplates")
    },
    showError(field) {
      if (this?.[field]?.length === 0) {
        this.validation[field] = "is-danger";
        this.error = true;
      } else {
        this.validation[field] = "";
      }
    },
    submit() {
      if(this.name.length === 0) { this.error = true; this.validation['name'] = "is-danger"; } else  this.validation['name'] = ''
      if(this.title.length === 0) { this.error = true; this.validation['title'] = "is-danger"; } else  this.validation['title'] = ''
      if(this.content.length === 0) { this.error = true; this.validation['content'] = "is-danger"; } else  this.validation['content'] = ''

     
      if (this.error) return;

      const payload = {
        title: this.title,
        name: this.name,
        content: this.content,
      };
      if (this.$route.params.tplid)
      {
        payload.id = this.$route.params.tplid
      }
        this.$store.dispatch("ticketstpl/save", payload).then(() => {
          this.$router.push("/tickettemplates");
        });
    },
  },
  mounted() {
    if (this.isEdit) {
      this.loadSingle(this.$route.params.tplid);
    } else {
      this.$store.commit("ticketstpl/setTemplate", {})
    }
  },
  computed: {
    isEdit()
    {
      return !!this.$route.params.tplid
    },
    pageTitle()
    {
      return this.isEdit ? 'Edit Ticket Template' : 'Add New Ticket Template'
    },

    template() {
      return this.$store.state.ticketstpl.template;
    },
    title: {
      get() {
        return this.$store.state.ticketstpl.template.title ?? '';
      },
      set(val) {
        this.$store.commit("ticketstpl/setTemplate", {
          ...this.template,
          title: val,
        });
      },
    },
    name: {
      get() {
        return this.$store.state.ticketstpl.template.name ?? '';
      },
      set(val) {
        this.$store.commit("ticketstpl/setTemplate", {
          ...this.template,
          name: val,
        });
      },
    },
    content: {
      get() {
        return this.$store.state.ticketstpl.template.content ?? '';
      },
      set(val) {
        this.$store.commit("ticketstpl/setTemplate", {
          ...this.template,
          content: val,
        });
      },
    },
  },
  data() {
    return {
      validation: {
        title: "",
        name: "",
        content: "",
      },
      error: false,
    };
  },
};
</script>
