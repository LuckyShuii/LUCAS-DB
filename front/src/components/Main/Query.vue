<script setup>
import { ref, watch } from 'vue'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import axios from 'axios'

const props = defineProps(['dbName'])
const emit = defineEmits(['updateActiveTab'])

const loading = ref(false)
const success = ref('')
const notification = ref('')
const responseMessage = ref('')
const textarea = ref('')
const disabled = ref(false)

const resetQuery = () => {
    textarea.value = ''
    success.value = ''
    responseMessage.value = ''
}

watch(() => props.dbName, () => {
    resetQuery()
})

const fillTextarea = (query) => {
    switch (query) {
        case 'SELECT':
            textarea.value = 'SELECT * FROM table_name WHERE condition;'
            break;
        case 'INSERT':
            textarea.value = 'INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);'
            break;
        case 'UPDATE':
            textarea.value = 'UPDATE table_name SET column1 = value1, column2 = value2, ... WHERE condition;'
            break;
        case 'DELETE':
            textarea.value = 'DELETE FROM table_name WHERE condition;'
            break;
        case 'ALTER':
            textarea.value = 'ALTER TABLE table_name ADD column_name datatype;'
            break;
        default:
            break;
    }
}

const runQuery = async () => {
    loading.value = true

    if (textarea.value === '') {
        success.value = false
        notification.value = 'Query cannot be empty'
        loading.value = false
        return
    }

    try {
        const response = await axios.post(`http://localhost:8000/api/query`, {
            query: textarea.value,
            database: props.dbName
        });

        loading.value = false

        if (response.data.error) {
            success.value = false
            notification.value = 'An error occurred'
            responseMessage.value = response.data.error
            return;
        }

        success.value = true
        notification.value = 'Query executed successfully'
        responseMessage.value = response.data.result
    } catch (err) {
        loading.value = false
        success.value = false
        notification.value = 'An error occurred'
        responseMessage.value = err.message
        return;
    }
}
</script>

<template>
    <section class="tab-structure" v-if="dbName">
        <h2 class="main-title">
            <img src="../../assets/icons/db.svg" alt="Add" />
            Base de données concernée : <span class="db-name" @click="emit('updateActiveTab')">{{ dbName
                }}</span>
        </h2>
        <section id="help-buttons">
            <button @click="fillTextarea('SELECT')">
                SELECT
            </button>
            <button class="marged" @click="fillTextarea('INSERT')">
                INSERT
            </button>
            <button class="marged" @click="fillTextarea('UPDATE')">
                UPDATE
            </button>
            <button class="marged" @click="fillTextarea('DELETE')">
                DELETE
            </button>
            <button class="marged" @click="fillTextarea('ALTER')">
                ALTER
            </button>
        </section>
        <form action="" method="post" @submit.prevent="runQuery">
            <textarea v-model="textarea" name="query" id="query" cols="30" rows="10"></textarea>
            <div id="loader" v-if="loading">
                <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
            </div>
            <div class="buttons">
                <button type="submit" id="execute-btn" :disabled="disabled">Exécuter</button>
                <button type="reset" id="reset-btn" @click="resetQuery" :disabled="disabled">
                    <img src="../../assets/icons/reset.svg" alt="Reset" />
                    Réinitialiser
                </button>
            </div>
            <p class="info-p success" v-if="success">
                Success: {{ notification }}
                <br>
                <span v-if="responseMessage.length == 0">No data found</span>
            </p>
            <p class="info-p fail" v-if="success !== '' && !success">
                Error: {{ notification }}
                <br>
                {{ responseMessage }}
            </p>
            <div class="table notDisplayed" :class="{ 'displayed': success }">
                <table v-if="success">
                    <tr v-if="responseMessage.length">
                        <th v-for="(value, key) in responseMessage[0]" :key="key">
                            {{ key }}
                        </th>
                    </tr>
                    <tr v-for="(item, index) in responseMessage" :key="index">
                        <td v-for="(value, key) in item" :key="key">
                            {{ value }}
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </section>
</template>

<style scoped>
.notDisplayed {
    display: none;
}

.displayed {
    display: block;
}

table,
th,
td {
    border: 1px solid white;
    border-collapse: collapse;
    font-size: 0.8rem;
    padding: 0.5rem;
}


.table {
    margin-top: 1rem;
    overflow-x: scroll;
    max-height: calc(100vh - 440px);
}

th {
    background-color: var(--main-color);
    color: white;
}

td {
    background-color: var(--secondary-color);
}

.sucess-response {
    font-size: 13px;
}

#help-buttons {
    display: flex;
    margin-top: 1rem;
}

.marged {
    margin-left: 0.5rem;
}

.info-p {
    margin-top: 1rem;
    width: 100%;
    padding: 0.5rem;
    border-radius: 5px;
    font-size: 0.9rem;
}

.success {
    background-color: var(--main-color);
    color: white;
    max-height: calc(100vh - 540px);
    overflow-y: scroll;
    margin-bottom: 1rem;
}

.fail {
    background-color: rgb(141, 56, 56);
    color: white;
}

.buttons {
    display: flex;
    margin: 1rem 0 0.5rem 0;
}

#execute-btn {
    margin-right: 0.5rem;
}

#reset-btn {
    background-color: #9fc2b7;
    color: black;
}

#reset-btn:hover {
    background-color: var(--main-color);
    color: white;
    border: none;
}

#reset-btn:active {
    background-color: #000;
    color: white;
}

#query {
    width: 100%;
    margin-top: 1rem;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
    outline: none;
    height: 100px;
}
</style>