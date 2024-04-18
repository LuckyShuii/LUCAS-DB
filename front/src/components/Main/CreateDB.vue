<script setup>
import Dropdown from 'primevue/dropdown';
import { ref } from 'vue';
import collations from '@/data/collations.js';
import axios from 'axios';
import Swal from 'sweetalert2';

const emit = defineEmits(['setNewDbCreated'])

const selectedCollation = ref(null);
const alreadyExists = ref(false);

const checkIfDbExists = async (dbName) => {
    try {
        const response = await axios.get('http://localhost:8000/api/database/check/' + dbName);
        console.log(response.data.exists)
        alreadyExists.value = response.data.exists;
    } catch (error) {
        Swal.fire({
            title: 'Erreur !',
            text: 'Votre base de données n\'a pas pu être créée.' + error,
            icon: 'error',
            timer: 10000,
            position: 'top-right',
            toast: true,
            showConfirmButton: false,
            showCloseButton: true
        })
    }
}

const createDB = async () => {
    let dbName = document.getElementById('name').value;

    if (dbName === '' || selectedCollation.value === null) {
        Swal.fire({
            title: 'Erreur !',
            text: 'Veuillez remplir tous les champs.',
            icon: 'error',
            timer: 5000,
            position: 'top-right',
            toast: true,
            showConfirmButton: false,
            showCloseButton: true
        })
        return;
    }

    let collation = selectedCollation.value.name;

    await checkIfDbExists(dbName);

    if (alreadyExists.value) {
        Swal.fire({
            title: 'Erreur !',
            text: 'Votre cette base de données existe déjà.',
            icon: 'error',
            timer: 5000,
            position: 'top-right',
            toast: true,
            showConfirmButton: false,
            showCloseButton: true
        })
        return;
    }

    try {
        const reponse = await axios.post('http://localhost:8000/api/database/create', {
            dbName: dbName,
            collation: collation
        })
        Swal.fire({
            title: 'Succès !',
            text: 'Votre base de données a été créée avec succès.',
            icon: 'success',
            timer: 10000,
            position: 'top-right',
            toast: true,
            showConfirmButton: false,
            showCloseButton: true
        })
        document.getElementById('name').value = '';
        selectedCollation.value = null;

        emit('setNewDbCreated')
    } catch (error) {
        Swal.fire({
            title: 'Erreur !',
            text: 'Votre base de données n\'a pas pu être créée.' + error,
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
            <button type="submit" @click.prevent="createDB" class="btn btn-primary">Créer</button>
        </form>
    </section>
</template>

<style scoped>
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