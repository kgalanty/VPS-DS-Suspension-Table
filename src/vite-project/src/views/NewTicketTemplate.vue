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
  <div class="tile">
    <b-input v-model="name" expanded></b-input>
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
  <div class="tile">
    <b-input v-model="title" expanded></b-input>
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
  <div class="tile">
    <b-input v-model="content" expanded type="textarea"></b-input>
  </div>
</div>
              </p>
            </div>
            <nav class="level">
              <div class="level-left"></div>
              <div class="level-right">
                <div class="level-item">
                  <div class="level-item">
                    <b-button type="is-primary">Add</b-button>
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
.is-expanded
{
  width:100%;
}
</style>
<script>
export default {
  name: "NewTicketTemplate",
  components: {},
  methods: {},
  mounted() {},
  computed: {},
  data() {
    return {
      title: "",
      name: "",
      content: "",
    };
  },
};
</script>
