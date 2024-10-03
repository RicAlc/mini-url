import { createRouter, createWebHistory } from "vue-router";
import Hero from "../views/Hero.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "hero",
            component: Hero,
        },
    ],
});

export default router;
