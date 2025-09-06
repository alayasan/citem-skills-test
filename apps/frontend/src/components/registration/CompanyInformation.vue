<template>
  <div>
    <div class="mb-8">
      <h2 class="text-2xl mb-2">Company Information</h2>
      <p class="text-gray-600">Please provide details about your company or organization.</p>
    </div>

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <!-- Company Name -->
      <div>
        <label for="companyName" class="block text-sm font-medium text-gray-900 mb-1">
          Company Name *
        </label>
        <input
          id="companyName"
          v-model="registrationData.companyName"
          type="text"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.companyName }"
        />
        <p v-if="errors.companyName" class="text-red-500 text-sm mt-1">{{ errors.companyName }}</p>
      </div>

      <!-- Address Line -->
      <div>
        <label for="addressLine" class="block text-sm font-medium text-gray-900 mb-1">
          Address Line *
        </label>
        <input
          id="addressLine"
          v-model="registrationData.addressLine"
          type="text"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.addressLine }"
        />
        <p v-if="errors.addressLine" class="text-red-500 text-sm mt-1">{{ errors.addressLine }}</p>
      </div>

      <!-- Country -->
      <div>
        <label for="country" class="block text-sm font-medium text-gray-900 mb-1">
          Country *
        </label>
        <select
          id="country"
          v-model="registrationData.country"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.country }"
          @change="onCountryChange"
        >
          <option value="">Select a country</option>
          <option
            v-for="country in countries"
            :key="country.name"
            :value="country.name"
          >
            {{ country.name }}
          </option>
        </select>
        <p v-if="errors.country" class="text-red-500 text-sm mt-1">{{ errors.country }}</p>
      </div>

      <!-- Town/City and Region/State -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="regionState" class="block text-sm font-medium text-gray-900 mb-1">
            Region/State *
          </label>
          <div class="relative">
            <select
              id="regionState"
              v-model="registrationData.regionState"
              required
              :disabled="!registrationData.country || loadingStates"
              class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              :class="{ 'border-red-500': errors.regionState }"
              @change="onStateChange"
            >
              <option value="">
                {{ loadingStates ? 'Loading states...' : 'Select a state/region' }}
              </option>
              <option
                v-for="state in states"
                :key="state.name"
                :value="state.name"
              >
                {{ state.name }}
              </option>
            </select>
            <div v-if="loadingStates" class="absolute right-3 top-1/2 transform -translate-y-1/2">
              <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
            </div>
          </div>
          <p v-if="errors.regionState" class="text-red-500 text-sm mt-1">{{ errors.regionState }}</p>
        </div>

        <div>
          <label for="townCity" class="block text-sm font-medium text-gray-900 mb-1">
            Town/City *
          </label>
          <div class="relative">
            <select
              id="townCity"
              v-model="registrationData.townCity"
              required
              :disabled="!registrationData.regionState || loadingCities"
              class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
              :class="{ 'border-red-500': errors.townCity }"
            >
              <option value="">
                {{ loadingCities ? 'Loading cities...' : 'Select a city' }}
              </option>
              <option
                v-for="city in cities"
                :key="city"
                :value="city"
              >
                {{ city }}
              </option>
            </select>
            <div v-if="loadingCities" class="absolute right-3 top-1/2 transform -translate-y-1/2">
              <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
            </div>
          </div>
          <p v-if="errors.townCity" class="text-red-500 text-sm mt-1">{{ errors.townCity }}</p>
          <p v-if="citiesSource" class="text-xs text-gray-500 mt-1">
            {{ citiesSource }}
          </p>
        </div>
      </div>

      <!-- Year Established -->
      <div>
        <label for="yearEstablished" class="block text-sm font-medium text-gray-900 mb-1">
          Year Established *
        </label>
        <input
          id="yearEstablished"
          v-model.number="registrationData.yearEstablished"
          type="number"
          required
          min="1800"
          :max="new Date().getFullYear()"
          step="1"
          maxlength="4"
          placeholder="e.g. 2010"
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.yearEstablished }"
          @input="validateYearInput"
        />
        <p v-if="errors.yearEstablished" class="text-red-500 text-sm mt-1">{{ errors.yearEstablished }}</p>
        <p class="text-gray-500 text-xs mt-1">Enter a 4-digit year (e.g., 2010). Cannot be in the future.</p>
      </div>

      <!-- Website (optional) -->
      <div>
        <label for="website" class="block text-sm font-medium text-gray-900 mb-1">
          Website
        </label>
        <input
          id="website"
          v-model="registrationData.website"
          type="url"
          placeholder="https://www.example.com"
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.website }"
        />
        <p v-if="errors.website" class="text-red-500 text-sm mt-1">{{ errors.website }}</p>
      </div>

      <!-- Company Brochure -->
      <div>
        <label for="companyBrochure" class="block text-sm font-medium text-gray-900 mb-1">
          Company Brochure
        </label>
        <div class="mt-2">
          <div v-if="!selectedFile" 
               @click="fileInput?.click()"
               @dragover.prevent
               @dragenter.prevent
               @drop.prevent="handleFileDrop"
               class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-gray-400 transition-colors"
               :class="{ 'border-blue-400 bg-blue-50': isDragOver }"
               @dragenter="isDragOver = true"
               @dragleave="isDragOver = false">
            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="7,10 12,15 17,10"/>
              <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            <div class="mt-4">
              <div class="text-sm text-gray-600">
                Click to upload or drag and drop
              </div>
              <div class="text-xs text-gray-500 mt-1">
                PDF, DOC, DOCX (max 2MB)
              </div>
            </div>
          </div>
          
          <div v-else class="border border-gray-300 rounded-lg p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <svg class="h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                <polyline points="14,2 14,8 20,8"/>
              </svg>
              <div>
                <div class="text-sm font-medium">{{ selectedFile.name }}</div>
                <div class="text-xs text-gray-500">
                  {{ (selectedFile.size / 1024 / 1024).toFixed(2) }} MB
                </div>
              </div>
            </div>
            <button
              type="button"
              @click="removeFile"
              class="text-red-500 hover:text-red-700">
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
              </svg>
            </button>
          </div>
        </div>
        <input
          ref="fileInput"
          type="file"
          accept=".pdf,.doc,.docx"
          @change="handleFileChange"
          class="hidden"
        />
        <p v-if="errors.companyBrochure" class="text-red-500 text-sm mt-1">{{ errors.companyBrochure }}</p>
        <p class="text-gray-500 text-xs mt-1">Optional: Upload a company brochure (PDF, DOC, DOCX, max 2MB)</p>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex justify-between pt-6">
        <button
          type="button"
          @click="$emit('prev')"
          class="px-8 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 font-medium"
        >
          Back
        </button>
        
        <button
          type="submit"
          :disabled="loading"
          class="bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-2 rounded-md disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-colors"
        >
          <span v-if="loading">Saving...</span>
          <span v-else>Next Step</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { useRegistrationStore } from '@/stores/registration'

