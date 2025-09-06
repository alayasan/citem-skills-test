<template>
  <div>
    <div class="mb-8">
      <h2 class="text-2xl mb-2">Account Information</h2>
      <p class="text-gray-600">Please provide your personal details and create your account credentials.</p>
    </div>

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <!-- Name Fields -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="firstName" class="block text-sm font-medium text-gray-900 mb-1">
            First Name *
          </label>
          <input
            id="firstName"
            v-model="formData.firstName"
            type="text"
            required
            class="input-field"
            :class="{ 'input-error': errors.firstName }"
          />
          <p v-if="errors.firstName" class="text-red-500 text-sm mt-1">{{ errors.firstName }}</p>
        </div>

        <div>
          <label for="lastName" class="block text-sm font-medium text-gray-900 mb-1">
            Last Name *
          </label>
          <input
            id="lastName"
            v-model="formData.lastName"
            type="text"
            required
            class="input-field"
            :class="{ 'input-error': errors.lastName }"
          />
          <p v-if="errors.lastName" class="text-red-500 text-sm mt-1">{{ errors.lastName }}</p>
        </div>
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-900 mb-1">
          Email Address *
        </label>
        <input
          id="email"
          v-model="formData.email"
          type="email"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.email }"
        />
        <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
      </div>

      <!-- Username -->
      <div>
        <label for="username" class="block text-sm font-medium text-gray-900 mb-1">
          Username *
        </label>
        <input
          id="username"
          v-model="formData.username"
          type="text"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.username }"
        />
        <p v-if="errors.username" class="text-red-500 text-sm mt-1">{{ errors.username }}</p>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-900 mb-1">
          Password *
        </label>
        <div class="relative">
          <input
            id="password"
            v-model="formData.password"
            :type="showPassword ? 'text' : 'password'"
            required
            minlength="8"
            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 pr-10 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            :class="{ 'border-red-500': errors.password }"
          />
          <button
            type="button"
            @click="showPassword = !showPassword"
            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
          >
            <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
              <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
        <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
      </div>

      <!-- Password Confirmation -->
      <div>
        <label for="passwordConfirmation" class="block text-sm font-medium text-gray-900 mb-1">
          Confirm Password *
        </label>
        <div class="relative">
          <input
            id="passwordConfirmation"
            v-model="formData.passwordConfirmation"
            :type="showConfirmPassword ? 'text' : 'password'"
            required
            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 pr-10 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            :class="{ 'border-red-500': errors.passwordConfirmation }"
          />
          <button
            type="button"
            @click="showConfirmPassword = !showConfirmPassword"
            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
          >
            <svg v-if="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
              <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
        <p v-if="errors.passwordConfirmation" class="text-red-500 text-sm mt-1">{{ errors.passwordConfirmation }}</p>
      </div>

      <!-- Type of Participation -->
      <div>
        <label for="participationType" class="block text-sm font-medium text-gray-900 mb-1">
          Type of Participation *
        </label>
        <select
          id="participationType"
          v-model="formData.participationType"
          required
          class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          :class="{ 'border-red-500': errors.participationType }"
        >
          <option value="">Select participation type</option>
          <option value="Buyer">Buyer</option>
          <option value="Exhibitor">Exhibitor</option>
          <option value="Visitor">Visitor</option>
        </select>
        <p v-if="errors.participationType" class="text-red-500 text-sm mt-1">{{ errors.participationType }}</p>
      </div>

      <!-- Next Button -->
      <div class="flex justify-end pt-6">
        <button
          type="submit"
          :disabled="loading"
          class="bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-2 rounded-md disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-colors"
        >
          <span v-if="loading">Creating Account...</span>
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
}

interface Emits {
  (e: 'next', data: typeof formData): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emits>()

const formData = reactive({
  firstName: props.modelValue.firstName,
  lastName: props.modelValue.lastName,
  email: props.modelValue.email,
  username: props.modelValue.username,
  password: props.modelValue.password,
  passwordConfirmation: props.modelValue.passwordConfirmation,
  participationType: props.modelValue.participationType,
})

const errors = ref<Record<string, string>>({})
const showPassword = ref(false)
const showConfirmPassword = ref(false)

const validateForm = () => {
  errors.value = {}

  if (!formData.firstName.trim()) {
    errors.value.firstName = 'First name is required'
  }

  if (!formData.lastName.trim()) {
    errors.value.lastName = 'Last name is required'
  }

  if (!formData.email.trim()) {
    errors.value.email = 'Email is required'
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
    errors.value.email = 'Please enter a valid email address'
  }

  if (!formData.username.trim()) {
    errors.value.username = 'Username is required'
  } else if (formData.username.length < 3) {
    errors.value.username = 'Username must be at least 3 characters'
  }

  if (!formData.password) {
    errors.value.password = 'Password is required'
  } else if (formData.password.length < 8) {
    errors.value.password = 'Password must be at least 8 characters'
  }

  if (!formData.passwordConfirmation) {
    errors.value.passwordConfirmation = 'Password confirmation is required'
  } else if (formData.password !== formData.passwordConfirmation) {
    errors.value.passwordConfirmation = 'Passwords do not match'
  }

  if (!formData.participationType) {
    errors.value.participationType = 'Please select a participation type'
  }

  return Object.keys(errors.value).length === 0
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
