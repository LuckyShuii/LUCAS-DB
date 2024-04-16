<script setup>
import { ref, watch } from 'vue'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import axios from 'axios'

const props = defineProps(['dbName'])

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
            textarea.value = 'SELECT * FROM table_name;'
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
    <section class="query-section" v-if="dbName">
        <h2 id="main-title">
            <img src="../../assets/icons/db.svg" alt="Add" />
            Base de données concernée :<span id="db-name"><a href="#">{{ dbName }}</a></span>
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
        </section>
        <form action="" method="post" @submit.prevent="runQuery">
            <textarea v-model="textarea" name="query" id="query" cols="30" rows="10"
                @keydown.enter="runQuery"></textarea>
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
            <pre class="sucess-response">{{ responseMessage }}</pre>
            </p>
            <p class="info-p fail" v-if="success !== '' && !success">
                Error: {{ notification }}
                <br>
                {{ responseMessage }}
            </p>
        </form>
    </section>
</template>

<style scoped>
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

#loader {
    margin-top: 1rem;
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
    margin-top: 8px;
}

#main-title img {
    width: 20px;
    margin-right: 0.5rem;
}

#query {
    width: 100%;
    margin-top: 1rem;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
    outline: none;
}

.query-section {
    width: 100%;
    margin-top: 1rem;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
    padding-bottom: 1rem
}
</style>