interface Emits {
  (e: 'next'): void
  (e: 'prev'): void
}

const emit = defineEmits<Emits>()
const store = useRegistrationStore()

// Computed properties from store
const registrationData = computed(() => store.registrationData)
const countries = computed(() => store.countries)
const cities = computed(() => store.cities)
const states = computed(() => store.states)
const citiesSource = computed(() => store.citiesSource)
const loadingCities = computed(() => store.loadingCities)
const loadingStates = computed(() => store.loadingStates)
const loading = computed(() => store.loading)

// Local reactive state
const errors = ref<Record<string, string>>({})
const fileInput = ref<HTMLInputElement>()
const selectedFile = ref<File | null>(registrationData.value.companyBrochure)
const isDragOver = ref(false)

// Watch for file changes in store
watch(() => registrationData.value.companyBrochure, (newFile) => {
  selectedFile.value = newFile
})

// Watch for country changes to fetch states
watch(() => registrationData.value.country, (newCountry) => {
  if (newCountry) {
    // Clear dependent fields
    store.updateCompanyData({ 
      regionState: '', 
      townCity: '' 
    })
    // Fetch states for the new country
    store.fetchStates(newCountry)
  }
})

// Watch for state changes to fetch cities
watch(() => registrationData.value.regionState, (newState) => {
  if (newState && registrationData.value.country) {
    // Clear dependent fields
    store.updateCompanyData({ townCity: '' })
    // Fetch cities for the new state
    store.fetchCitiesByState(registrationData.value.country, newState)
  }
})

