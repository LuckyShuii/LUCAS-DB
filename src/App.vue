<script setup>
import Header from './components/Header.vue'
import Sidebar from './components/Sidebar.vue'
import Main from './components/Main.vue'

import { ref } from 'vue'

const currentUser = ref('root')
</script>

<template>
  <Header :currentUser="currentUser" />
  <div class="app">
    <Sidebar id="sidebar" />
    <Main />
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
