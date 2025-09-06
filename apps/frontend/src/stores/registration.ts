import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

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

export const useRegistrationStore = defineStore('registration', () => {
  // State
  const currentStep = ref(1)
  const registrationData = ref<RegistrationData>({ ...initialData })
  const isSubmitted = ref(false)
  const loading = ref(false)

  // Countries/Cities/States data
  const countries = ref<Array<{ name: string; official: string; cities: string[]; iso2?: string; iso3?: string }>>([])
  const cities = ref<string[]>([])
  const states = ref<Array<{ name: string; state_code?: string }>>([])
  const citiesSource = ref<string>('')

  // Loading states
  const loadingCities = ref(false)
  const loadingStates = ref(false)

  // Caching
  const citiesCache = ref<Map<string, string[]>>(new Map())
  const statesCache = ref<Map<string, Array<{ name: string; state_code?: string }>>>(new Map())

  // Getters
  const progressValue = computed(() => {
    return (currentStep.value / 3) * 100
  })

  // Actions
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

  const updateAccountData = (data: Partial<RegistrationData>) => {
    Object.assign(registrationData.value, data)
  }

  const updateCompanyData = (data: Partial<RegistrationData>) => {
    Object.assign(registrationData.value, data)
  }

  const resetRegistration = () => {
    currentStep.value = 1
    registrationData.value = { ...initialData }
    isSubmitted.value = false
    cities.value = []
    states.value = []
    citiesSource.value = ''
  }

  // API Actions
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

  const fetchStates = async (country: string) => {
    // Check cache first
    if (statesCache.value.has(country)) {
      states.value = statesCache.value.get(country) || []
      return
    }

    loadingStates.value = true
    try {
      const response = await fetch(`http://localhost:8001/api/countries/${encodeURIComponent(country)}/states`)
      const result = await response.json()
      if (result.success) {
        states.value = result.data
        // Cache the result
        statesCache.value.set(country, result.data)
      } else {
        states.value = []
        // Cache empty result to avoid re-requesting
        statesCache.value.set(country, [])
      }
    } catch (error) {
      console.error('Failed to fetch states:', error)
      states.value = []
      // Cache empty result to avoid re-requesting
      statesCache.value.set(country, [])
    } finally {
      loadingStates.value = false
    }
  }

  const fetchCitiesByState = async (country: string, state: string) => {
    const cacheKey = `${country}-${state}`

    // Check cache first
    if (citiesCache.value.has(cacheKey)) {
      cities.value = citiesCache.value.get(cacheKey) || []
      return
    }

    loadingCities.value = true

    try {
      const url = `http://localhost:8001/api/countries/${encodeURIComponent(country)}/states/${encodeURIComponent(state)}/cities`

      const response = await fetch(url)
      const result = await response.json()

      if (result.success) {
        cities.value = result.data
        citiesSource.value = result.source || ''
        // Cache the result
        citiesCache.value.set(cacheKey, result.data)

        // Log helpful info for debugging
        if (result.note) {
          console.log('Info:', result.note)
        }
      } else {
        cities.value = []
        citiesSource.value = ''
        // Cache empty result to avoid re-requesting
        citiesCache.value.set(cacheKey, [])
      }
    } catch (error) {
      console.error('Failed to fetch cities by state:', error)
      cities.value = []
      citiesSource.value = ''
      // Cache empty result to avoid re-requesting
      citiesCache.value.set(cacheKey, [])
    } finally {
      loadingCities.value = false
    }
  }

  const submitRegistration = async () => {
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
        return true
      } else {
        throw new Error(result.message || 'Registration failed')
      }
    } catch (error) {
      console.error('Registration failed:', error)
      alert('Registration failed. Please try again.')
      return false
    } finally {
      loading.value = false
    }
  }

  return {
    // State
    currentStep,
    registrationData,
    isSubmitted,
    loading,
    countries,
    cities,
    states,
    citiesSource,
    loadingCities,
    loadingStates,

    // Getters
    progressValue,

    // Actions
    nextStep,
    prevStep,
    updateAccountData,
    updateCompanyData,
    resetRegistration,
    fetchCountries,
    fetchStates,
    fetchCitiesByState,
    submitRegistration
  }
})
