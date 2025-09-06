<template>
  <div>
    <!-- Hero Section -->
    <HeroSection />
    
    <!-- Why Visit Section -->
    <WhyVisitSection />
    
    <!-- Featured Products Section -->
    <FeaturedProducts />
    
    <!-- Event Categories Section -->
    <EventCategories />
    
    <!-- Testimonials Section -->
    <Testimonials />
    
    <!-- Registration CTA Section -->
    <RegistrationCTA />
    
    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup lang="ts">
import HeroSection from '../components/HeroSection.vue'
import WhyVisitSection from '../components/WhyVisitSection.vue'
import FeaturedProducts from '../components/FeaturedProducts.vue'
import EventCategories from '../components/EventCategories.vue'
import Testimonials from '../components/Testimonials.vue'
import RegistrationCTA from '../components/RegistrationCTA.vue'
import Footer from '../components/Footer.vue'
</script>
