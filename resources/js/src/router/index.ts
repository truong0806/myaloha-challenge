import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import { useAppStore } from "../stores/index";
import { useAuthStore } from "../stores/auth";
import appSetting from "../app-setting";

import HomeView from "../views/index.vue";

const routes: RouteRecordRaw[] = [
    // dashboard
    {
        path: "/",
        name: "home",
        component: HomeView,
        meta: { requiresAuth: true },
    },
    // authentication
    {
        path: "/auth/signin",
        name: "signin",
        component: () =>
            import(
                /* webpackChunkName: "auth-boxed-signin" */ "../views/auth/boxed-signin.vue"
            ),
        meta: { layout: "auth" },
    },
    {
        path: "/auth/signup",
        name: "signup",
        component: () =>
            import(
                /* webpackChunkName: "auth-boxed-signup" */ "../views/auth/boxed-signup.vue"
            ),
        meta: { layout: "auth" },
    },
    {
        path: "/apps/scrumboard",
        name: "scrumboard",
        component: () =>
            import(
                /* webpackChunkName: "apps-scrumboard" */ "../views/apps/scrumboard.vue"
            ),
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const store = useAppStore();
    const auth = useAuthStore();

    const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);

    console.log(
        "🚀 ~ router.beforeEach ~ auth.authenticated:",
        auth.authenticated
    );
    if (requiresAuth && !auth.authenticated) {
        next({ name: "signin" }); // Redirect to login
    } else {
        next(); // Proceed
    }
    if (to?.meta?.layout == "auth") {
        store.setMainLayout("auth");
    } else {
        store.setMainLayout("app");
    }
    next(true);
});
router.afterEach((to, from, next) => {
    appSetting.changeAnimation();
});
export default router;
