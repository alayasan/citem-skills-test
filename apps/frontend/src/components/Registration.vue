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
            <div class="text-sm text-gray-500 font-medium">Step {{ currentStep }} of 3</div>
            <div class="w-48 mt-2">
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
            v-model="registrationData"
            :loading="loading"
            @next="handleUserRegistration"
          />
          
          <!-- Step 2: Company Information -->
          <CompanyInformation
            v-if="currentStep === 2"
            v-model="registrationData"
            :loading="loading"
            :countries="countries"
            @next="handleCompanyRegistration"
            @prev="prevStep"
          />
          
          <!-- Step 3: Registration Summary -->
          <RegistrationSummary
            v-if="currentStep === 3"
            :data="registrationData"
            :loading="loading"
            @prev="prevStep"
            @submit="handleSubmit"
          />
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <RegistrationSuccess 
      v-if="isSubmitted"
      :data="registrationData"
      @close="resetRegistration"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import AccountInformation from './registration/AccountInformation.vue'
import CompanyInformation from './registration/CompanyInformation.vue'
import RegistrationSummary from './registration/RegistrationSummary.vue'
import RegistrationSuccess from './registration/RegistrationSuccess.vue'

export interface RegistrationData {
  // Step 1: Account Information
  firstName: string
  lastName: string
  email: string
  username: string
  password: string
  passwordConfirmation: string
  participationType: 'Buyer' | 'Seller' | 'Exhibitor' | 'Visitor' | ''
  
  // Step 2: Company Information
  companyName: string
  addressLine: string
  townCity: string
  regionState: string
  country: string
  yearEstablished: number | ''
  website: string
  companyBrochure: File | null
}

const initialData: RegistrationData = {
  firstName: '',
  lastName: '',
  email: '',
  username: '',
  password: '',
  passwordConfirmation: '',
  participationType: '',
  companyName: '',
  addressLine: '',
  townCity: '',
  regionState: '',
  country: '',
  yearEstablished: '',
  website: '',
  companyBrochure: null,
}

// Reactive state
const currentStep = ref(1)
const registrationData = ref<RegistrationData>({ ...initialData })
const isSubmitted = ref(false)
const loading = ref(false)
const countries = ref<Array<{ name: string; official: string }>>([])

// Computed
const progressValue = computed(() => {
  return (currentStep.value / 3) * 100
})

// Methods
const nextStep = () => {
  if (currentStep.value < 3) {
    currentStep.value++
  }
}

const prevStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}

const fetchCountries = async () => {
  try {
    const response = await fetch('http://localhost:8001/api/countries')
    const result = await response.json()
    if (result.success) {
      countries.value = result.data
    }
  } catch (error) {
    console.error('Failed to fetch countries:', error)
  }
}

// Comprehensive registration submission (follows requirements for single API call)
const handleSubmit = async () => {
  loading.value = true
  try {
    // Create FormData to handle file upload
    const formData = new FormData()
    
    // Add all user data
    formData.append('first_name', registrationData.value.firstName)
    formData.append('last_name', registrationData.value.lastName)
    formData.append('email', registrationData.value.email)
    formData.append('username', registrationData.value.username)
    formData.append('password', registrationData.value.password)
    formData.append('password_confirmation', registrationData.value.passwordConfirmation)
    formData.append('participation_type', registrationData.value.participationType)
    
    // Add all company data
    formData.append('company_name', registrationData.value.companyName)
    formData.append('address_line', registrationData.value.addressLine)
    formData.append('town_city', registrationData.value.townCity)
    formData.append('region_state', registrationData.value.regionState)
    formData.append('country', registrationData.value.country)
    formData.append('year_established', registrationData.value.yearEstablished?.toString() || '')
    formData.append('website', registrationData.value.website || '')
    
    // Add brochure file if present
    if (registrationData.value.companyBrochure) {
      formData.append('brochure', registrationData.value.companyBrochure)
    }

    // Single comprehensive API call as per requirements
    const response = await fetch('http://localhost:8001/api/register', {
      method: 'POST',
      body: formData
    })

    const result = await response.json()
    if (result.success) {
      isSubmitted.value = true
    } else {
      throw new Error(result.message || 'Registration failed')
    }
  } catch (error) {
    console.error('Registration failed:', error)
    alert('Registration failed. Please try again.')
  } finally {
    loading.value = false
  }
}

const resetRegistration = () => {
  currentStep.value = 1
  registrationData.value = { ...initialData }
  isSubmitted.value = false
}

// Handle step 1 completion (client-side validation only)
const handleUserRegistration = async (userData: any) => {
  // Store data and proceed to next step (no server call until final submission)
  Object.assign(registrationData.value, userData)
  nextStep()
}

// Handle step 2 completion (client-side validation only)
const handleCompanyRegistration = async (companyData: any) => {
  // Store data and proceed to next step (no server call until final submission)
  Object.assign(registrationData.value, companyData)
  nextStep()
}

// Lifecycle
onMounted(() => {
  fetchCountries()
})
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>
