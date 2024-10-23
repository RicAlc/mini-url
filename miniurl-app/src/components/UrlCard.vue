<script setup>
import { defineProps, defineEmits, inject } from "vue";
import { Trash2Icon, PenIcon, Copy, Router } from "lucide-vue-next";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";

const router = useRouter();
const http = inject("http")
const toast = useToast();
const emit = defineEmits('deleteFromList');
const props = defineProps({
  url: {
    type: Object,
    required: true,
  },
});

const { id, name, shortened_url, original_url, updated_at } = props.url;

const truncateUrl = (url) => {
  const maxLength = 45;
  return url.length > maxLength ? url.slice(0, maxLength) + '...' : url;
};

const copyUrl = (url) => {
  if (url.trim() === "") return;
  toast.info("Link copied!");
  navigator.clipboard.writeText(url);
};

const deleteUrl = (id) => {
  http.delete("api/deleteUrl", { params: { id } }
  ).then((res) => {
    toast.success('Url deleted successfully');
    emit('deleteFromList');
  }).catch(err => toast.error('Url could not be deleted'));
};

const editUrl = (id) => {
  router.push({ name: 'editurl', params: { id } });
}
</script>
<template>
  <div
    class="bg-white py-4 px-4 shadow sm:rounded-lg dark:bg-[#11162220] dark:backdrop-blur-sm dark:border-2 dark:[&>form>div>label]:text-white sm:mx-auto sm:w-full sm:max-w-2xl flex">
    <div class="flex flex-col w-full text-white">
      <h3 class="text-2xl font-bold mb-2">{{ name ?? 'Untitled' }}</h3>
      <a target="_blank" rel="noopener noreferrer" :href="original_url">{{
        truncateUrl(original_url)
        }}</a>
      <a class="text-fuchsia-500 hover:text-fuchsia-700" target="_blank" rel="noopener noreferrer"
        :href="shortened_url">{{ shortened_url }}</a>
      <p class="text-gray-500 text-sm mt-3">{{ updated_at }}</p>
    </div>
    <div class="flex items-start">
      <button title="Copy" class="bg-fuchsia-500 text-white mr-2 p-2 rounded-md" @click="copyUrl(shortened_url)">
        <Copy />
      </button>
      <button @click="editUrl(id)" title="Edit" class="bg-blue-500 text-white mr-2 p-2 rounded-md">
        <PenIcon />
      </button>
      <button @click="deleteUrl(id)" title="Delete" class="bg-red-500 mr-2 text-white p-2 rounded-md">
        <Trash2Icon />
      </button>
    </div>
  </div>
</template>