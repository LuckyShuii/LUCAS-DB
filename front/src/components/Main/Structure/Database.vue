<script setup>
import { ref, defineProps } from 'vue'
import Dialog from 'primevue/dialog'
import axios from 'axios'
import Swal from 'sweetalert2'

const props = defineProps(['structure', 'dbName'])
const emit = defineEmits(['updateStructure'])

const visible = ref(false)
const dialogAction = ref('')
const tableToDrop = ref('')
const tableToEmpty = ref('')
const responseAPI = ref('')

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

const displayModal = (type, index) => {
    const tableKey = Object.keys(props.structure.tables[index])[0]
    const tableName = props.structure.tables[index][tableKey]

    visible.value = true

    switch (type) {
        case 'drop':
            dialogAction.value = 'SUPPRIMER LA TABLE'
            tableToDrop.value = tableName
            break
        case 'empty':
            dialogAction.value = 'VIDER LA TABLE'
            tableToEmpty.value = tableName
            break
        default:
            break
    }
}

const dropTable = async (tableName) => {
    try {
        const response = await axios.delete(`http://localhost:8000/api/database/${props.dbName}/table/${tableName}/drop`)
        responseAPI.value = response.data
    } catch (error) {
        throw new Error(error)
    }
}

const emptyTable = async (tableName) => {
    try {
        const response = await axios.delete(`http://localhost:8000/api/database/${props.dbName}/table/${tableName}/empty`)
        responseAPI.value = response.data
    } catch (error) {
        throw new Error(error)
    }
}

const makeActionOnTable = async () => {
    let state = '';

    try {
        if (tableToDrop.value) {
            await dropTable(tableToDrop.value)
            state = 'supprimée'
        } else if (tableToEmpty.value) {
            await emptyTable(tableToEmpty.value)
            state = 'vidée'
        }

        if (responseAPI.value.error) {
            notify('Erreur !', 'La table n\'a pas pu être ' + state, 'error', 10000)

            hideDialog()
            return;
        }

        emit('updateStructure')

        notify('Succès !', 'La table a bien été ' + state, 'success', 5000)
    } catch (error) {
        notify('Erreur !', 'La table n\'a pas pu être ' + state, 'error', 10000)
    }

    hideDialog()
}

const hideDialog = () => {
    visible.value = false
    tableToDrop.value = ''
    tableToEmpty.value = ''
    responseAPI.value = ''
}
</script>

<template>
    <div class="table">
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
                    <button class="button-no-style structure-btn" @click="displayModal('drop', index)">
                        <img src=" @/assets/icons/drop.svg" alt="Drop" />
                        Drop
                    </button>
                    <button class="button-no-style structure-btn" @click="displayModal('empty', index)">
                        <img src="@/assets/icons/empty.svg" alt="Empty" />
                        Empty
                    </button>
                    <button class="button-no-style structure-btn">
                        <img src="@/assets/icons/structure-black.svg" alt="Structure" />
                        Structure
                    </button>
                    <button class="button-no-style structure-btn">
                        <img src="@/assets/icons/browse.svg" alt="Browse" />
                        Browse
                    </button>
                    <button class="button-no-style structure-btn">
                        <img src="@/assets/icons/edit.svg" alt="Edit" />
                        Edit
                    </button>
                </td>
                <td v-for="(value, key) in item" :key="key">
                    {{ value }}
                </td>
            </tr>
        </table>
    </div>
    <Dialog modal :closable="false" v-model:visible="visible" :header="dialogAction">
        <p>
            Etes-vous certain de vouloir continuer ?
            <br>
            Cette action est irréversible.
        </p>
        <div class="buttons">
            <Button class="cancel" type="button" @click="hideDialog">Annuler</Button>
            <Button type="button" @click="makeActionOnTable">Oui</Button>
        </div>
    </Dialog>
</template>

<style scoped>
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