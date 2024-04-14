<script setup>

</script>

<template>
    <section id="top-buttons">
        <button id="query">
            <img src="../../assets/icons/sql.svg" alt="Add" />
            Query
        </button>
        <button class="to-marge" id="import">
            <img src="../../assets/icons/import.svg" alt="Add" />
            Import
        </button>
        <button class="to-marge" id="users">
            <img src="../../assets/icons/users.svg" alt="Add" />
            Users
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
</style>