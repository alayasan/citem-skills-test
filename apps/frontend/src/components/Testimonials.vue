<template>
  <section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl mb-4 text-gray-900">
          What Buyers Say
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Join thousands of satisfied buyers who have found their perfect products at Manila FAME
        </p>
      </div>

      <!-- Testimonials Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div 
          v-for="(testimonial, index) in testimonials"
          :key="index"
          class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300"
        >
          <!-- Rating Stars -->
          <div class="flex mb-4">
            <Star 
              v-for="i in testimonial.rating"
              :key="i"
              :size="20"
              class="text-yellow-400 fill-current"
            />
          </div>
          
          <!-- Quote -->
          <p class="text-gray-700 mb-6 leading-relaxed italic">
            "{{ testimonial.quote }}"
          </p>
          
          <!-- Author Info -->
          <div class="border-t pt-4">
            <div class="text-gray-900 mb-1">
              {{ testimonial.name }}
            </div>
            <div class="text-sm text-gray-600">
              {{ testimonial.company }}
            </div>
            <div class="text-xs text-gray-500">
              {{ testimonial.country }}
            </div>
          </div>
        </div>
      </div>

      <!-- Social Proof - Company Logos -->
      <div class="text-center">
        <p class="text-gray-600 mb-8">
          Trusted by leading retailers worldwide
        </p>
        <div class="relative max-w-4xl mx-auto opacity-60">
          <Carousel class-name="w-full">
            <div 
              v-for="logo in duplicatedLogos"
              :key="`${logo}-${Math.random()}`"
              class="flex-shrink-0 px-4"
              style="width: 200px;"
            >
              <div class="text-gray-600 text-lg px-4 py-2 border border-gray-200 rounded-lg text-center whitespace-nowrap">
                {{ logo }}
              </div>
            </div>
          </Carousel>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Star } from 'lucide-vue-next'
import Carousel from './ui/Carousel.vue'

interface Testimonial {
  quote: string
  name: string
  company: string
  country: string
  rating: number
}

const testimonials = ref<Testimonial[]>([
  {
    quote: "Manila FAME consistently delivers exceptional quality products and connects us with reliable Filipino manufacturers. The craftsmanship is world-class.",
    name: "Sarah Chen",
    company: "Global Interiors Ltd.",
    country: "Singapore",
    rating: 5
  },
  {
    quote: "The sustainable and ethical practices of Philippine exporters align perfectly with our brand values. Manila FAME is our go-to sourcing destination.",
    name: "Marcus Rodriguez",
    company: "Eco Living Co.",
    country: "United States",
    rating: 5
  },
  {
    quote: "We've built long-lasting partnerships through Manila FAME. The variety and innovation in Filipino design never cease to amaze our customers.",
    name: "Emma Thompson",
    company: "Artisan Home",
    country: "United Kingdom",
    rating: 5
  }
])

const companyLogos = ref<string[]>([
  "IKEA", "West Elm", "Crate & Barrel", "Williams Sonoma", "CB2"
])

// Duplicate logos for seamless scrolling
const duplicatedLogos = computed(() => {
  return [...companyLogos.value, ...companyLogos.value]
})
</script>
