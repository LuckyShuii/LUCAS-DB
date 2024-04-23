<script setup>
import Swal from 'sweetalert2';
import axios from 'axios';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';
import Dialog from 'primevue/dialog';
import { ref } from 'vue';

const emit = defineEmits(['updateActiveTab', 'setNewDbCreated']);
const props = defineProps(['dbName']);

const visible = ref(false);

const loading = ref(false);

const notify = (title, text, icon, timer) => {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        timer: timer,
        position: 'top-right',
        toast: true,
        showConfirmButton: false,
        showCloseButton: true
    })
}

const dropDb = async () => {
    loading.value = true;
    try {
        const response = await axios.delete('http://localhost:8000/api/database/drop/' + props.dbName);

        if (response.data.error) {
            notify('Erreur !', 'Votre base de données n\'a pas pu être supprimée.', 'error', 10000);
            loading.value = false;
            hideDialog();
            return;
        }

        emit('updateActiveTab');
        emit('setNewDbCreated');

        notify('Succès !', 'Votre base de données a bien été supprimée.', 'success', 5000);

        loading.value = false;
        hideDialog();
    } catch (error) {
        notify('Erreur !', 'Votre base de données n\'a pas pu être supprimée.', 'error', 10000);
        loading.value = false;
        hideDialog();
    }
}

const hideDialog = () => {
    visible.value = false;
}

const displayModal = () => {
    visible.value = true;
    console.log("bruh")
}
</script>

<template>
    <section class="tab-structure" id="query">
        <h2 class="main-title">
            <img src="../../assets/icons/db.svg" alt="Add" />
            Base de données concernée : <span class="db-name" @click="emit('updateActiveTab')">{{ dbName
                }}</span>
        </h2>
        <button id="drop-db" @click="displayModal" :disabled="loading">
            <img src="../../assets/icons/drop.svg" alt="Poubelle" id="db-drop" />
            <span>Drop Database</span>
        </button>
        <div id="loader" v-if="loading">
            <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
        </div>
    </section>
    <Dialog modal :closable="false" v-model:visible="visible" header="SUPPRIMER DÉFINTIVEMENT">
        <p>
            Etes-vous certain de vouloir supprimer la base de données <span id="db-dialog">{{ dbName }}</span> ?
            <br><br>
            Cette action est irréversible.
        </p>
        <div class="buttons">
            <Button class="cancel" type="button" @click="hideDialog">Annuler</Button>
            <Button type="button" @click="dropDb">Oui</Button>
        </div>
    </Dialog>
</template>

<style scoped>
#db-dialog {
    font-weight: 400;
    text-decoration: underline;
}

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