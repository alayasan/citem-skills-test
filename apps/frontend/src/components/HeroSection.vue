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
          <button class="btn btn--primary">
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
// Hero component matching Figma design
</script>

<style scoped lang="scss">
// Import font variables
@import '../assets/styles/fonts';

// Mobile-first hero section matching Figma design
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  
  &__background {
    position: absolute;
    inset: 0;
    z-index: 0;
  }
  
  &__bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
  }
  
  &__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
  }
  
  &__content {
    position: relative;
    z-index: 10;
    width: 100%;
    padding: 1rem;
    text-align: center;
    color: white;
  }
  
  &__container {
    max-width: 64rem; // 4xl equivalent
    margin: 0 auto;
  }
  
  &__logo {
    margin-bottom: 2rem;
    
    &-placeholder {
      font-family: $font-futura;
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: 2px;
      color: white;
      // Placeholder styling - replace with actual logo
      border: 2px solid white;
      padding: 0.5rem 1rem;
      display: inline-block;
      border-radius: 4px;
    }
  }
  
  &__title {
    font-family: $font-primary;
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 1.5rem;
    
    &-highlight {
      color: #fbbf24; // yellow-400 equivalent
    }
  }
  
  &__subtitle {
    font-size: 1.25rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    color: #e5e7eb; // gray-200 equivalent
    max-width: 32rem; // 2xl equivalent
    margin-left: auto;
    margin-right: auto;
  }
  
  &__actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    justify-content: center;
    align-items: center;
    margin-bottom: 2rem;
  }
  
  &__note {
    font-family: $font-futura;
    font-size: 0.875rem;
    color: #d1d5db; // gray-300 equivalent
    letter-spacing: 0.5px;
  }
}

// Button styles matching Figma design
.btn {
  font-family: $font-futura;
  padding: 1rem 2rem;
  font-size: 1.125rem;
  font-weight: 600;
  border-radius: 9999px; // rounded-full
  cursor: pointer;
  transition: all 0.2s ease;
  border: none;
  text-decoration: none;
  display: inline-block;
  text-align: center;
  min-width: 200px;
  letter-spacing: 0.5px;
  
  &:hover {
    transform: scale(1.05);
  }
  
  &--primary {
    background: #d97706; // yellow-600
    color: white;
    
    &:hover {
      background: #b45309; // yellow-700
    }
  }
  
  &--secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
    
    &:hover {
      background: white;
      color: #111827; // gray-900
    }
  }
}

// Tablet breakpoint (768px+)
@media (min-width: 768px) {
  .hero {
    &__logo {
      margin-bottom: 2rem;
      
      &-placeholder {
        font-size: 1.75rem;
        padding: 0.75rem 1.5rem;
      }
    }
    
    &__title {
      font-size: 3.75rem; // 6xl equivalent
    }
    
    &__subtitle {
      font-size: 1.5rem;
    }
    
    &__actions {
      flex-direction: row;
    }
  }
}

// Desktop breakpoint (1024px+)
@media (min-width: 1024px) {
  .hero {
    &__logo {
      &-placeholder {
        font-size: 2rem;
        padding: 1rem 2rem;
      }
    }
    
    &__title {
      font-size: 4.5rem; // 7xl equivalent
    }
  }
}

// Large desktop breakpoint (1440px+)
@media (min-width: 1440px) {
  .hero {
    &__title {
      font-size: 5rem;
    }
    
    &__subtitle {
      font-size: 1.625rem;
    }
  }
  
  .btn {
    padding: 1.25rem 2.5rem;
    font-size: 1.25rem;
  }
}
</style>
