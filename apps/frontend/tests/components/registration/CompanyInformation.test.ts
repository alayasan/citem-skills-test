import { describe, it, expect, beforeEach, afterEach } from 'vitest'
import { mount } from '@vue/test-utils'
import CompanyInformation from '../../../src/components/registration/CompanyInformation.vue'

// Define the interface locally to avoid import issues
interface RegistrationData {
  firstName: string
  lastName: string
  email: string
  username: string
  password: string
  passwordConfirmation: string
  participationType: 'Buyer' | 'Seller' | 'Exhibitor' | 'Visitor' | 'sponsor' | ''
  companyName: string
  addressLine: string
  townCity: string
  regionState: string
  country: string
  yearEstablished: number | ''
  website: string
  companyBrochure: File | null
  avatar?: File | null
}

describe('CompanyInformation Component', () => {
  let wrapper: any

  const mockRegistrationData: RegistrationData = {
    firstName: 'John',
    lastName: 'Doe',
    email: 'john@example.com',
    username: 'johndoe',
    password: 'password123',
    passwordConfirmation: 'password123',
    participationType: 'sponsor',
    companyName: 'Acme Corp',
    addressLine: '123 Main Street',
    townCity: 'Manila',
    regionState: 'Metro Manila',
    country: 'Philippines',
    yearEstablished: 2020,
    website: 'https://acme.com',
    companyBrochure: null,
    avatar: null
  }

  const defaultProps = {
    modelValue: mockRegistrationData,
    loading: false,
    countries: [
      { name: 'Philippines', official: 'Republic of the Philippines' },
      { name: 'United States', official: 'United States of America' }
    ]
  }

  beforeEach(() => {
    wrapper = mount(CompanyInformation, {
      props: defaultProps
    })
  })

  afterEach(() => {
    wrapper?.unmount()
  })

  it('renders the component title', () => {
    expect(wrapper.find('h2').text()).toBe('Company Information')
  })

  it('renders all required form fields', () => {
    expect(wrapper.find('#companyName').exists()).toBe(true)
    expect(wrapper.find('#addressLine').exists()).toBe(true)
    expect(wrapper.find('#townCity').exists()).toBe(true)
    expect(wrapper.find('#regionState').exists()).toBe(true)
    expect(wrapper.find('#country').exists()).toBe(true)
    expect(wrapper.find('#yearEstablished').exists()).toBe(true)
    expect(wrapper.find('#website').exists()).toBe(true)
  })

  it('shows loading state on submit button', () => {
    const loadingWrapper = mount(CompanyInformation, {
      props: {
        ...defaultProps,
        loading: true
      }
    })

    const submitButton = loadingWrapper.find('button[type="submit"]')
    expect(submitButton.text()).toContain('Saving...')
    expect(submitButton.attributes('disabled')).toBeDefined()
  })

  it('shows normal state on submit button when not loading', () => {
    const submitButton = wrapper.find('button[type="submit"]')
    expect(submitButton.text()).toContain('Next Step')
    expect(submitButton.attributes('disabled')).toBeUndefined()
  })

  it('populates country dropdown with provided countries', () => {
    const countrySelect = wrapper.find('#country')
    const options = countrySelect.findAll('option')

    // Should have placeholder + 2 countries
    expect(options).toHaveLength(3)
    expect(options[1].text()).toBe('Philippines')
    expect(options[2].text()).toBe('United States')
  })

  it('validates website URL format', () => {
    const websiteInput = wrapper.find('#website')
    expect(websiteInput.attributes('type')).toBe('url')
  })

  it('emits next event when form is submitted', async () => {
    const form = wrapper.find('form')
    await form.trigger('submit.prevent')

    expect(wrapper.emitted('next')).toBeTruthy()
  })

  it('emits prev event when back button is clicked', async () => {
    const backButton = wrapper.find('button:not([type="submit"])')
    await backButton.trigger('click')

    expect(wrapper.emitted('prev')).toBeTruthy()
  })
})
