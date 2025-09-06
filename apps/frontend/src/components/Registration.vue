<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <!-- Manila FAME Logo -->
            <div class="flex items-center gap-4">
              <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md">
                MF
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-900">Event Registration</h1>
                <p class="text-gray-600 font-medium">Manila FAME 2025</p>
              </div>
            </div>
          </div>
          <div class="text-right">
            <div v-if="!isSubmitted" class="text-sm text-gray-500 font-medium">Step {{ currentStep }} of 3</div>
            <div v-else class="text-sm text-green-600 font-medium">Registration Complete!</div>
            <div v-if="!isSubmitted" class="w-48 mt-2">
              <div class="progress-bar">
                <div 
                  class="progress-fill"
                  :style="{ width: progressValue + '%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <div class="max-w-2xl mx-auto">
        <div class="card animate-fade-in">
          <!-- Step 1: Account Information -->
          <AccountInformation
            v-if="currentStep === 1"
            @next="nextStep"
          />
          
          <!-- Step 2: Company Information -->
          <CompanyInformation
            v-if="currentStep === 2"
            @next="nextStep"
            @prev="prevStep"
          />
          
          <!-- Step 3: Registration Summary (only show if not submitted) -->
          <RegistrationSummary
            v-if="currentStep === 3 && !isSubmitted"
            @prev="prevStep"
            @submit="handleSubmit"
          />

          <!-- Confirmation Page (replaces Step 3 after successful submission) -->
          <RegistrationSuccess 
            v-if="isSubmitted"
            @close="resetRegistration"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useRegistrationStore } from '@/stores/registration'
import AccountInformation from './registration/AccountInformation.vue'
import CompanyInformation from './registration/CompanyInformation.vue'
import RegistrationSummary from './registration/RegistrationSummary.vue'
import RegistrationSuccess from './registration/RegistrationSuccess.vue'

const store = useRegistrationStore()

// Computed properties from store
const currentStep = computed(() => store.currentStep)
const progressValue = computed(() => store.progressValue)
const isSubmitted = computed(() => store.isSubmitted)

// Methods
const nextStep = () => {
  store.nextStep()
}

const prevStep = () => {
  store.prevStep()
}

const handleSubmit = async () => {
  const success = await store.submitRegistration()
  if (!success) {
    // Error handled in store
  }
}

const resetRegistration = () => {
  store.resetRegistration()
}

// Lifecycle
onMounted(() => {
  store.fetchCountries()
})
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>
