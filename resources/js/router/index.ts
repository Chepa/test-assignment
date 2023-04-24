import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/:language",
        name: "Home",
        component: () => import("../pages/Home.vue"),
    },
    {
        path: "/:language/api",
        name: "Api",
        component: () => import("../pages/Api.vue"),
    }
];


const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
