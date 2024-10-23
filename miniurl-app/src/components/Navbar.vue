<script setup>
import { onBeforeMount, ref, inject } from "vue";
import { RouterLink } from "vue-router";
import { useToast } from "vue-toastification";

const { showSignIn } = defineProps(["showSignIn"]);
const toast = useToast();
const isLoggedIn = ref(false);
const userName = ref("Guest");
const http = inject("http")

const logout = () => {
  http.post("/logout").then((res) => {
    isLoggedIn.value = false;
    userName.value = "Guest";
    toast.info("Logged out successfully, redirecting...");
    sessionStorage.removeItem('session');
    sessionStorage.removeItem('userName');
    window.location.href = '/';
  }).catch(err => {
    toast.error("Error logging out");
    console.error(err);
  });
}

onBeforeMount(() => {
  isLoggedIn.value = sessionStorage.getItem('session') == 'true';
  if (isLoggedIn.value) {
    userName.value = sessionStorage.getItem('userName');
  }
});
</script>

<template>
  <header class="p-4">
    <nav class="flex justify-between items-center max-w-6xl mx-auto">
      <RouterLink :to="isLoggedIn ? '/app' : '/'">
        <img class="shadow" width="250px" src="../assets/miniURL.svg" alt="miniURL" />
      </RouterLink>
      <div class="space-x-4" v-if="isLoggedIn">
        <div class="flex items-center">
          <p class="text-white mr-2 underline">{{ userName }}</p>
          <button v-if="!isLoggedIn" @click="window.location.href = '/signin'" type="button"
            class="bg-white text-fuchsia-600 px-2 py-1 rounded-full font-semibold hover:bg-fuchsia-100 transition-colors">Sign
            in</button>
          <button v-else @click="logout" type="button"
            class="bg-white text-fuchsia-600 px-2 py-1 rounded-full font-semibold hover:bg-fuchsia-100 transition-colors">
            Sign out</button>
        </div>

      </div>
      <RouterLink v-else to="signin"
        class="bg-white text-fuchsia-600 px-4 py-2 rounded-full font-semibold hover:bg-fuchsia-100 transition-colors">
        Sign In</RouterLink>
    </nav>
  </header>
</template>
