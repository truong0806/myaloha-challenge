import { defineStore } from "pinia";
import axios from "../axios";

export const useTaskStore = defineStore("task", {
    state: () => ({
        taskList: {},
    }),
    getters: {
        getTask() {
            return this.task;
        },
    },
    actions: {
        setListTask(taskList: object) {
            this.taskList = taskList;
        },
        async getAllTasks() {
            try {
                const response = await axios.get("/tasks");
                this.setListTask(response.data);
                return response.data;
            } catch (error) {
                console.log(error);
            }
        },
    },
});
