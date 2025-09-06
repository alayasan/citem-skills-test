export interface RegistrationData {
  // Step 1: Account Information
  firstName: string
  lastName: string
  email: string
  username: string
  password: string
  passwordConfirmation: string
  participationType: 'Buyer' | 'Seller' | 'Exhibitor' | 'Visitor' | 'sponsor' | ''

  // Step 2: Company Information
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

export interface Country {
  name: string
  official: string
}

export interface ValidationErrors {
  [key: string]: string
}
