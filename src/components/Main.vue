<script setup>
import Buttons from '../components/Main/Buttons.vue'
import Query from '../components/Main/Query.vue'
import Importer from '../components/Main/Importer.vue'
import Parametres from '../components/Main/Parametres.vue'
import Utilisateurs from '../components/Main/Utilisateurs.vue'
import { ref } from 'vue'

const props = defineProps(['dbName'])

const activeTab = ref()

const changeTab = (event) => {
    activeTab.value = event
}
</script>

<template>
    <main>
        <Buttons @active-tab="changeTab" />
        <Query v-if="activeTab === 'query'" :dbName="dbName" :activeTab="activeTab" />
        <Importer v-if="activeTab === 'importer'" />
        <Parametres v-if="activeTab === 'parametres'" />
        <Utilisateurs v-if="activeTab === 'utilisateurs'" />
    </main>
</template>

<style scoped>
main {
    margin-top: 1rem;
}

.active {
    background-color: red;
}
</style>