<template>
  <section class="py-20 bg-gradient-to-br from-yellow-50 to-orange-50">
    <div class="container mx-auto px-4">
      <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl mb-6 text-gray-900">
          Ready to Discover Filipino Excellence?
        </h2>
        <p class="text-xl text-gray-700 mb-8 leading-relaxed">
          Register today for free access to Manila FAME. Join thousands of buyers who have found their next bestselling products.
        </p>

        <!-- Benefits -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
          <div class="flex items-center justify-center gap-3 text-gray-700">
            <CheckCircle :size="20" class="text-green-600" />
            <span>Free for qualified buyers</span>
          </div>
          <div class="flex items-center justify-center gap-3 text-gray-700">
            <CheckCircle :size="20" class="text-green-600" />
            <span>Instant access upon approval</span>
          </div>
          <div class="flex items-center justify-center gap-3 text-gray-700">
            <CheckCircle :size="20" class="text-green-600" />
            <span>Networking opportunities included</span>
          </div>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
          <Button 
            size="lg" 
            class-name="bg-yellow-600 hover:bg-yellow-700 text-white px-10 py-4 text-lg rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200"
            @click="handleRegisterNow"
          >
            Register Now - Free
          </Button>
          <Button 
            variant="outline" 
            size="lg"
            class-name="border-gray-300 text-gray-700 hover:bg-gray-50 px-10 py-4 text-lg rounded-full"
            @click="handleDownloadBrochure"
          >
            Download Brochure
          </Button>
        </div>

        <!-- Event Details -->
        <div class="bg-white rounded-xl p-8 shadow-lg">
          <h3 class="text-xl mb-6 text-gray-900">
            Event Details
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <div class="flex items-center justify-center gap-3">
              <Calendar :size="20" class="text-yellow-600" />
              <div class="text-center">
                <div class="text-gray-900">March 15-18, 2024</div>
                <div class="text-sm text-gray-600">4 Days of Excellence</div>
              </div>
            </div>
            <div class="flex items-center justify-center gap-3">
              <MapPin :size="20" class="text-yellow-600" />
              <div class="text-center">
                <div class="text-gray-900">World Trade Center, Manila</div>
                <div class="text-sm text-gray-600">Philippines</div>
              </div>
            </div>
          </div>
        </div>

        <p class="text-sm text-gray-600 mt-6">
          Registration approval typically takes 24-48 hours. 
          <br />
          Questions? Contact our buyer services team at buyers@manilafame.com
        </p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { CheckCircle, Calendar, MapPin } from 'lucide-vue-next'
import Button from './ui/Button.vue'

const router = useRouter()

const handleRegisterNow = () => {
  // Navigate to registration page
  router.push('/register')
}

const handleDownloadBrochure = () => {
  // This would typically trigger a download or open a modal
  // For now, we'll just log the action
  console.log('Download brochure requested')
  // You could implement actual download functionality here
  // window.open('/path/to/brochure.pdf', '_blank')
}
</script>
