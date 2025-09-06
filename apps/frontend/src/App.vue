<script setup lang="ts">
import { ref, onMounted } from 'vue'
import HelloWorld from './components/HelloWorld.vue'
import HeroSection from './components/HeroSection.vue'

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
  <div class="app">
    <!-- Hero Section -->
    <HeroSection />
    
    <!-- Development/Testing Section -->
    <div class="dev-section">
      <div class="dev-logos">
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
    </div>
  </div>
</template>

<style scoped lang="scss">
.app {
  min-height: 100vh;
}

.dev-section {
  padding: 2rem 1rem;
  background: #f8f9fa;
  text-align: center;
}

.dev-logos {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-bottom: 2rem;
}

.logo {
  height: 4em;
  padding: 1em;
  will-change: filter;
  transition: filter 300ms;
}

.logo:hover {
  filter: drop-shadow(0 0 2em rgba(100, 108, 255, 0.7));
}

.logo.vue:hover {
  filter: drop-shadow(0 0 2em rgba(66, 184, 131, 0.7));
}

// Mobile-first responsive design
@media (min-width: 768px) {
  .dev-section {
    padding: 3rem 2rem;
  }
  
  .logo {
    height: 6em;
  }
}
</style>
