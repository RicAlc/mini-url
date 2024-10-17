import { createRouter, createWebHistory } from "vue-router";
import Hero from "../views/Hero.vue";
import SignIn from "../views/SignIn.vue";
import SignUp from "../views/SignUp.vue";
import PasswordReset from "../views/PasswordReset.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "hero",
      component: Hero,
    },
    {
      path: "/signin",
      name: "signin",
      component: SignIn,
    },
    {
      path: "/signup",
      name: "signup",
      component: SignUp,
    },
    {
      path: "/password-reset",
      name: "passwordReset",
      component: PasswordReset,
    },
  ],
});

export default router;
