<script setup>
import { ref, defineProps, onMounted } from "vue";
import http from "../plugins/axios";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";

const router = useRouter();
const toast = useToast();
const props = defineProps({
    id: {
        type: String,
    },
})

const original_url = ref("");
const id = ref("");
const name = ref("");

const udpateUrl = () => {
    if (name.value.trim() === "") {
        toast.warning("Please enter a valid name");
        return;
    } else if (original_url.value.trim() === "") {
        toast.warning("Please enter a valid URL");
        return;
    }

    http.post(
        "/api/edit",
        JSON.stringify({ id: id.value, original_url: original_url.value, name: name.value }),
        {
            headers: {
                "Content-Type": "application/json",
            },
        }
    ).then((res) => {
        toast.success("Url updated successfully")
    }).catch(err => {
        toast.error("Something went wrong");
        console.error(err);
    });
};
onMounted(() => {
    console.log(props.id);
    http.get(`api/geturl/${props.id}`).then((res) => {
        id.value = res.data.data.id;
        name.value = res.data.data.name;
        original_url.value = res.data.data.original_url;
    }).catch(err => {
        toast.error('Url not found, redirecting to dashboard');
        router.push({ name: 'dashboard' });
    });
})
</script>

<template>
    <div class="flex flex-col items-center">
        <h2 class="text-white text-center text-3xl font-bold my-10">Edit Url</h2>
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
                <div>
                    <input v-model="original_url" type="url" id="longUrl"
                        placeholder="https://example.com/very/long/url"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />

                </div>
            </div>
            <button @click="udpateUrl"
                class="bg-indigo-500 text-white py-2 px-5 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                Save
            </button>
        </div>
    </div>
</template>