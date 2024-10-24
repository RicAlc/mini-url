import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],
    proxy: {
        "/api": {
            target: "http://localhost:8000",
            secure: false,
            changeOrigin: true,
        },
    },
});
