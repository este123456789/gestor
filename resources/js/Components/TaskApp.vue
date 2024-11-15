<template>
    <div class="task-app">
        <div>
            <input v-model="search" placeholder="Buscar tareas" @input="fetchTasks" />
            <button @click="showForm = !showForm">Agregar tarea</button>
        </div>

        <div v-if="showForm">
            <task-form @task-added="fetchTasks" />
        </div>

        <div>
            <button @click="filterTasks(null)">Todas</button>
            <button @click="filterTasks(true)">Completadas</button>
            <button @click="filterTasks(false)">No completadas</button>
        </div>

        <div v-for="task in tasks.data" :key="task.id">
            <task-item :task="task" @task-updated="fetchTasks" @task-deleted="fetchTasks" />
        </div>

        <pagination :meta="tasks.meta" @page-changed="fetchTasks" />
    </div>
</template>

<script>
import TaskForm from './TaskForm.vue';
import TaskItem from './TaskItem.vue';
import Pagination from './Pagination.vue';

export default {
    components: {
        TaskForm, TaskItem, Pagination
    },
    data() {
        return {
            tasks: [],
            search: '',
            filter: null,
            showForm: false
        };
    },
    methods: {
        fetchTasks() { 
            const params = {
                search: this.search,
                completed: this.filter
            };

            axios.get('/api/tasks', { params })
                .then(response => {
                    this.tasks = response.data;
                });
        },
        filterTasks(status) {
            this.filter = status;
            this.fetchTasks();
        }
    },
    mounted() {
        this.fetchTasks();
    }
};
</script>
