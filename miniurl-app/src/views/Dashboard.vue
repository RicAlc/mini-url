<script setup>
import UrlShortener from "../components/UrlShortener.vue";
import UrlList from "../components/UrlList.vue";
import { ref, inject, onMounted } from "vue";
import { useToast } from "vue-toastification";

const toast = useToast();
const http = inject("http")
const urlPrefix = "http://localhost:8000/";
// const urlPrefix = "mnurl.vercel.app/";
const urlList = ref([]);

const getUrls = () => {
  http.get("api/myurls").then((res) => {
    urlList.value = res.data.data.map(elem => {
      elem.shortened_url = urlPrefix + elem.shortened_url;
      elem.updated_at = new Date(elem.updated_at).toLocaleString();
      return elem;
    });
  }).catch(err => toast.error('Error loading urls'));
};
onMounted(() => {
  getUrls();
});

</script>
<template>
  <div class="flex-grow flex flex-col items-center ">
    <RouterView />

    <UrlShortener @updateList="getUrls" class="mt-6" />
    <UrlList @updateList="getUrls" :urlList="urlList" class="mt-5" />
  </div>
</template>
