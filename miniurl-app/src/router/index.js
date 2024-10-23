import { createRouter, createWebHistory } from "vue-router";
import Hero from "../views/Hero.vue";
import SignIn from "../views/SignIn.vue";
import SignUp from "../views/SignUp.vue";
import PasswordReset from "../views/PasswordReset.vue";
import Dashboard from "../views/Dashboard.vue";
import EditUrl from "../views/EditUrl.vue";

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
    {
      path: "/app",
      name: "app",
      children: [
        {
          path: "",
          name: "dashboard",
          component: Dashboard,
        },
        {
          path: "edit/:id",
          name: "editurl",
          component: EditUrl,
          props: true,
        },
      ],
    },
  ],
});

export default router;
