import { describe, it, expect, beforeEach, afterEach } from 'vitest'
import { mount } from '@vue/test-utils'
import AccountInformation from '../../../src/components/registration/AccountInformation.vue'

describe('AccountInformation Component', () => {
  let wrapper: any

  const defaultProps = {
    modelValue: {
      firstName: '',
      lastName: '',
      email: '',
      username: '',
      password: '',
      passwordConfirmation: '',
      participationType: '' as const,
      companyName: '',
      addressLine: '',
      townCity: '',
      regionState: '',
      country: '',
      yearEstablished: '',
      website: '',
      brochure: null
    },
    loading: false
  }

  beforeEach(() => {
    wrapper = mount(AccountInformation, {
      props: defaultProps
    })
  })

  afterEach(() => {
    wrapper?.unmount()
  })

  it('renders the component title', () => {
    expect(wrapper.find('h2').text()).toBe('Account Information')
  })

  it('renders all form fields', () => {
    expect(wrapper.find('#firstName').exists()).toBe(true)
    expect(wrapper.find('#lastName').exists()).toBe(true)
    expect(wrapper.find('#email').exists()).toBe(true)
    expect(wrapper.find('#username').exists()).toBe(true)
    expect(wrapper.find('#password').exists()).toBe(true)
    expect(wrapper.find('#passwordConfirmation').exists()).toBe(true)
    expect(wrapper.find('#participationType').exists()).toBe(true)
  })

  it('has correct input types', () => {
    expect(wrapper.find('#email').attributes('type')).toBe('email')
    expect(wrapper.find('#password').attributes('type')).toBe('password')
    expect(wrapper.find('#passwordConfirmation').attributes('type')).toBe('password')
  })

  it('shows participation type options', () => {
    const select = wrapper.find('#participationType')
    const options = select.findAll('option')

    expect(options.length).toBeGreaterThan(3)
    expect(options.some((opt: any) => opt.text() === 'Buyer')).toBe(true)
    expect(options.some((opt: any) => opt.text() === 'Exhibitor')).toBe(true)
    expect(options.some((opt: any) => opt.text() === 'Visitor')).toBe(true)
  })

  it('shows loading state on submit button', async () => {
    await wrapper.setProps({ ...defaultProps, loading: true })

    const button = wrapper.find('button[type="submit"]')
    expect(button.text()).toContain('Creating Account...')
  })

  it('shows normal state on submit button when not loading', () => {
    const button = wrapper.find('button[type="submit"]')
    expect(button.text()).toContain('Next Step')
  })
})
