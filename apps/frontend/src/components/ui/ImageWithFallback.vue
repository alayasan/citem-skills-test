<template>
  <img 
    :src="currentSrc" 
    :alt="alt"
    :class="className"
    @error="handleError"
    @load="handleLoad"
  />
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

interface Props {
  src: string
  alt: string
  fallback?: string
  className?: string
}

const props = withDefaults(defineProps<Props>(), {
  fallback: 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?q=80&w=400&auto=format&fit=crop',
  className: ''
})

const hasError = ref(false)
const isLoaded = ref(false)

const currentSrc = computed(() => {
  return hasError.value ? props.fallback : props.src
})

const handleError = () => {
  if (!hasError.value) {
    hasError.value = true
  }
}

const handleLoad = () => {
  isLoaded.value = true
}
</script>
