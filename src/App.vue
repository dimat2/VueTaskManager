<template>
  <div id="app">
    <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </div>
    <router-view />
  </div>
</template>

<script>
  export default {
    name: "App",
    created() {
      this.$store.dispatch("getTasks")
    }
  }
</script>

<style>
  @import url('https://fonts.googleapis.com/css?family=Quicksand:500');
  @import url('./assets/foundation.css');
  @import url('./assets/foundation-icons.css');

  #app {
    font-family: 'Quicksand', sans-serif;
  }

  #nav {
    text-align: center;
    padding-top: 20px;
  }
  #nav a {
    color: #35495e;
    padding: 10px;
    font-size: 25px;
  }
</style>>
