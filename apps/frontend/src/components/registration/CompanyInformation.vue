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
          v-model="formData.companyName"
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
          v-model="formData.addressLine"
          type="text"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.addressLine }"
        />
        <p v-if="errors.addressLine" class="text-red-500 text-sm mt-1">{{ errors.addressLine }}</p>
      </div>

      <!-- Town/City and Region/State -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="townCity" class="block text-sm font-medium text-gray-900 mb-1">
            Town/City *
          </label>
          <input
            id="townCity"
            v-model="formData.townCity"
            type="text"
            required
            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            :class="{ 'border-red-500': errors.townCity }"
          />
          <p v-if="errors.townCity" class="text-red-500 text-sm mt-1">{{ errors.townCity }}</p>
        </div>

        <div>
          <label for="regionState" class="block text-sm font-medium text-gray-900 mb-1">
            Region/State *
          </label>
          <input
            id="regionState"
            v-model="formData.regionState"
            type="text"
            required
            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            :class="{ 'border-red-500': errors.regionState }"
          />
          <p v-if="errors.regionState" class="text-red-500 text-sm mt-1">{{ errors.regionState }}</p>
        </div>
      </div>

      <!-- Country -->
      <div>
        <label for="country" class="block text-sm font-medium text-gray-900 mb-1">
          Country *
        </label>
        <select
          id="country"
          v-model="formData.country"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.country }"
        >
          <option value="">Select a country</option>
          <option v-for="country in countries" :key="country.name" :value="country.name">
            {{ country.name }}
          </option>
        </select>
        <p v-if="errors.country" class="text-red-500 text-sm mt-1">{{ errors.country }}</p>
      </div>

      <!-- Year Established -->
      <div>
        <label for="yearEstablished" class="block text-sm font-medium text-gray-900 mb-1">
          Year Established *
        </label>
        <input
          id="yearEstablished"
          v-model.number="formData.yearEstablished"
          type="number"
          :min="1800"
          :max="new Date().getFullYear()"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.yearEstablished }"
        />
        <p v-if="errors.yearEstablished" class="text-red-500 text-sm mt-1">{{ errors.yearEstablished }}</p>
      </div>

      <!-- Website -->
      <div>
        <label for="website" class="block text-sm font-medium text-gray-900 mb-1">
          Website
        </label>
        <input
          id="website"
          v-model="formData.website"
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
               class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-gray-400 transition-colors">
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
import { ref, reactive } from 'vue'
import type { RegistrationData } from '../Registration.vue'

interface Props {
  modelValue: RegistrationData
  loading: boolean
  countries: Array<{ name: string; official: string }>
}

interface Emits {
  (e: 'next', data: typeof formData): void
  (e: 'prev'): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emits>()

const formData = reactive({
  companyName: props.modelValue.companyName,
  addressLine: props.modelValue.addressLine,
  townCity: props.modelValue.townCity,
  regionState: props.modelValue.regionState,
  country: props.modelValue.country,
  yearEstablished: props.modelValue.yearEstablished,
  website: props.modelValue.website,
  companyBrochure: props.modelValue.companyBrochure,
})

const errors = ref<Record<string, string>>({})
const fileInput = ref<HTMLInputElement>()
const selectedFile = ref<File | null>(props.modelValue.companyBrochure)

const validateForm = () => {
  errors.value = {}

  if (!formData.companyName.trim()) {
    errors.value.companyName = 'Company name is required'
  }

  if (!formData.addressLine.trim()) {
    errors.value.addressLine = 'Address is required'
  }

  if (!formData.townCity.trim()) {
    errors.value.townCity = 'Town/City is required'
  }

  if (!formData.regionState.trim()) {
    errors.value.regionState = 'Region/State is required'
  }

  if (!formData.country) {
    errors.value.country = 'Please select a country'
  }

  if (!formData.yearEstablished) {
    errors.value.yearEstablished = 'Year established is required'
  } else if (formData.yearEstablished < 1800 || formData.yearEstablished > new Date().getFullYear()) {
    errors.value.yearEstablished = 'Please enter a valid year'
  }

  if (formData.website && !/^https?:\/\/.+/.test(formData.website)) {
    errors.value.website = 'Please enter a valid website URL'
  }

  return Object.keys(errors.value).length === 0
}

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  
  if (file) {
    // Validate file type
    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
    if (!allowedTypes.includes(file.type)) {
      errors.value.companyBrochure = 'Please select a PDF, DOC, or DOCX file'
      target.value = ''
      return
    }
    
    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
      errors.value.companyBrochure = 'File size must be less than 2MB'
      target.value = ''
      return
    }
    
    selectedFile.value = file
    formData.companyBrochure = file
    delete errors.value.companyBrochure
  }
}

const removeFile = () => {
  selectedFile.value = null
  formData.companyBrochure = null
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const handleSubmit = async () => {
  if (!validateForm()) {
    return
  }

  emit('next', formData)
}
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
