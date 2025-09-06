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
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}

.api-section {
  margin: 2rem 0;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.api-response {
  margin-top: 1rem;
  text-align: left;
}

.api-response pre {
  background: #f5f5f5;
  padding: 1rem;
  border-radius: 4px;
  overflow-x: auto;
}

.error {
  color: red;
  margin-top: 1rem;
}

button {
  background: #42b883;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
}

button:disabled {
  background: #ccc;
  cursor: not-allowed;
}
</style>
