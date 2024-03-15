import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "https://task.truongnguyen869.click/api/v1";

const api = axios.create({
    baseURL: "https://task.truongnguyen869.click/api/v1",
    headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
});

export default api;
