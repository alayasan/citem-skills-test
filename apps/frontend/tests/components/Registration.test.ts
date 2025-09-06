import { describe, it, expect, beforeEach, afterEach } from 'vitest'
import { mount } from '@vue/test-utils'
import Registration from '../../src/components/Registration.vue'

describe('Registration Component', () => {
  let wrapper: any

  beforeEach(() => {
    wrapper = mount(Registration)
  })

  afterEach(() => {
    wrapper?.unmount()
  })

  it('renders the registration header', () => {
    expect(wrapper.find('h1').text()).toBe('Event Registration')
    expect(wrapper.text()).toContain('Manila FAME 2025')
  })

  it('shows step progress', () => {
    expect(wrapper.text()).toContain('Step 1 of 3')
  })

  it('starts with account information step', () => {
    expect(wrapper.find('h2').text()).toBe('Account Information')
  })

  it('has Manila FAME logo', () => {
    const logo = wrapper.find('.bg-gradient-to-br')
    expect(logo.exists()).toBe(true)
    expect(logo.text()).toBe('MF')
  })

  it('has progress bar', () => {
    const progressBar = wrapper.find('.progress-bar')
    expect(progressBar.exists()).toBe(true)

    const progressFill = wrapper.find('.progress-fill')
    expect(progressFill.exists()).toBe(true)
  })
})
