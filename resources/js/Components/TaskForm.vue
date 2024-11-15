<template>
    <div>
        <form @submit.prevent="saveTask">
            <input v-model="task.title" placeholder="Título" required />
            <textarea v-model="task.description" placeholder="Descripción" required></textarea>
            <input v-model="task.due_date" type="date" required />
            <button type="submit">Guardar</button>
        </form>
    </div>
 </template>
 
 <script>
 export default {
    data() {
        return {
            task: {
                title: '',
                description: '',
                due_date: ''
            }
        };
    },
    methods: {
        saveTask() {
            axios.post('/api/tasks', this.task)
                .then(() => {
                    this.$emit('task-added');
                    this.task = { title: '', description: '', due_date: '' };
                });
        }
    }
 };
 </script>
 