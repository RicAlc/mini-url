<script setup>
import { ref, inject } from "vue";
import { useToast } from "vue-toastification";
import { MailIcon } from "lucide-vue-next";

const email = ref("");
const http = inject("http");
const toast = useToast();
const handleSubmit = () => {
  http
    .post("resetPassword", { params: { email: email.value } })
    .then((res) =>
      toast.success("An email has been sent to reset your password")
    )
    .catch((err) => toast.error("Something went wrong"));
};
</script>
<template>
  <h2 class="mb-6 text-center text-3xl font-extrabold text-white">
    Password reset
  </h2>
  <div
    class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 dark:bg-[#11162220] dark:backdrop-blur-sm dark:border-2 dark:[&>form>div>label]:text-white sm:mx-auto sm:w-full sm:max-w-md"
  >
    <form class="space-y-6" @submit.prevent="handleSubmit">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">
          Email address:
        </label>
        <div class="mt-1 relative rounded-md shadow-sm">
          <div
            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
          >
            <MailIcon class="h-5 w-5 text-gray-500" />
          </div>
          <input
            id="email"
            v-model="email"
            type="email"
            required
            class="pl-10 block w-full rounded-md dark:bg-[#11162220] dark:border-2 dark:border-blue-200 dark:text-white"
            placeholder="John Doe"
          />
        </div>
      </div>
    </form>
  </div>
</template>
