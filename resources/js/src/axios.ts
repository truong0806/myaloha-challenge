import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000/api/v1";

const api = axios.create({
    baseURL: "http://localhost:8000/api/v1",
    headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
});

export default api;
