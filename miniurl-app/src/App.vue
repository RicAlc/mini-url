<script setup>
import { useRoute } from "vue-router";
import Navbar from "./components/Navbar.vue";

const route = useRoute();
</script>

<template>
  <Navbar :showSignIn="route.path === '/'" />
  <RouterView />
</template>
