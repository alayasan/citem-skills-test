<template>
  <footer class="bg-gray-900 text-white py-16">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
        <!-- Brand -->
        <div class="col-span-1 md:col-span-2">
          <div class="mb-4">
            <!-- Manila FAME Logo Placeholder -->
            <div class="text-white text-xl font-bold border-2 border-white px-3 py-1 inline-block">
              MANILA FAME
            </div>
          </div>
          <p class="text-gray-300 mb-6 max-w-md leading-relaxed">
            The Philippines' premier trade show for design and craftsmanship. 
            Connecting international buyers with exceptional Filipino artisans and manufacturers.
          </p>
          <div class="flex gap-4">
            <a 
              href="#" 
              class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-600 transition-colors"
              @click.prevent="handleSocialClick('facebook')"
            >
              <Facebook :size="20" />
            </a>
            <a 
              href="#" 
              class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-600 transition-colors"
              @click.prevent="handleSocialClick('instagram')"
            >
              <Instagram :size="20" />
            </a>
            <a 
              href="#" 
              class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-600 transition-colors"
              @click.prevent="handleSocialClick('linkedin')"
            >
              <Linkedin :size="20" />
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="font-semibold mb-4">Quick Links</h4>
          <ul class="space-y-2 text-gray-300">
            <li>
              <a 
                href="#" 
                class="hover:text-yellow-400 transition-colors"
                @click.prevent="handleLinkClick('about')"
              >
                About Manila FAME
              </a>
            </li>
            <li>
              <a 
                href="#" 
                class="hover:text-yellow-400 transition-colors"
                @click.prevent="handleLinkClick('exhibitors')"
              >
                Exhibitor Directory
              </a>
            </li>
            <li>
              <a 
                href="#" 
                class="hover:text-yellow-400 transition-colors"
                @click.prevent="handleLinkClick('schedule')"
              >
                Event Schedule
              </a>
            </li>
            <li>
              <a 
                href="#" 
                class="hover:text-yellow-400 transition-colors"
                @click.prevent="handleLinkClick('visitor-info')"
              >
                Visitor Information
              </a>
            </li>
            <li>
              <a 
                href="#" 
                class="hover:text-yellow-400 transition-colors"
                @click.prevent="handleLinkClick('past-events')"
              >
                Past Events
              </a>
            </li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h4 class="font-semibold mb-4">Contact Info</h4>
          <div class="space-y-3 text-gray-300">
            <div class="flex items-start gap-3">
              <MapPin :size="20" class="text-yellow-400 mt-0.5" />
              <div>
                <div>World Trade Center</div>
                <div>Manila, Philippines</div>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <Phone :size="20" class="text-yellow-400" />
              <div>+63 2 8831 2345</div>
            </div>
            <div class="flex items-center gap-3">
              <Mail :size="20" class="text-yellow-400" />
              <div>info@manilafame.com</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="text-gray-400 text-sm text-center md:text-left">
          © 2024 Manila FAME. All rights reserved. Organized by Center for International Trade Expositions and Missions (CITEM).
        </div>
        <div class="flex gap-6 text-sm text-gray-400">
          <a 
            href="#" 
            class="hover:text-yellow-400 transition-colors"
            @click.prevent="handleLinkClick('privacy')"
          >
            Privacy Policy
          </a>
          <a 
            href="#" 
            class="hover:text-yellow-400 transition-colors"
            @click.prevent="handleLinkClick('terms')"
          >
            Terms of Service
          </a>
          <a 
            href="#" 
            class="hover:text-yellow-400 transition-colors"
            @click.prevent="handleLinkClick('sitemap')"
          >
            Sitemap
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import { Facebook, Instagram, Linkedin, Mail, Phone, MapPin } from 'lucide-vue-next'

const handleSocialClick = (platform: string) => {
  // This would typically navigate to the actual social media pages
  console.log(`Navigate to ${platform} page`)
  // Example URLs:
  // if (platform === 'facebook') window.open('https://facebook.com/manilafame', '_blank')
  // if (platform === 'instagram') window.open('https://instagram.com/manilafame', '_blank')
  // if (platform === 'linkedin') window.open('https://linkedin.com/company/manilafame', '_blank')
}

const handleLinkClick = (section: string) => {
  // This would typically navigate to different pages or sections
  console.log(`Navigate to ${section} section`)
  // You could implement router navigation here:
  // router.push(`/${section}`)
}
</script>
