<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
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
        <div class="table" :class="{ 'displayed': success }">
            <table v-if="structure.tables">
                <tr>
                    <th>
                        Actions
                    </th>
                    <th>
                        Table
                    </th>
                    <th>
                        Rows
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        Collation
                    </th>
                    <th>
                        Size
                    </th>
                </tr>
                <tr v-for="(item, index) in structure.tables" :key="index">
                    <td class="action-btn">
                        <button class="button-no-style structure-btn">
                            <img src="../../assets/icons/drop.svg" alt="Drop" />
                            Drop
                        </button>
                        <button class="button-no-style structure-btn">
                            <img src="../../assets/icons/empty.svg" alt="Empty" />
                            Empty
                        </button>
                        <button class="button-no-style structure-btn">
                            <img src="../../assets/icons/structure-black.svg" alt="Structure" />
                            Structure
                        </button>
                        <button class="button-no-style structure-btn">
                            <img src="../../assets/icons/browse.svg" alt="Browse" />
                            Browse
                        </button>
                        <button class="button-no-style structure-btn">
                            <img src="../../assets/icons/edit.svg" alt="Edit" />
                            Edit
                        </button>
                    </td>
                    <td v-for="(value, key) in item" :key="key">
                        {{ value }}
                    </td>
                </tr>
            </table>
        </div>
    </section>
</template>

<style scoped>
.structure-btn {
    padding: 0.5rem;
}

.structure-btn:hover {
    background-color: var(--main-color);
    color: white;
}

.structure-btn:active {
    background-color: #1f3e2e;
}

.action-btn {
    display: flex;
    gap: 0.5rem;
}

table,
th,
td {
    border: 1px solid white;
    border-collapse: collapse;
    font-size: 0.8rem;
    padding: 0.5rem;
    text-align: left;
}

.table {
    margin-top: 1rem;
    overflow-x: scroll;
    max-height: calc(100vh - 160px);
}

th {
    background-color: var(--main-color);
    color: white;
}

td {
    background-color: var(--secondary-color);
}
</style>