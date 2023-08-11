<template>
  <div>  <h1 class="title">Add New Ticket Template</h1>
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
              <div class="level-left"></div>
              <div class="level-right">
                <div class="level-item">
                  <div class="level-item">
                    <b-button type="is-primary" @click="submit">Add</b-button>
                  </div>
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
  name: "EditTicketTemplate",
  components: {},
  methods: {
    ...mapActions("ticketstpl", ["loadSingle"]),
    showError(field) {
      console.log(this?.[field].length);
      if (this?.[field].length === 0) {
        this.validation[field] = "is-danger";
        this.error = true;
      } else {
        this.validation[field] = "";
      }
    },
    submit() {
      this.showError("name");

      this.showError("title");

      this.showError("content");
      if (this.error) return;

      const payload = {title: this.title, name: this.name, content: this.content}
      this.$store.dispatch('ticketstpl/save', payload)
      .then(()=>
        {
          this.$router.push('/tickettemplates')
        }
      )
    },
  },
  mounted() {
    this.loadSingle(this.$router.param.tplid)
  },
  computed: {},
  data() {
    return {
      validation: {
        title: "",
        name: "",
        content: "",
      },
      errorCounter: false,
      title: "",
      name: "",
      content: "",
    };
  },
};
</script>
