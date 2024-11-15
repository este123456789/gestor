<template>
    <div>
        <button :disabled="meta.current_page === 1" @click="changePage(meta.current_page - 1)">Anterior</button>
        <button :disabled="meta.current_page === meta.last_page" @click="changePage(meta.current_page + 1)">Siguiente</button>
    </div>
 </template>
 
 <script>
 export default {
    props: ['meta'],
    methods: {
        changePage(page) {
            this.$emit('page-changed', page);
        }
    }
 };
 </script>
 