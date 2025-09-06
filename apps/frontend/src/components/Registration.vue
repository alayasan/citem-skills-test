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
const userId = ref<number | null>(null)

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

const handleSubmit = async () => {
  if (!userId.value) {
    console.error('No user ID found')
    return
  }

  loading.value = true
  try {
    // Step 3: Complete registration
    const response = await fetch('http://localhost:8001/api/registration/complete', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        user_id: userId.value
      })
    })

    const result = await response.json()
    if (result.success) {
      isSubmitted.value = true
    } else {
      throw new Error(result.message || 'Registration failed')
    }
  } catch (error) {
    console.error('Registration completion failed:', error)
    alert('Registration failed. Please try again.')
  } finally {
    loading.value = false
  }
}

const resetRegistration = () => {
  currentStep.value = 1
  registrationData.value = { ...initialData }
  isSubmitted.value = false
  userId.value = null
}

// Handle step 1 completion (user registration)
const handleUserRegistration = async (userData: any) => {
  loading.value = true
  try {
    const response = await fetch('http://localhost:8001/api/registration/user', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        first_name: userData.firstName,
        last_name: userData.lastName,
        email: userData.email,
        username: userData.username,
        password: userData.password,
        password_confirmation: userData.passwordConfirmation,
        participation_type: userData.participationType,
      })
    })

    const result = await response.json()
    if (result.success) {
      userId.value = result.user_id
      Object.assign(registrationData.value, userData)
      nextStep()
    } else {
      throw new Error(result.message || 'User registration failed')
    }
  } catch (error) {
    console.error('User registration failed:', error)
    alert('Registration failed. Please try again.')
  } finally {
    loading.value = false
  }
}

// Handle step 2 completion (company registration)
const handleCompanyRegistration = async (companyData: any) => {
  if (!userId.value) {
    console.error('No user ID found')
    return
  }

  loading.value = true
  try {
    const formData = new FormData()
    formData.append('user_id', userId.value.toString())
    formData.append('company_name', companyData.companyName || '')
    formData.append('address_line', companyData.addressLine || '')
    formData.append('town_city', companyData.townCity || '')
    formData.append('region_state', companyData.regionState || '')
    formData.append('country', companyData.country || '')
    formData.append('year_established', companyData.yearEstablished?.toString() || '')
    formData.append('website', companyData.website || '')
    
    if (companyData.companyBrochure) {
      formData.append('brochure', companyData.companyBrochure)
    }

    const response = await fetch('http://localhost:8001/api/registration/company', {
      method: 'POST',
      body: formData
    })

    const result = await response.json()
    if (result.success) {
      Object.assign(registrationData.value, companyData)
      nextStep()
    } else {
      throw new Error(result.message || 'Company registration failed')
    }
  } catch (error) {
    console.error('Company registration failed:', error)
    alert('Company registration failed. Please try again.')
  } finally {
    loading.value = false
  }
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
