<template>
    <div>
        <h3>{{ task.title }}</h3>
        <p>{{ task.description }}</p>
        <p>Fecha de vencimiento: {{ task.due_date }}</p>
        <button @click="toggleCompletion">{{ task.completed ? 'Marcar como incompleta' : 'Marcar como completada' }}</button>
        <button @click="deleteTask">Eliminar</button>
    </div>
 </template>
 
 <script>
 export default {
    props: ['task'],
    methods: {
        toggleCompletion() {
            axios.patch(`/api/tasks/${this.task.id}/toggle`)
                .then(() => {
                    this.$emit('task-updated');
                });
        },
        deleteTask() {
            axios.delete(`/api/tasks/${this.task.id}`)
                .then(() => {
                    this.$emit('task-deleted');
                });
        }
    }
 };
 </script>
 