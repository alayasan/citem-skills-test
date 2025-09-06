<template>
  <section class="hero">
    <!-- Background Image -->
    <div class="hero__background">
      <img 
        src="https://images.unsplash.com/photo-1654202420922-6c0171ceb24e?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=80&w=1080"
        alt="Filipino craftsmanship and handmade furniture"
        class="hero__bg-image"
        loading="eager"
      />
      <div class="hero__overlay"></div>
    </div>

    <!-- Content -->
    <div class="hero__content">
      <div class="hero__container">
        <!-- Manila FAME Logo -->
        <div class="hero__logo">
          <div class="hero__logo-placeholder">
            MANILA FAME
          </div>
        </div>
        
        <h1 class="hero__title">
          Discover the Soul of <br />
          <span class="hero__title-highlight">
            Filipino Design
          </span>
        </h1>
        
        <p class="hero__subtitle">
          Connect directly with hundreds of premier Philippine
          exporters showcasing handcrafted furniture, fashion,
          and lifestyle products at Manila FAME
        </p>
        
        <div class="hero__actions">
          <button class="btn btn--primary" @click="navigateToRegister">
            Register as a Buyer
          </button>
          <button class="btn btn--secondary">
            Learn More
          </button>
        </div>
        
        <div class="hero__note">
          Free registration for qualified trade buyers
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'

const router = useRouter()

const navigateToRegister = () => {
  router.push('/register')
}
</script>

<style scoped>
/* Mobile-first hero section */
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.hero__background {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 0;
}

.hero__bg-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.hero__overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.4);
}

.hero__content {
  position: relative;
  z-index: 10;
  width: 100%;
  padding: 1rem;
  text-align: center;
  color: white;
}

.hero__container {
  max-width: 64rem;
  margin: 0 auto;
}

.hero__logo {
  margin-bottom: 2rem;
}

.hero__logo-image {
  height: 6rem;
  width: auto;
  filter: brightness(0) invert(1);
  display: block;
}

.hero__logo-placeholder {
  font-weight: bold;
  font-size: 1.25rem;
  letter-spacing: 0.1em;
  color: white;
  border: 2px solid white;
  padding: 0.5rem 1rem;
  display: inline-block;
  border-radius: 0.25rem;
}

.hero__title {
  font-size: 2.5rem;
  font-weight: bold;
  line-height: 1.1;
  margin-bottom: 1.5rem;
}

.hero__title-highlight {
  color: #fbbf24;
}

.hero__subtitle {
  font-size: 1.25rem;
  line-height: 1.6;
  margin-bottom: 2rem;
  color: #e5e7eb;
  max-width: 32rem;
  margin-left: auto;
  margin-right: auto;
}

.hero__actions {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  justify-content: center;
  align-items: center;
  margin-bottom: 2rem;
}

.hero__note {
  font-size: 0.875rem;
  color: #d1d5db;
  letter-spacing: 0.05em;
}

.btn {
  padding: 1rem 2rem;
  font-size: 1.125rem;
  font-weight: 600;
  border-radius: 9999px;
  cursor: pointer;
  transition: all 0.2s ease;
  border: none;
  text-decoration: none;
  display: inline-block;
  text-align: center;
  min-width: 200px;
  letter-spacing: 0.05em;
}

.btn:hover {
  transform: scale(1.05);
}

.btn--primary {
  background: #d97706;
  color: white;
}

.btn--primary:hover {
  background: #b45309;
}

.btn--secondary {
  background: transparent;
  color: white;
  border: 2px solid white;
}

.btn--secondary:hover {
  background: white;
  color: #111827;
}

/* Responsive design */
@media (min-width: 768px) {
  .hero__title {
    font-size: 3.75rem;
  }
  
  .hero__subtitle {
    font-size: 1.5rem;
  }
  
  .hero__actions {
    flex-direction: row;
  }
  
  .hero__logo-image {
    height: 7rem;
  }
}

@media (min-width: 1024px) {
  .hero__title {
    font-size: 4.5rem;
  }
  
  .hero__logo-image {
    height: 8rem;
  }
}

@media (min-width: 1440px) {
  .hero__title {
    font-size: 5rem;
  }
  
  .hero__subtitle {
    font-size: 1.625rem;
  }
  
  .btn {
    padding: 1.25rem 2.5rem;
    font-size: 1.25rem;
  }
  
  .hero__logo-image {
    height: 10rem;
  }
}
</style>
