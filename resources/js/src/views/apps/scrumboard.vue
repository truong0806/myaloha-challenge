<template>
    <div>
        <div>
            <button
                type="button"
                class="btn btn-primary flex"
                @click="addEditStatus()"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24px"
                    height="24px"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-5 h-5 ltr:mr-3 rtl:ml-3"
                >
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Status
            </button>
        </div>

        <!-- project list -->
        <div class="relative pt-5">
            <div class="h-full -mx-2">
                <div
                    class="overflow-x-auto flex items-start flex-nowrap gap-5 px-2 pb-2"
                >
                    <template v-for="status in statusList" :key="status.id">
                        <div class="panel w-80 flex-none">
                            <div class="flex justify-between mb-5">
                                <h4 class="text-base font-semibold">
                                    {{ status.title }}
                                </h4>

                                <div class="flex items-center">
                                    <button
                                        type="button"
                                        class="hover:text-primary ltr:mr-2 rtl:ml-2"
                                        @click="addEditTask(status.id)"
                                    >
                                        <svg
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5"
                                        >
                                            <circle
                                                opacity="0.5"
                                                cx="12"
                                                cy="12"
                                                r="10"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            />
                                            <path
                                                d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            />
                                        </svg>
                                    </button>
                                    <div class="dropdown">
                                        <Popper
                                            :placement="
                                                store.rtlClass === 'rtl'
                                                    ? 'bottom-start'
                                                    : 'bottom-end'
                                            "
                                            offsetDistance="0"
                                        >
                                            <button
                                                type="button"
                                                class="hover:text-primary"
                                            >
                                                <svg
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 opacity-70 hover:opacity-100"
                                                >
                                                    <circle
                                                        cx="5"
                                                        cy="12"
                                                        r="2"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    ></circle>
                                                    <circle
                                                        opacity="0.5"
                                                        cx="12"
                                                        cy="12"
                                                        r="2"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    ></circle>
                                                    <circle
                                                        cx="19"
                                                        cy="12"
                                                        r="2"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    ></circle>
                                                </svg>
                                            </button>
                                            <template #content="{ close }">
                                                <ul
                                                    @click="close()"
                                                    class="text-black dark:text-white-dark whitespace-nowrap"
                                                >
                                                    <li>
                                                        <a
                                                            href="javascript:;"
                                                            @click="
                                                                addEditStatus(
                                                                    status
                                                                )
                                                            "
                                                            >Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="javascript:;"
                                                            @click="
                                                                deleteStatus(
                                                                    status
                                                                )
                                                            "
                                                            >Delete
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="javascript:;"
                                                            @click="
                                                                clearProjects(
                                                                    status
                                                                )
                                                            "
                                                            >Clear All
                                                        </a>
                                                    </li>
                                                </ul>
                                            </template>
                                        </Popper>
                                    </div>
                                </div>
                            </div>

                            <!-- task list -->
                            <draggable
                                :data-status="status.id"
                                class="connect-sorting-content min-h-[150px]"
                                group="default"
                                ghost-class="sortable-ghost"
                                drag-class="sortable-drag"
                                :animation="200"
                                :list="status.tasks"
                                @end="handleDragEnd"
                            >
                                <div
                                    class="sortable-list"
                                    v-for="task in status.tasks"
                                    :key="task.deadline"
                                    :data-id="task.id"
                                >
                                    <div
                                        class="shadow bg-[#f4f4f4] dark:bg-white-dark/20 p-3 pb-5 rounded-md mb-5 space-y-3 cursor-move"
                                    >
                                        <template v-if="task.image">
                                            <img
                                                src="/assets/images/carousel1.jpeg"
                                                alt="images"
                                                class="h-32 w-full object-cover rounded-md"
                                            />
                                        </template>
                                        <div class="text-base font-medium">
                                            {{ task.title }}
                                        </div>
                                        <p class="break-all">
                                            {{ task.description }}
                                        </p>
                                        <div
                                            class="flex gap-2 items-center flex-wrap"
                                        ></div>
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <div
                                                class="font-medium flex items-center hover:text-primary"
                                            >
                                                <svg
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 ltr:mr-3 rtl:ml-3 shrink-0"
                                                >
                                                    <path
                                                        d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12Z"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    />
                                                    <path
                                                        opacity="0.5"
                                                        d="M7 4V2.5"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    />
                                                    <path
                                                        opacity="0.5"
                                                        d="M17 4V2.5"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    />
                                                    <path
                                                        opacity="0.5"
                                                        d="M2 9H22"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    />
                                                </svg>
                                                <span>{{
                                                    `${task.deadline}`
                                                }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <button
                                                    type="button"
                                                    class="hover:text-info"
                                                    @click="
                                                        addEditTask(
                                                            status.id,
                                                            task
                                                        )
                                                    "
                                                >
                                                    <svg
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="w-5 h-5 ltr:mr-3 rtl:ml-3"
                                                    >
                                                        <path
                                                            opacity="0.5"
                                                            d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                        />
                                                        <path
                                                            d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                        />
                                                        <path
                                                            opacity="0.5"
                                                            d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                        />
                                                    </svg>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="hover:text-danger"
                                                    @click="
                                                        deleteConfirmModal(
                                                            status.id,
                                                            task
                                                        )
                                                    "
                                                >
                                                    <svg
                                                        width="24"
                                                        height="24"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="w-5 h-5"
                                                    >
                                                        <path
                                                            opacity="0.5"
                                                            d="M9.17065 4C9.58249 2.83481 10.6937 2 11.9999 2C13.3062 2 14.4174 2.83481 14.8292 4"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                        ></path>
                                                        <path
                                                            d="M20.5001 6H3.5"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                        ></path>
                                                        <path
                                                            d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                        ></path>
                                                        <path
                                                            opacity="0.5"
                                                            d="M9.5 11L10 16"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                        ></path>
                                                        <path
                                                            opacity="0.5"
                                                            d="M14.5 11L14 16"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                        ></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </draggable>

                            <div class="pt-3">
                                <button
                                    type="button"
                                    class="btn btn-primary mx-auto"
                                    @click="addEditTask(status.id)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24px"
                                        height="24px"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-5 h-5"
                                    >
                                        <line
                                            x1="12"
                                            y1="5"
                                            x2="12"
                                            y2="19"
                                        ></line>
                                        <line
                                            x1="5"
                                            y1="12"
                                            x2="19"
                                            y2="12"
                                        ></line>
                                    </svg>
                                    Add Task
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- add project modal -->
        <TransitionRoot appear :show="isAddStatusModal" as="template">
            <Dialog
                as="div"
                @close="isAddStatusModal = false"
                class="relative z-[51]"
            >
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay class="fixed inset-0 bg-[black]/60" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center px-4 py-8"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg text-black dark:text-white-dark"
                            >
                                <button
                                    type="button"
                                    class="absolute top-4 ltr:right-4 rtl:left-4 text-gray-400 hover:text-gray-800 dark:hover:text-gray-600 outline-none"
                                    @click="isAddStatusModal = false"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24px"
                                        height="24px"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-6 h-6"
                                    >
                                        <line
                                            x1="18"
                                            y1="6"
                                            x2="6"
                                            y2="18"
                                        ></line>
                                        <line
                                            x1="6"
                                            y1="6"
                                            x2="18"
                                            y2="18"
                                        ></line>
                                    </svg>
                                </button>
                                <div
                                    class="text-lg font-medium bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]"
                                >
                                    {{
                                        params.id ? "Edit Status" : "Add Status"
                                    }}
                                </div>
                                <div class="p-5">
                                    <form @submit.prevent="saveStatus">
                                        <div class="grid gap-5">
                                            <div>
                                                <label for="title">Name</label>
                                                <input
                                                    id="title"
                                                    v-model="params.title"
                                                    type="text"
                                                    class="form-input mt-1"
                                                    placeholder="Enter Name"
                                                />
                                            </div>
                                        </div>

                                        <div
                                            class="flex justify-end items-center mt-8"
                                        >
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger"
                                                @click="
                                                    isAddStatusModal = false
                                                "
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                type="submit"
                                                class="btn btn-primary ltr:ml-4 rtl:mr-4"
                                            >
                                                {{
                                                    params.id ? "Update" : "Add"
                                                }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- add task modal -->
        <TransitionRoot appear :show="isAddTaskModal" as="template">
            <Dialog
                as="div"
                @close="isAddTaskModal = false"
                class="relative z-[51]"
            >
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay class="fixed inset-0 bg-[black]/60" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center px-4 py-8"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg text-black dark:text-white-dark"
                            >
                                <button
                                    type="button"
                                    class="absolute top-4 ltr:right-4 rtl:left-4 text-gray-400 hover:text-gray-800 dark:hover:text-gray-600 outline-none"
                                    @click="isAddTaskModal = false"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24px"
                                        height="24px"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-6 h-6"
                                    >
                                        <line
                                            x1="18"
                                            y1="6"
                                            x2="6"
                                            y2="18"
                                        ></line>
                                        <line
                                            x1="6"
                                            y1="6"
                                            x2="18"
                                            y2="18"
                                        ></line>
                                    </svg>
                                </button>
                                <div
                                    class="text-lg font-medium bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]"
                                >
                                    {{
                                        paramsTask.id ? "Edit Task" : "Add Task"
                                    }}
                                </div>
                                <div class="p-5">
                                    <form @submit.prevent="saveTask">
                                        <div class="grid gap-5">
                                            <div>
                                                <label for="taskTitle"
                                                    >Name</label
                                                >
                                                <input
                                                    id="taskTitle"
                                                    v-model="paramsTask.title"
                                                    type="text"
                                                    class="form-input"
                                                    placeholder="Enter Name"
                                                />
                                            </div>

                                            <div>
                                                <label for="taskdesc"
                                                    >Description</label
                                                >
                                                <textarea
                                                    id="taskdesc"
                                                    v-model="
                                                        paramsTask.description
                                                    "
                                                    class="form-textarea min-h-[130px]"
                                                    placeholder="Enter Description"
                                                ></textarea>
                                            </div>
                                            <div>
                                                <label for="taskdesc"
                                                    >Deadline</label
                                                >
                                                <VueDatePicker
                                                    :format="customDateFormat"
                                                    v-model="
                                                        paramsTask.deadline
                                                    "
                                                    placeholder="Start Typing ..."
                                                    text-input
                                                />
                                            </div>
                                        </div>

                                        <div
                                            class="flex justify-end items-center mt-8"
                                        >
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger"
                                                @click="isAddTaskModal = false"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                type="submit"
                                                class="btn btn-primary ltr:ml-4 rtl:mr-4"
                                            >
                                                {{
                                                    paramsTask.id
                                                        ? "Update"
                                                        : "Add"
                                                }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- delete task modal -->
        <TransitionRoot appear :show="isDeleteModal" as="template">
            <Dialog
                as="div"
                @close="isDeleteModal = false"
                class="relative z-[51]"
            >
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay class="fixed inset-0 bg-[black]/60" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center px-4 py-8"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg text-black dark:text-white-dark"
                            >
                                <button
                                    type="button"
                                    class="absolute top-4 ltr:right-4 rtl:left-4 text-gray-400 hover:text-gray-800 dark:hover:text-gray-600 outline-none"
                                    @click="isDeleteModal = false"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24px"
                                        height="24px"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-6 h-6"
                                    >
                                        <line
                                            x1="18"
                                            y1="6"
                                            x2="6"
                                            y2="18"
                                        ></line>
                                        <line
                                            x1="6"
                                            y1="6"
                                            x2="18"
                                            y2="18"
                                        ></line>
                                    </svg>
                                </button>
                                <div
                                    class="text-lg font-medium bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]"
                                >
                                    Delete Task
                                </div>
                                <div class="p-5 text-center">
                                    <div
                                        class="text-white bg-danger ring-4 ring-danger/30 p-4 rounded-full w-fit mx-auto"
                                    >
                                        <svg
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5"
                                        >
                                            <path
                                                opacity="0.5"
                                                d="M9.17065 4C9.58249 2.83481 10.6937 2 11.9999 2C13.3062 2 14.4174 2.83481 14.8292 4"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            ></path>
                                            <path
                                                d="M20.5001 6H3.5"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            ></path>
                                            <path
                                                d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            ></path>
                                            <path
                                                opacity="0.5"
                                                d="M9.5 11L10 16"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            ></path>
                                            <path
                                                opacity="0.5"
                                                d="M14.5 11L14 16"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            ></path>
                                        </svg>
                                    </div>
                                    <div
                                        class="text-base sm:w-3/4 mx-auto mt-5"
                                    >
                                        Are you sure you want to delete Task?
                                    </div>

                                    <div
                                        class="flex justify-center items-center mt-8"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            @click="isDeleteModal = false"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-primary ltr:ml-4 rtl:mr-4"
                                            @click="deleteTask()"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>
<script lang="ts" setup>
import { onMounted, ref, watch } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogOverlay,
} from "@headlessui/vue";
import { VueDraggableNext as draggable } from "vue-draggable-next";
import { useAppStore } from "../../stores/index";
import { useTaskStore } from "../../stores/task";
import { useAuthStore } from "../../stores/auth";
import { useMeta } from "../../composables/use-meta";
import { showMessage } from "../../utils/toast";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import axios from "axios";
useMeta({ title: "Scrumboard" });
const store = useAppStore();
const taskStore = useTaskStore();
const authStore = useAuthStore();
const user = ref(authStore.user);
const params = ref({
    id: null,
    title: "",
});
const paramsTask = ref({
    statusId: null,
    id: null,
    title: "",
    description: "",
    deadline: new Date(),
});
const selectedTask: any = ref(null);
const isAddStatusModal = ref(false);
const isAddTaskModal = ref(false);
const isDeleteModal = ref(false);
const statusList: any = ref([]);

const customDateFormat = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1; // Months are zero-based
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
};

onMounted(async () => {
    const data = await taskStore.getAllTasks();
    const sortTask = await data.map((status: any) => {
        status.tasks.sort((a: any, b: any) => {
            const dateA: any = new Date(
                a.deadline.split("-").reverse().join("-")
            );
            const dateB: any = new Date(
                b.deadline.split("-").reverse().join("-")
            );
            return dateA - dateB;
        });
        return status;
    });
    statusList.value = sortTask;
});
const addEditStatus = (status: any = null) => {
    setTimeout(() => {
        params.value = {
            id: null,
            title: "",
        };
        if (status) {
            params.value = JSON.parse(JSON.stringify(status));
        }

        isAddStatusModal.value = true;
    });
};
const fetchStatusList = async () => {
    const response = await axios.get("/tasks", {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    statusList.value = response.data;
};
const saveStatus = async () => {
    if (!params.value.title) {
        showMessage("Title is required.", "error");
        return false;
    }

    if (params.value.id) {
        await axios.patch(
            `/status/${params.value.id}`,
            {
                name: params.value.title,
            },
            {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            }
        );
        await fetchStatusList();
    } else {
        await axios
            .post(
                "/status",
                {
                    name: params.value.title,
                },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                }
            )
            .then((res) => {
                taskStore.setListTask(res.data);
                console.log(res);
            });
    }
    await fetchStatusList();
    showMessage("Status has been saved successfully.");
    isAddStatusModal.value = false;
};

const deleteStatus = async (status: any) => {
    await axios.delete(`/status/${status.id}`, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    await fetchStatusList();
    showMessage("Status has been deleted successfully.");
};

const clearProjects = (project: any) => {
    project.tasks = [];
};

// task
const addEditTask = (statusId: any, task: any = null) => {
    paramsTask.value = {
        statusId: null,
        id: null,
        title: "",
        description: "",
        deadline: new Date(),
    };
    if (task) {
        paramsTask.value = JSON.parse(JSON.stringify(task));
        const formatDate = new Date(
            paramsTask.value.deadline.toString().split("-").reverse().join("-")
        );
        paramsTask.value.deadline = formatDate;
    }
    paramsTask.value.statusId = statusId;
    isAddTaskModal.value = true;
};

const saveTask = async () => {
    if (!paramsTask.value.title) {
        showMessage("Title is required.", "error");
        return false;
    }

    if (paramsTask.value.id) {
        try {
            const dateObject = new Date(paramsTask.value.deadline);
            const day = dateObject.getUTCDate();
            const month = dateObject.getUTCMonth() + 1;
            const year = dateObject.getUTCFullYear();
            const formattedDate = `${day}-${month}-${year}`;
            await axios.patch(
                `/tasks/${paramsTask.value.id}`,
                {
                    title: paramsTask.value.title,
                    description: paramsTask.value.description,
                    deadline: formattedDate,
                    status: paramsTask.value.statusId,
                    created_by: localStorage.getItem("user")
                        ? JSON.parse(localStorage.getItem("user") || "").id
                        : "",
                },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                }
            );
            showMessage("Task has been saved successfully.");
            isAddTaskModal.value = false;
            await fetchStatusList();
        } catch (error) {
            showMessage(`${error.response.data.message}`, "error");
            console.error("Error updating task:", error);
        }
    } else {
        //add task
        let date = paramsTask.value.deadline;
        let day = date.getDate().toString().padStart(2, "0");
        let month = (date.getMonth() + 1).toString().padStart(2, "0");
        let year = date.getFullYear();

        let formattedDate = `${day}-${month}-${year}`;
        let userData = localStorage.getItem("user");
        const user = JSON.parse(userData || "");
        const created_by = user ? user.id : "";
        const task = {
            title: paramsTask.value.title,
            description: paramsTask.value.description,
            created_by,
            deadline: formattedDate,
            status: paramsTask.value.statusId,
        };
        await axios
            .post("/tasks", task, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            })
            .then((res) => {
                fetchStatusList();
            });
        showMessage("Task has been saved successfully.");
        isAddTaskModal.value = false;
    }
};

const deleteConfirmModal = (statusId: any, task: any = null) => {
    selectedTask.value = task;
    setTimeout(() => {
        isDeleteModal.value = true;
    }, 10);
};

const deleteTask = async () => {
    await axios.delete(`/tasks/${selectedTask.value.id}`, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    });
    await fetchStatusList();
    showMessage("Task has been deleted successfully.");
    isDeleteModal.value = false;
};

const handleDragEnd = async (event: any) => {
    let taskId = event.item.getAttribute("data-id");
    let newStatus = event.to.getAttribute("data-status");
    let oldStatus = event.from.getAttribute("data-status");
    if (oldStatus != newStatus) {
        await axios.patch(`/tasks/status/${taskId}`, {
            status: newStatus,
        });
    }
};
</script>
