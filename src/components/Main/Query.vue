<script setup>
const props = defineProps(['dbName'])
</script>

<template>
    <section id="query">
        <h2 id="main-title">
            <img src="../../assets/icons/db.svg" alt="Add" />
            Base de données concernée :<span id="db-name"><a href="#">{{ dbName }}</a></span>
        </h2>
    </section>
</template>

<style scoped>
#db-name a {
    color: var(--main-color);
    font-weight: 500;
    margin-left: 5px;
}

#db-name a:hover {
    border-bottom: 1px solid var(--main-color);
}

#db-name a:active {
    border-bottom: 1px solid #000;
    color: #000;
}

#main-title {
    display: flex;
    align-items: center;
    margin: 18px 0;
}

#main-title img {
    width: 20px;
    margin-right: 0.5rem;
}
</style>