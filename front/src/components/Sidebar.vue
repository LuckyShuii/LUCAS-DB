<script setup>
import Databases from '../components/Sidebar/Databases.vue'

const emit = defineEmits(['getDbName'])
</script>

<template>
    <section id="sidebar">
        <h2>Mes bases de données</h2>
        <Databases id="db" @getDbName="emit('getDbName', $event)" />
    </section>
</template>

<style scoped>
#sidebar {
    width: 350px;
    background-color: var(--secondary-color);
    height: calc(100vh - 35px);
    overflow: scroll;
}

h2 {
    text-align: center;
    padding: 1rem;
    font-weight: 400;
    border-bottom: 1px solid black;
}

#db {
    margin: 1rem 14px;
}
</style>