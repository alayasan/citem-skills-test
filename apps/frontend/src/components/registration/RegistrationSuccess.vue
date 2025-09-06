<template>
  <div class="text-center p-6">
    <!-- Success Icon -->
    <div class="mb-6">
      <svg class="mx-auto h-20 w-20 text-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
        <polyline points="22,4 12,14.01 9,11.01"/>
      </svg>
    </div>

    <!-- Manila FAME Logo -->
    <div class="mb-6">
      <div class="flex items-center justify-center">
        <div class="w-12 h-12 bg-amber-600 rounded flex items-center justify-center text-white font-bold text-lg">
          MF
        </div>
      </div>
    </div>

    <!-- Success Message -->
    <div class="mb-8">
      <h1 class="text-3xl mb-4 font-semibold">Registration Successful!</h1>
      <p class="text-gray-600 text-lg">
        Thank you for registering for Manila FAME 2025. Your registration has been submitted successfully.
      </p>
    </div>

            <!-- Registration Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
              <h3 class="text-lg mb-4 font-semibold">What's Next?</h3>
              <div class="space-y-4">
                <div class="flex items-start gap-3">
                  <svg class="h-5 w-5 text-blue-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                  </svg>
                  <div>
                    <div class="font-medium">Confirmation Email</div>
                    <div class="text-sm text-gray-600">
                      You will receive a confirmation email with your registration details and QR code within 24 hours.
                    </div>
                  </div>
                </div>
                
                <div class="flex items-start gap-3">
                  <svg class="h-5 w-5 text-green-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                  </svg>
                  <div>
                    <div class="font-medium">Event Schedule</div>
                    <div class="text-sm text-gray-600">
                      Detailed event schedule and exhibitor information will be sent closer to the event date.
                    </div>
                  </div>
                </div>
                
                <div class="flex items-start gap-3">
                  <svg class="h-5 w-5 text-yellow-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                  </svg>
                  <div>
                    <div class="font-medium">Venue Information</div>
                    <div class="text-sm text-gray-600">
                      World Trade Center, Manila, Philippines<br />
                      Detailed directions and parking information will be provided.
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Important Information -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8 text-left">
              <h4 class="font-medium mb-2">Important Information</h4>
              <ul class="text-sm text-gray-700 space-y-1">
                <li>• Please bring a valid ID and your registration confirmation to the event</li>
                <li>• Registration is free for qualified trade buyers</li>
                <li>• For any questions, contact us at info@manilafame.com</li>
                <li>• Event updates will be sent to your registered email address</li>
              </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
              <button
                @click="handleDownloadConfirmation"
                class="px-8 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 font-medium"
              >
                Download Confirmation
              </button>
              <button
                @click="handleReturnHome"
                class="bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-2 rounded-md font-medium transition-colors"
              >
                Return to Home
              </button>
            </div>

            <!-- Contact Information -->
            <div class="mt-8 pt-8 border-t border-gray-200">
              <div class="text-sm text-gray-600">
                Need help? Contact us at
                <a href="mailto:info@manilafame.com" class="text-blue-600 hover:text-blue-800 underline">
                  info@manilafame.com
                </a>
                or call
                <a href="tel:+6328831234" class="text-blue-600 hover:text-blue-800 underline">
                  +63 2 8831 2345
                </a>
              </div>
            </div>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'

const router = useRouter()

const handleReturnHome = () => {
  router.push('/')
}

const handleDownloadConfirmation = () => {
  // Mock download functionality
  alert('Confirmation PDF would be downloaded here')
}
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
