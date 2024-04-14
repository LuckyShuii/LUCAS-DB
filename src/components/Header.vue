<script setup>
const props = defineProps(['currentUser'])
</script>

<template>
    <header>
        <h1>LUCAS|GBD</h1>
        <div class="middle-header">
            <p>
                Utilisateur : {{ currentUser }}
            </p>
            <a class="middle-a">
                Changer d'utilisateur
            </a>
            <a>
                Se déconnecter
            </a>
        </div>
        <div>
            <p>Supporté : MySQL</p>
        </div>
    </header>
</template>

<style scoped>
header {
    background-color: var(--main-color);
    height: 35px;
    display: flex;
    align-items: center;
    padding: 0 21px;
    width: 100%;
    justify-content: space-between;
    color: white;
}

.middle-a {
    margin: 0 20px;
}

.middle-header {
    display: flex;
    align-items: center;
}
</style>