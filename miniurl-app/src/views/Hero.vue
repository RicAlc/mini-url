<script setup>
import { ref, onMounted } from "vue";
const animationStep = ref(0);

const animate = () => {
  animationStep.value = (animationStep.value + 1) % 3;
  setTimeout(animate, 1500);
};

onMounted(() => {
  animate();
});
</script>

<template>
  <div class="flex-grow flex items-center justify-center text-white p-6">
    <main class="text-center">
      <h1 class="text-5xl font-extrabold mb-4">
        Shorten Your URLs with miniURL
      </h1>
      <p class="text-xl mb-8 max-w-2xl">
        Create short, memorable links in seconds. Perfect for social media,
        marketing campaigns, and more!
      </p>

      <div
        class="bg-white rounded-lg shadow-2xl p-8 mb-12 w-full max-w-2xl mx-auto relative overflow-hidden"
      >
        <div class="flex items-center mb-4">
          <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
          <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
          <div class="w-3 h-3 rounded-full bg-green-500"></div>
        </div>
        <div class="relative h-16">
          <transition-group name="fade" mode="out-in">
            <div
              v-if="animationStep === 0"
              key="long-url"
              class="absolute inset-0 flex items-center"
            >
              <div
                class="w-full h-10 bg-gray-100 rounded-full flex items-center px-4 text-gray-600"
              >
                https://www.example.com/very-long-url-that-needs-shortening
              </div>
            </div>
            <div
              v-else-if="animationStep === 1"
              key="processing"
              class="absolute inset-0 flex items-center justify-center"
            >
              <div
                class="w-10 h-10 border-4 border-fuchsia-500 border-t-transparent rounded-full animate-spin"
              ></div>
            </div>
            <div
              v-else
              key="short-url"
              class="absolute inset-0 flex items-center"
            >
              <div
                class="w-full h-10 bg-fuchsia-100 rounded-full flex items-center px-4 text-fuchsia-600 font-semibold"
              >
                mini.url/shorturl
              </div>
            </div>
          </transition-group>
        </div>
      </div>

      <div class="flex justify-center space-x-6">
        <div class="text-center">
          <div class="text-4xl font-bold mb-2">10M+</div>
          <div class="text-fuchsia-200">Links Shortened</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold mb-2">5K+</div>
          <div class="text-fuchsia-200">Happy Users</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold mb-2">99.9%</div>
          <div class="text-fuchsia-200">Uptime</div>
        </div>
      </div>
    </main>

    <footer
      class="absolute bottom-0 left-0 right-0 p-6 text-center text-fuchsia-200"
    >
      © 2024 miniURL. All rights reserved.
    </footer>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
