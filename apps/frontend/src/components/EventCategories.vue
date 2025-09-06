<template>
  <section class="py-20 bg-white">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl mb-4 text-gray-900">
          Event Categories
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Explore three main categories showcasing the best of Philippine design and craftsmanship
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div 
          v-for="(category, index) in categories"
          :key="index"
          class="group relative overflow-hidden rounded-2xl h-96 cursor-pointer transform hover:scale-105 transition-all duration-300"
          @click="exploreCategory(category.title)"
        >
          <!-- Background Image -->
          <ImageWithFallback
            :src="category.image"
            :alt="category.title"
            class-name="w-full h-full object-cover"
          />
          
          <!-- Gradient Overlay -->
          <div :class="`absolute inset-0 bg-gradient-to-t ${category.color} opacity-70 group-hover:opacity-80 transition-opacity duration-300`"></div>
          
          <!-- Content -->
          <div class="absolute inset-0 p-8 flex flex-col justify-end text-white">
            <h3 class="text-2xl mb-4 group-hover:transform group-hover:translate-y-[-4px] transition-transform duration-300">
              {{ category.title }}
            </h3>
            <p class="text-white/90 leading-relaxed group-hover:text-white transition-colors duration-300">
              {{ category.description }}
            </p>
            <div class="mt-4 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
              <span class="text-sm text-white/90">
                Explore Category →
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import ImageWithFallback from './ui/ImageWithFallback.vue'

interface Category {
  title: string
  description: string
  image: string
  color: string
}

const categories = ref<Category[]>([
  {
    title: "Furniture & Home",
    description: "Handcrafted furniture, home decor, and living essentials made from sustainable materials",
    image: "https://images.unsplash.com/photo-1673691186762-5611baa346d7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBtaW5pbWFsaXN0JTIwZnVybml0dXJlJTIwc2hvd3Jvb218ZW58MXx8fHwxNzU3MTE4MDY4fDA&ixlib=rb-4.1.0&q=80&w=1080",
    color: "from-amber-500 to-orange-600"
  },
  {
    title: "Fashion & Accessories",
    description: "Contemporary and traditional fashion, jewelry, and accessories with Filipino heritage",
    image: "https://images.unsplash.com/photo-1746458258667-63bf641e4db3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxlbGVnYW50JTIwamV3ZWxyeSUyMGFjY2Vzc29yaWVzfGVufDF8fHx8MTc1NzAxNDYwN3ww&ixlib=rb-4.1.0&q=80&w=1080",
    color: "from-pink-500 to-red-600"
  },
  {
    title: "Gifts & Lifestyle",
    description: "Unique lifestyle products, artisanal gifts, and contemporary design pieces",
    image: "https://images.unsplash.com/photo-1532210910840-08ddf89c77af?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBob21lJTIwZGVjb3IlMjBnaWZ0c3xlbnwxfHx8fDE3NTcxMTgxMTR8MA&ixlib=rb-4.1.0&q=80&w=1080",
    color: "from-emerald-500 to-teal-600"
  }
])

const exploreCategory = (categoryTitle: string) => {
  // This would typically navigate to a category-specific page
  // For now, we'll just log the action
  console.log(`Explore category: ${categoryTitle}`)
}
</script>
