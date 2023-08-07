<template>
  <div id="app" v-cloak class="lighttheme">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css"
    />
    <div id="nav" class="hover">
      <router-link to="/">VPS/DS Table</router-link>
      <router-link to="/tickettemplates">Tickets Templates</router-link>
    </div>
    <router-view />
    <Footer />
  </div>
</template>
<script>
import Footer from "./components/Main/Footer.vue";

export default {
  name: "App",
  components: {
    Footer,
  },
};
</script>
<style lang="scss">
@import "./assets/scss/global.scss";
@import "./assets/scss/light.scss";
</style>
<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}

</style>
<style>body,
html {
  margin: 0;
  padding: 0;
}</style>