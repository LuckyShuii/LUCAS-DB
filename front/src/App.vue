<script setup>
import Header from './components/Header.vue'
import Sidebar from './components/Sidebar.vue'
import Main from './components/Main.vue'

import { ref, watch } from 'vue'

const currentUser = ref('root')
const dbName = ref()
const createDB = ref(false)
const openDb = ref(-1)
const newDbCreated = ref(-1)

const setCreateDB = () => {
  createDB.value = true
  openDb.value++
}

const setCreateDBnoTab = () => {
  createDB.value = false;
}

const setDbName = (name) => {
  dbName.value = name
}

const setNewDbCreated = (from = null) => {
  newDbCreated.value++
  if (from === 'drop') {
    dbName.value = ''
  }
}

watch(() => dbName.value, () => {
  createDB.value = false
})
</script>

<template>
  <Header :currentUser="currentUser" />
  <div class="app">
    <Sidebar id="sidebar" @getDbName="setDbName" @setCreateDB="setCreateDB" :openDb="openDb"
      :newDbCreated="newDbCreated" />
    <Main :dbName="dbName" :createDB="createDB" @setCreateDB="setCreateDBnoTab" @setNewDbCreated="setNewDbCreated" />
  </div>
</template>

<style scoped>
.app {
  display: flex;
  height: 100%;
}

#sidebar {
  margin-right: 1rem;
}
</style>
