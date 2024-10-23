<script setup>
import { ref, inject } from "vue";
import { useToast } from "vue-toastification";
import { RouterLink } from "vue-router";
import { MailIcon, LockIcon } from "lucide-vue-next";

const email = ref("");
const password = ref("");
const http = inject("http");
const toast = useToast();

const handleSubmit = () => {
  http
    .post("/signin", {
      email: email.value,
      password: password.value,
    })
    .then((res) => {
      toast.success("Signed in successfully");
      sessionStorage.setItem('session', true);
      sessionStorage.setItem('userName', res.data.name);
      window.location.href = '/app';
    })
    .catch((err) => {
      toast.error("Invalid email or password");
      email.value = "";
      password.value = "";
      console.error(err)
    });
};
</script>

<template>
  <div
    class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 dark:bg-[#11162220] dark:backdrop-blur-sm dark:border-2 dark:[&>form>div>label]:text-white sm:mx-auto sm:w-full sm:max-w-md">
    <form class="space-y-6" @submit.prevent="handleSubmit">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">
          Email address
        </label>
        <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <MailIcon class="h-5 w-5 text-gray-400" />
          </div>
          <input id="email" v-model="email" type="email" required
            class="pl-10 block w-full rounded-md dark:bg-[#11162220] dark:border-2 dark:border-blue-200 dark:text-white"
            placeholder="you@example.com" />
        </div>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">
          Password
        </label>
        <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <LockIcon class="h-5 w-5 text-gray-400" />
          </div>
          <input id="password" v-model="password" type="password" required
            class="pl-10 block w-full rounded-md dark:bg-[#11162220] dark:border-2 dark:border-blue-200 dark:text-white"
            placeholder="••••••••" />
        </div>
      </div>

      <div>
        <button type="submit"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-fuchsia-600 hover:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500">
          Sign in
        </button>
      </div>
    </form>

    <div class="mt-6">
      <div class="relative">
        <div class="absolute inset-0 flex items-center">
          <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-2 bg-white text-gray-500 dark:bg-[#111622] dark:text-gray-200">
            Don't have an account?
          </span>
        </div>
      </div>

      <div class="mt-6 text-center">
        <RouterLink to="/signup" class="font-medium text-blue-600 hover:text-blue-500">
          Sign up here
        </RouterLink>
      </div>
    </div>
  </div>
</template>