const onCountryChange = () => {
  if (registrationData.value.country) {
    store.fetchStates(registrationData.value.country)
  }
}

const onStateChange = () => {
  if (registrationData.value.regionState && registrationData.value.country) {
    store.fetchCitiesByState(registrationData.value.country, registrationData.value.regionState)
  }
}

const validateYearInput = (event: Event) => {
  const target = event.target as HTMLInputElement
  const value = target.value
  
  // Remove any non-digit characters and limit to 4 digits
  const numericValue = value.replace(/\D/g, '').slice(0, 4)
  
  // Update the input value to only contain the cleaned numeric value
  target.value = numericValue
  
  // Update the model value
  if (numericValue) {
    registrationData.value.yearEstablished = parseInt(numericValue, 10)
  } else {
    registrationData.value.yearEstablished = ''
  }
}

const validateFileUpload = (file: File): string | null => {
  // Validate file type by MIME type and extension
  const allowedMimeTypes = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
  ]
  
  const allowedExtensions = ['.pdf', '.doc', '.docx']
  const fileExtension = file.name.toLowerCase().substring(file.name.lastIndexOf('.'))
  
  if (!allowedMimeTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
    return 'Please select a PDF, DOC, or DOCX file'
  }
  
  // Validate file size (2MB)
  if (file.size > 2 * 1024 * 1024) {
    return 'File size must be less than 2MB'
  }
  
  return null
}

const validateForm = () => {
  errors.value = {}

  if (!registrationData.value.companyName.trim()) {
    errors.value.companyName = 'Company name is required'
  }

  if (!registrationData.value.addressLine.trim()) {
    errors.value.addressLine = 'Address is required'
  }

  if (!registrationData.value.townCity.trim()) {
    errors.value.townCity = 'Town/City is required'
  }

  if (!registrationData.value.regionState.trim()) {
    errors.value.regionState = 'Region/State is required'
  }

  if (!registrationData.value.country) {
    errors.value.country = 'Please select a country'
  }

  if (!registrationData.value.yearEstablished) {
    errors.value.yearEstablished = 'Year established is required'
  } else {
    const year = registrationData.value.yearEstablished
    const currentYear = new Date().getFullYear()
    
    // Check if it's a 4-digit number
    if (!/^\d{4}$/.test(year.toString())) {
      errors.value.yearEstablished = 'Year must be exactly 4 digits'
    } else if (year < 1800) {
      errors.value.yearEstablished = 'Year must be 1800 or later'
    } else if (year > currentYear) {
      errors.value.yearEstablished = 'Year cannot be in the future'
    }
  }

  if (registrationData.value.website && !/^https?:\/\/.+/.test(registrationData.value.website)) {
    errors.value.website = 'Please enter a valid website URL'
  }

  return Object.keys(errors.value).length === 0
}

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  
  if (file) {
    const validationError = validateFileUpload(file)
    if (validationError) {
      errors.value.companyBrochure = validationError
      target.value = ''
      return
    }
    
    selectedFile.value = file
    store.updateCompanyData({ companyBrochure: file })
    delete errors.value.companyBrochure
  }
}

const removeFile = () => {
  selectedFile.value = null
  store.updateCompanyData({ companyBrochure: null })
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const handleFileDrop = (event: DragEvent) => {
  isDragOver.value = false
  const files = event.dataTransfer?.files
  if (files && files.length > 0) {
    const file = files[0]
    
    const validationError = validateFileUpload(file)
    if (validationError) {
      errors.value.companyBrochure = validationError
      return
    }
    
    selectedFile.value = file
    store.updateCompanyData({ companyBrochure: file })
    delete errors.value.companyBrochure
  }
}

const handleSubmit = async () => {
  if (!validateForm()) {
    return
  }

  emit('next')
}
</script>
