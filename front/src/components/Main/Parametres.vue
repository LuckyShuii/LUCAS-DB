<script setup>
import Swal from 'sweetalert2';
import axios from 'axios';

const emit = defineEmits(['updateActiveTab', 'setNewDbCreated']);
const props = defineProps(['dbName']);

const dropDb = async () => {
    try {
        await axios.delete('http://localhost:8000/api/database/drop/' + props.dbName);
        emit('updateActiveTab');
        emit('setNewDbCreated');
        Swal.fire({
            title: 'Succès !',
            text: 'Votre base de données a bien été supprimée.',
            icon: 'success',
            timer: 5000,
            position: 'top-right',
            toast: true,
            showConfirmButton: false,
            showCloseButton: true
        })
    } catch (error) {
        Swal.fire({
            title: 'Erreur !',
            text: 'Votre base de données n\'a pas pu être supprimée.' + error,
            icon: 'error',
            timer: 10000,
            position: 'top-right',
            toast: true,
            showConfirmButton: false,
            showCloseButton: true
        })
    }
}
</script>

<template>
    <section class="tab-structure" id="query">
        <h2 class="main-title">
            <img src="../../assets/icons/db.svg" alt="Add" />
            Base de données concernée : <span class="db-name" @click="emit('updateActiveTab')">{{ dbName
                }}</span>
        </h2>
        <button id="drop-db" @click="dropDb">
            <img src="../../assets/icons/drop.svg" alt="Poubelle" id="db-drop" />
            <span>Drop Database</span>
        </button>
    </section>
</template>

<style scoped>
#drop-db {
    background-color: #f84130;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

#drop-db img {
    width: 1.5rem;
    margin-right: 0.5rem;
}

#drop-db:hover {
    background-color: #e63828;
}

#drop-db:active {
    background-color: #d5341f;
}
</style>