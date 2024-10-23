<script setup>
import UrlCard from "./UrlCard.vue";
import { defineProps, defineEmits } from "vue";
const emit = defineEmits('updateList');

const props = defineProps({
  urlList: {
    type: Array,
    required: true,
  },
});
</script>
<template>
  <h2 class="text-white text-center text-3xl font-bold mt-10">Your URLs</h2>
  <UrlCard @deleteFromList="emit('updateList')" v-for="url in urlList" :key="url.id" :url="url" class="my-2" />
</template>