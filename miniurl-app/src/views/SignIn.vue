<script setup>
import SignInForm from "../components/SignInForm.vue";
import { onBeforeMount, ref } from "vue";

const isLoggedIn = ref(false);
onBeforeMount(() => {
  isLoggedIn.value = sessionStorage.getItem('session') == 'true';
  if (isLoggedIn.value) {
    window.location.href = '/app';
  }
});
</script>
<template>
  <div class="flex-grow flex flex-col items-center justify-center">
    <h2 class="mb-6 text-center text-3xl font-extrabold text-white">
      Sign in to your account
    </h2>
    <SignInForm class="mb-20" />
  </div>
</template>
