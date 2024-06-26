<script setup>
import Dropdown from 'primevue/dropdown';
import { ref } from 'vue';
import collations from '@/data/collations.js';
import axios from 'axios';
import Swal from 'sweetalert2';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue';

const emit = defineEmits(['setNewDbCreated'])

const selectedCollation = ref(null);
const loading = ref(false);
const alreadyExists = ref(false);

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

const checkIfDbExists = async (dbName) => {
    try {
        const response = await axios.get('http://localhost:8000/api/database/check/' + dbName);
        console.log(response.data.exists)
        alreadyExists.value = response.data.exists;
    } catch (error) {
        notify('Erreur !', 'Votre base de données n\'a pas pu être créée.', 'error', 10000);
        loading.value = false;
    }
}

const createDB = async () => {
    loading.value = true;
    let dbName = document.getElementById('name').value;

    if (dbName === '' || selectedCollation.value === null) {
        notify('Erreur !', 'Veuillez remplir tous les champs.', 'error', 5000);
        loading.value = false;
        return;
    }

    let collation = selectedCollation.value.name;

    await checkIfDbExists(dbName);

    if (alreadyExists.value) {
        notify('Erreur !', 'Votre base de données existe déjà.', 'error', 10000);
        loading.value = false;
        return;
    }

    try {
        const reponse = await axios.post('http://localhost:8000/api/database/create', {
            dbName: dbName,
            collation: collation
        })
        notify('Succès !', 'Votre base de données a bien été créée.', 'success', 5000)
        document.getElementById('name').value = '';
        selectedCollation.value = null;

        emit('setNewDbCreated')
        loading.value = false;
    } catch (error) {
        notify('Erreur !', 'Votre base de données n\'a pas pu être créée.', 'error', 10000)
        loading.value = false;
    }
}
</script>

<template>
    <section id="create-db">
        <h2>Création de base de données</h2>
        <form>
            <div class="form">
                <div class="form-block">
                    <label for="name">Nom de la base de données</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-block">
                    <label for="collation">Collation</label>
                    <Dropdown v-model="selectedCollation" :options="collations" optionLabel="name"
                        placeholder="Sélectionner une collation" />
                </div>
            </div>
            <div class="form">
                <button type="submit" @click.prevent="createDB" class="btn btn-primary"
                    :disabled="loading">Créer</button>
                <div id="loader" v-if="loading">
                    <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
                </div>
            </div>
        </form>
    </section>
</template>

<style scoped>
#loader {
    margin-top: 0.5rem;
}

#create-db {
    margin: 0.5rem 0 2rem 0;
    border: 1px solid #ccc;
    padding: 1rem;
    border-radius: 0.25rem;
    width: 100%;
}

h2 {
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.form-block {
    margin: 1rem 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

label {
    font-weight: 400;
}

input {
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 0.25rem;
    margin-right: 0.5rem;
    outline: none;
}

.form {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem
}

button {
    padding: 1rem 1.5rem;
    font-size: 1rem;
    cursor: pointer;
}
</style>