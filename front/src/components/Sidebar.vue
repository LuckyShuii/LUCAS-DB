<script setup>
import Databases from '../components/Sidebar/Databases.vue'
import { defineEmits, ref } from 'vue'

const propre = defineProps(['openDb'])
const emit = defineEmits(['getDbName', 'setCreateDB'])
</script>

<template>
    <section id="sidebar">
        <div class="div-add">
            <button class="add-db" @click="emit('setCreateDB')">
                <img src="../assets/icons/add.svg" alt="Add" />
                Créer une base de données
            </button>
        </div>
        <h2>Mes bases de données</h2>
        <Databases id="db" @getDbName="emit('getDbName', $event)" :openDb="openDb" />
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
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 400;
    height: 3rem;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
}

#db {
    margin: 1rem 14px;
}

.add-db {
    width: 90%;
    margin: 0 0 1rem 0;
    height: 3rem;
    border-radius: 10rem;
    font-size: 1rem;
}

.div-add {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 1rem;
}
</style>