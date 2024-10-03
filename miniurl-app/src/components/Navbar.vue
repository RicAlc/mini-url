<script setup>
import { RouterLink } from "vue-router";
const { showSignIn } = defineProps(["showSignIn"]);
</script>

<template>
  <header class="p-6">
    <nav class="flex justify-between items-center max-w-6xl mx-auto">
      <RouterLink to="/">
        <img
          class="shadow"
          width="250px"
          src="../assets/miniURL.svg"
          alt="miniURL"
        />
      </RouterLink>
      <div class="space-x-4" v-if="showSignIn">
        <RouterLink
          to="signin"
          class="bg-white text-fuchsia-600 px-4 py-2 rounded-full font-semibold hover:bg-fuchsia-100 transition-colors"
          >Sign In</RouterLink
        >
      </div>
    </nav>
  </header>
</template>
