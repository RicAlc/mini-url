<script setup>
import { onBeforeMount, ref } from "vue";
import SignUpForm from "../components/SignUpForm.vue";
import { RouterLink } from "vue-router";

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
      Create your account
    </h2>
    <SignUpForm class="mb-20" />
    <link to="/signin" />
    <RouterLink to="/password-reset">
      <span class="text-center text-sm text-white">Forgot your password?</span>
    </RouterLink>
  </div>
</template>
