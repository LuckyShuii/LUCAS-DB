<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import Database from './Structure/Database.vue';
import Swal from 'sweetalert2'

const props = defineProps(['view', 'dbName']);

const structure = ref([]);
const success = ref(false);
const loading = ref(false)

const getDatabaseStructure = async () => {
    try {
        const response = await axios.get(`http://localhost:8000/api/database/${props.dbName}`);
        structure.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

const setSuccess = () => {
    success.value = true;
    loading.value = false;
};

const selectStructure = async (view) => {
    try {
        switch (view) {
            case 'database':
                await getDatabaseStructure();
                setSuccess();
                break;
            case 'table':
                await getTableStructure();
                setSuccess();
                break;
            case 'column':
                await getColumnStructure();
                setSuccess();
                break;
            default:
                await getDatabaseStructure();
                setSuccess();
                break;
        }
    } catch (error) {
        Swal.fire({
            title: 'Error!',
            text: 'Your database structure could not be fetched.',
            icon: 'error',
            timer: 10000,
            position: 'top-right',
            toast: true,
            showConfirmButton: false,
            showCloseButton: true
        })
    }
};


onMounted(async () => {
    loading.value = true;
    await selectStructure(props.view);
});

watch(() => props.dbName, async () => {
    await selectStructure(props.view);
});

</script>

<template>
    <section class="tab-structure" id="structure">
        <h2 class="main-title">
            <img src="../../assets/icons/db.svg" alt="Add" />
            Base de données concernée :<span class="db-name"><a href="#">{{ dbName }}</a></span>
        </h2>
        <div class="loader" v-if="loading">
            <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
        </div>
        <Database :structure="structure" :dbName="dbName" v-if="view === 'database' && !loading"
            @update-structure="getDatabaseStructure" />
    </section>
</template>

<style scoped></style>