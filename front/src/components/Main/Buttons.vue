<script setup>
const emit = defineEmits(['activeTab'])
const props = defineProps(['activeTab'])
</script>

<template>
    <section id="top-buttons">
        <button id="structure" @click="emit('activeTab', 'structure')" :class="{ active: activeTab === 'structure' }">
            <img src="../../assets/icons/structure.svg" alt="Add" />
            Structure
        </button>
        <button class="to-marge" id="query" @click="emit('activeTab', 'query')"
            :class="{ active: activeTab === 'query' }">
            <img src="../../assets/icons/sql.svg" alt="Add" />
            Requête
        </button>
        <button class="to-marge" id="import" @click="emit('activeTab', 'importer')"
            :class="{ active: activeTab === 'importer' }">
            <img src="../../assets/icons/import.svg" alt="Add" />
            Importer
        </button>
        <button class="to-marge" id="users" @click="emit('activeTab', 'utilisateurs')"
            :class="{ active: activeTab === 'utilisateurs' }">
            <img src="../../assets/icons/users.svg" alt="Add" />
            Utilisateurs
        </button>
        <button class="to-marge" @click="emit('activeTab', 'parametres')"
            :class="{ active: activeTab === 'parametres' }">
            <img src="../../assets/icons/settings.svg" id="settings" alt="Add" />
            Paramètres
        </button>
    </section>
</template>

<style scoped>
#top-buttons {
    display: flex;
    margin-bottom: 1rem;
}

.to-marge {
    margin-left: 1rem;
}

#settings {
    width: 11px;
}

.active {
    background-color: #235741;
}
</style>