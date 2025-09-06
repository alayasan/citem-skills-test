<template>
  <div class="relative w-full overflow-hidden">
    <div 
      ref="carouselContent"
      class="flex animate-scroll"
      :class="className"
    >
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface Props {
  className?: string
}

withDefaults(defineProps<Props>(), {
  className: ''
})

const carouselContent = ref<HTMLElement>()
</script>

<style scoped>
@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

.animate-scroll {
  animation: scroll 15s linear infinite;
}

.animate-scroll:hover {
  animation-play-state: paused;
}
</style>
