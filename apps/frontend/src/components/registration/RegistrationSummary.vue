<template>
  <div>
    <div class="mb-8">
      <h2 class="text-2xl mb-2">Registration Summary</h2>
      <p class="text-gray-600">Please review your information before submitting your registration.</p>
    </div>

    <div class="space-y-6">
      <!-- Account Information Summary -->
      <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="p-6 pb-4">
          <h3 class="text-lg font-semibold flex items-center gap-2">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            Account Information
          </h3>
        </div>
        <div class="p-6 pt-0 space-y-3">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <div class="text-sm text-gray-500">Name</div>
              <div class="font-medium">{{ data.firstName }} {{ data.lastName }}</div>
            </div>
            <div>
              <div class="text-sm text-gray-500">Email</div>
              <div class="font-medium">{{ data.email }}</div>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <div class="text-sm text-gray-500">Username</div>
              <div class="font-medium">{{ data.username }}</div>
            </div>
            <div>
              <div class="text-sm text-gray-500">Participation Type</div>
              <div class="font-medium">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  {{ data.participationType }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Company Information Summary -->
      <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
        <div class="p-6 pb-4">
          <h3 class="text-lg font-semibold flex items-center gap-2">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 21h18"/>
              <path d="M5 21V7l8-4v18"/>
              <path d="M19 21V11l-6-4"/>
            </svg>
            Company Information
          </h3>
        </div>
        <div class="p-6 pt-0 space-y-3">
          <div>
            <div class="text-sm text-gray-500">Company Name</div>
            <div class="font-medium">{{ data.companyName }}</div>
          </div>
          <div>
            <div class="text-sm text-gray-500">Address</div>
            <div class="font-medium">
              {{ data.addressLine }}<br />
              {{ data.townCity }}, {{ data.regionState }}<br />
              {{ data.country }}
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <div class="text-sm text-gray-500">Year Established</div>
              <div class="font-medium">{{ data.yearEstablished }}</div>
            </div>
            <div v-if="data.website">
              <div class="text-sm text-gray-500">Website</div>
              <div class="font-medium">
                <a 
                  :href="data.website" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  class="text-blue-600 hover:text-blue-800 underline"
                >
                  {{ data.website }}
                </a>
              </div>
            </div>
          </div>
          <div v-if="data.companyBrochure">
            <div class="text-sm text-gray-500">Company Brochure</div>
            <div class="flex items-center gap-2 mt-1">
              <svg class="h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                <polyline points="14,2 14,8 20,8"/>
              </svg>
              <span class="font-medium">{{ data.companyBrochure.name }}</span>
              <span class="text-sm text-gray-500">
                ({{ (data.companyBrochure.size / 1024 / 1024).toFixed(2) }} MB)
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="h-px bg-gray-200"></div>

      <!-- Terms and Conditions -->
      <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
          <input 
            id="terms" 
            v-model="termsAccepted"
            type="checkbox" 
            class="mt-1"
            required
          />
          <label for="terms" class="text-sm text-gray-700">
            I agree to the
            <a href="#" class="text-blue-600 hover:text-blue-800 underline">
              Terms and Conditions
            </a>
            and
            <a href="#" class="text-blue-600 hover:text-blue-800 underline">
              Privacy Policy
            </a>
            of Manila FAME. I understand that my information will be used for event registration and communication purposes.
          </label>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex justify-between pt-6">
        <button
          type="button"
          @click="$emit('prev')"
          :disabled="loading"
          class="px-8 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed font-medium"
        >
          Back
        </button>
        <button
          type="button"
          @click="handleSubmit"
          :disabled="loading || !termsAccepted"
          class="bg-green-600 hover:bg-green-700 text-white px-8 py-2 rounded-md disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-colors"
        >
          <span v-if="loading" class="flex items-center gap-2">
            <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Submitting...
          </span>
          <span v-else>Submit Registration</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { RegistrationData } from '../Registration.vue'

interface Props {
  data: RegistrationData
  loading: boolean
}

interface Emits {
  (e: 'prev'): void
  (e: 'submit'): void
}

const { data, loading } = defineProps<Props>()
const emit = defineEmits<Emits>()

const termsAccepted = ref(false)

const handleSubmit = () => {
  if (termsAccepted.value) {
    emit('submit')
  }
}
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
