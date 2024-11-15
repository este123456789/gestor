<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TaskForm from '../Components/TaskForm.vue';
import axios from 'axios';

const tasks = ref([]);
const search = ref('');
const filter = ref(null);
const showForm = ref(false);
const paginationMeta = ref({}); // Para almacenar los metadatos de paginación (current_page, total_pages, etc.)

// Toggle task completion
const toggleCompletion = (task) => {
    axios.patch(`/api/tasks/${task.id}/toggle`)
        .then(() => {
            fetchTasks(); // Refrescar las tareas después de cambiar el estado
        })
        .catch((error) => {
            console.error('Error al cambiar el estado de la tarea:', error);
        });
};

// Delete a task
const deleteTask = (task) => {
    axios.delete(`/api/tasks/${task.id}`)
        .then(() => {
            fetchTasks(); // Refrescar la lista de tareas después de eliminar
        })
        .catch((error) => {
            console.error('Error al eliminar la tarea:', error);
        });
};

// Fetch tasks function
const fetchTasks = () => {
    const params = {
        search: search.value,
        completed: filter.value
    };

    axios.get('/api/tasks', { params })
        .then(response => {
            console.log(response.data);
            if (response.data) {
                tasks.value = response.data; // Lista de tareas
                paginationMeta.value = response.data.meta || {}; // Metadatos de la paginación
            } else {
                tasks.value = [];
                paginationMeta.value = {};
            }
        })
        .catch(error => {
            console.error("Error fetching tasks:", error);
        });
};

// Filter tasks by status
const filterTasks = (status) => {
    filter.value = status;
    fetchTasks();
};

// Initial fetch of tasks when mounted
onMounted(() => {
    fetchTasks();
});
</script>

<template>
    <Head title="All Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Tasks</h2>
        </template>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Task App Section -->
                        <div class="task-app">
                            <!-- Search Bar and Button to Add Task -->
                            <div class="flex items-center justify-between mb-4">
                                <input
                                    v-model="search"
                                    placeholder="Buscar tareas"
                                    class="px-4 py-2 border rounded"
                                    @input="fetchTasks"
                                />
                                <button
                                    @click="showForm = !showForm"
                                    class="px-4 py-2 bg-blue-500 text-white rounded"
                                >
                                    {{ showForm ? 'Cancelar' : 'Agregar tarea' }}
                                </button>
                            </div>

                            <!-- Task Form (Add Task) -->
                            <div v-if="showForm"> 
                                <TaskForm @task-added="fetchTasks" />
                            </div>

                            <!-- Filter Buttons -->
                            <div class="mb-4">
                                <button
                                    @click="filterTasks(null)"
                                    class="px-4 py-2 bg-gray-300 rounded mr-2"
                                >
                                    Todas
                                </button>
                                <button
                                    @click="filterTasks(true)"
                                    class="px-4 py-2 bg-green-300 rounded mr-2"
                                >
                                    Completadas
                                </button>
                                <button
                                    @click="filterTasks(false)"
                                    class="px-4 py-2 bg-red-300 rounded"
                                >
                                    No completadas
                                </button>
                            </div>

                            <!-- Display Tasks -->
                            <div v-for="task in tasks" :key="task.id" class="mb-4">
                                <div class="flex justify-between border-[1px] p-2">
                                    <h3>{{ task.title }}</h3>
                                    <p>{{ task.description }}</p>
                                    <p>Fecha de vencimiento: {{ task.due_date }}</p>
                                    <button @click="toggleCompletion(task)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        {{ task.completed ? 'Marcar como incompleta' : 'Marcar como completada' }}
                                    </button>
                                    <button @click="deleteTask(task)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Eliminar
                                    </button>
                                </div>
                            </div>

                            <!-- Paginate -->
                            <Pagination :meta="paginationMeta" @page-changed="fetchTasks" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
