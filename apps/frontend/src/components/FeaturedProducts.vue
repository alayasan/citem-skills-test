<template>
  <section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl mb-4 text-gray-900">
          Featured Products & Exhibitors
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Get a preview of the exceptional quality and craftsmanship waiting for you at Manila FAME
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div 
          v-for="(product, index) in products"
          :key="index"
          class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
        >
          <div class="relative h-64 overflow-hidden">
            <ImageWithFallback
              :src="product.image"
              :alt="product.title"
              class-name="w-full h-full object-cover transform hover:scale-105 transition-transform duration-300"
            />
            <Badge 
              class-name="absolute top-4 left-4 bg-white/90 text-gray-800"
            >
              {{ product.category }}
            </Badge>
          </div>
          <div class="p-6">
            <h3 class="text-xl mb-2 text-gray-900">
              {{ product.title }}
            </h3>
            <p class="text-gray-600 mb-4">
              by {{ product.exhibitor }}
            </p>
            <div class="flex items-center justify-between">
              <span class="text-sm text-gray-500">
                View at Manila FAME
              </span>
              <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-12">
        <p class="text-gray-600 mb-6">
          Discover hundreds more exhibitors and thousands of products
        </p>
        <button 
          class="text-yellow-600 hover:text-yellow-700 underline"
          @click="viewAllExhibitors"
        >
          View All Exhibitors →
        </button>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import ImageWithFallback from './ui/ImageWithFallback.vue'
import Badge from './ui/Badge.vue'

interface Product {
  image: string
  exhibitor: string
  category: string
  title: string
}

const products = ref<Product[]>([
  {
    image: "https://images.unsplash.com/photo-1695391353234-ee14eba4ee2c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjB3b3ZlbiUyMGJhc2tldHMlMjBhcnRpc2FufGVufDF8fHx8MTc1NzExODA2Mnww&ixlib=rb-4.1.0&q=80&w=1080",
    exhibitor: "Artisan Weave Co.",
    category: "Home Decor",
    title: "Handwoven Storage Baskets"
  },
  {
    image: "https://images.unsplash.com/photo-1543874835-ad7d64196a07?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxoYW5kd292ZW4lMjB0ZXh0aWxlcyUyMGZhc2hpb24lMjBhY2Nlc3Nvcmllc3xlbnwxfHx8fDE3NTcxMTgwNjV8MA&ixlib=rb-4.1.0&q=80&w=1080",
    exhibitor: "Manila Textiles Inc.",
    category: "Fashion",
    title: "Heritage Textile Collection"
  },
  {
    image: "https://images.unsplash.com/photo-1673691186762-5611baa346d7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxtb2Rlcm4lMjBtaW5pbWFsaXN0JTIwZnVybml0dXJlJTIwc2hvd3Jvb218ZW58MXx8fHwxNzU3MTE4MDY4fDA&ixlib=rb-4.1.0&q=80&w=1080",
    exhibitor: "Modern Bamboo Design",
    category: "Furniture",
    title: "Sustainable Living Furniture"
  }
])

const viewAllExhibitors = () => {
  // This would typically navigate to an exhibitors page
  // For now, we'll just log the action
  console.log('Navigate to all exhibitors page')
}
</script>
