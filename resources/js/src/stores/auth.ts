import { defineStore } from "pinia";
import axios from "../axios";
import router from "../router";
import { showMessage } from "../utils/toast";
import { useAppStore } from ".";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authenticated: !!localStorage.getItem("token"),
        user: {},
        token: "",
    }),
    getters: {
        getUser() {
            return this.user;
        },
    },
    actions: {
        setUserInfo(user: object) {
            this.user = user;
            localStorage.setItem("user", JSON.stringify(user));
        },
        
        setAuthenticated(authenticated: boolean) {
            this.authenticated = authenticated;
        },
        setToken(token: string) {
            return localStorage.setItem("token", token);
        },
        getToken() {
            return localStorage.getItem("token");
        },
        async login(payload: any) {
            try {
                const response = await axios.post("/login", payload);
                if (response.data.token) {
                    this.setToken(response.data.token);
                    this.token = response.data.token;
                    this.setAuthenticated(true);
                    this.setUserInfo(response.data.user);
                    showMessage("You have successfully logged in", "success");
                    router.push("/apps/scrumboard");
                }
            } catch (error) {
                showMessage("Invalid credentials", "error");
                console.log(error);
            }
        },
        async logout() {
            try {
                await axios.post("/logout");
                this.authenticated = false;
                this.user = {};
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                router.push({ name: "boxed-signin" });
            } catch (error) {
                console.log(error);
            }
        },
    },
});
