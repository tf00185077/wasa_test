import Vue from "vue";
import Router from "vue-router";
import CRUD from "@/components/CRUD";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "CRUD",
      component: CRUD
    }
  ]
});
