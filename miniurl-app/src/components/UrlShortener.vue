<script setup>
import { ref, defineEmits } from "vue";
import http from "../plugins/axios";
import { useToast } from "vue-toastification";

const emit = defineEmits('updateList');
const toast = useToast();
const original_url = ref("");
const shortenedUrl = ref("");
const name = ref("");

const shortenUrl = () => {
  if (name.value.trim() === "") {
    toast.warning("Please enter a valid name");
    return;
  } else
    if (original_url.value.trim() === "") {
      toast.warning("Please enter a valid URL");
      return;
    }

  http.post(
    "/api/shorten",
    JSON.stringify({ original_url: original_url.value, name: name.value }),
    {
      headers: {
        "Content-Type": "application/json",
      },
    }
  ).then((res) => {
    toast.success("Url shortened successfully")
    shortenedUrl.value = res.data.url;
    emit('updateList');
  }).catch(err => {
    toast.error("Something went wrong");
    console.error(err);
  });
};
const copyUrl = () => {
  if (shortenedUrl.value.trim() === "") return;
  toast.info("Link copied!");
  navigator.clipboard.writeText(shortenedUrl.value);
};
</script>

<template>
  <div class="bg-white rounded-lg shadow-2xl p-5 w-full max-w-2xl">
    <div class="mb-4">
      <label for="urlName" class="block text-sm font-medium text-gray-700 mb-2">Name:</label>
      <div class="relative">
        <input v-model="name" type="text" id="urlName" name="urlName" placeholder="My socials"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
      </div>
    </div>

    <div class="mb-4">
      <label for="longUrl" class="block text-sm font-medium text-gray-700 mb-2">Enter your URL</label>
      <div class="relative">
        <input v-model="original_url" type="url" id="longUrl" placeholder="https://example.com/very/long/url"
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
        <button @click="shortenUrl"
          class="absolute right-0 top-0 bottom-0 bg-indigo-500 text-white px-6 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
          Shorten
        </button>
      </div>
    </div>

    <div>
      <label for="shortUrl" class="block text-sm font-medium text-gray-700 mb-2">Shortened URL</label>
      <div class="relative">
        <input :value="shortenedUrl" type="text" id="shortUrl" readonly
          placeholder="Your shortened URL will appear here"
          class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-indigo-500" />
        <button @click="copyUrl"
          class="absolute right-0 top-0 bottom-0 bg-fuchsia-500 text-white px-6 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
          Copy
        </button>
      </div>
    </div>
  </div>
</template>
