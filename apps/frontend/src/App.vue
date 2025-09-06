<script setup lang="ts">
import { ref, onMounted } from 'vue'
import HelloWorld from './components/HelloWorld.vue'

const apiData = ref<any>(null)
const loading = ref(false)
const error = ref<string | null>(null)

const fetchApiData = async () => {
  loading.value = true
  error.value = null
  try {
    const response = await fetch('http://localhost:8000/api/hello')
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`)
    }
    apiData.value = await response.json()
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'An error occurred'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchApiData()
})
</script>

<template>
  <div>
    <a href="https://vite.dev" target="_blank">
      <img src="/vite.svg" class="logo" alt="Vite logo" />
    </a>
    <a href="https://vuejs.org/" target="_blank">
      <img src="./assets/vue.svg" class="logo vue" alt="Vue logo" />
    </a>
  </div>
  <HelloWorld msg="Vite + Vue + Laravel" />
  
  <div class="api-section">
    <h2>Laravel API Connection</h2>
    <button @click="fetchApiData" :disabled="loading">
      {{ loading ? 'Loading...' : 'Test API Connection' }}
    </button>
    
    <div v-if="error" class="error">
      Error: {{ error }}
    </div>
    
    <div v-if="apiData" class="api-response">
      <h3>API Response:</h3>
      <pre>{{ JSON.stringify(apiData, null, 2) }}</pre>
    </div>
  </div>
</template>

<style scoped>
/* Component styles are now handled by main.scss */
</style>
