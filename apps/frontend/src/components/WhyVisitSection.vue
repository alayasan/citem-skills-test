<template>
  <section class="why-visit">
    <div class="why-visit__container">
      <div class="why-visit__header">
        <h2 class="why-visit__title">
          Why Visit Manila FAME?
        </h2>
        <p class="why-visit__subtitle">
          Unlock opportunities in the Philippines' premier design and craftsmanship showcase
        </p>
      </div>

      <div class="why-visit__grid">
        <div 
          v-for="(benefit, index) in benefits" 
          :key="index"
          class="why-visit__card"
        >
          <div class="why-visit__icon">
            <component :is="benefit.icon" class="why-visit__icon-svg" />
          </div>
          <h3 class="why-visit__card-title">
            {{ benefit.title }}
          </h3>
          <p class="why-visit__card-description">
            {{ benefit.description }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { Users, TrendingUp, Leaf, Star } from 'lucide-vue-next'

const benefits = [
  {
    icon: Users,
    title: "Source Directly",
    description: "Meet and build relationships with hundreds of top Philippine exporters in one location"
  },
  {
    icon: TrendingUp,
    title: "Discover New Trends",
    description: "Be the first to see the latest collections and design innovations from Filipino artisans"
  },
  {
    icon: Leaf,
    title: "Sustainable & Ethical",
    description: "Find products with a story, made with sustainable materials and ethical practices"
  },
  {
    icon: Star,
    title: "Exclusive Access",
    description: "Gain entry to special showcases, industry talks, and networking events"
  }
]
</script>

<style scoped lang="scss">
// Import font variables
@import '../assets/styles/fonts';

// Mobile-first Why Visit section
.why-visit {
  padding: 5rem 1rem;
  background: white;
  
  &__container {
    max-width: 1200px;
    margin: 0 auto;
  }
  
  &__header {
    text-align: center;
    margin-bottom: 4rem;
  }
  
  &__title {
    font-family: $font-primary;
    font-size: 1.875rem; // 3xl
    font-weight: 700;
    margin-bottom: 1rem;
    color: #111827; // gray-900
    line-height: 1.2;
  }
  
  &__subtitle {
    font-size: 1.25rem; // xl
    color: #4b5563; // gray-600
    max-width: 32rem; // 2xl
    margin: 0 auto;
    line-height: 1.6;
  }
  
  &__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  &__card {
    text-align: center;
    padding: 1.5rem;
    border-radius: 0.5rem;
    transition: box-shadow 0.3s ease;
    
    &:hover {
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
  }
  
  &__icon {
    width: 4rem;
    height: 4rem;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #fbbf24, #f59e0b); // yellow-400 to yellow-600
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    
    &-svg {
      width: 2rem;
      height: 2rem;
      color: white;
    }
  }
  
  &__card-title {
    font-family: $font-primary;
    font-size: 1.25rem; // xl
    font-weight: 600;
    margin-bottom: 1rem;
    color: #111827; // gray-900
  }
  
  &__card-description {
    color: #4b5563; // gray-600
    line-height: 1.6;
    font-size: 1rem;
  }
}

// Tablet breakpoint (768px+)
@media (min-width: 768px) {
  .why-visit {
    padding: 5rem 2rem;
    
    &__title {
      font-size: 2.25rem; // 4xl
    }
    
    &__grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 2rem;
    }
    
    &__card {
      padding: 2rem;
    }
  }
}

// Desktop breakpoint (1024px+)
@media (min-width: 1024px) {
  .why-visit {
    &__grid {
      grid-template-columns: repeat(4, 1fr);
      gap: 2rem;
    }
  }
}

// Large desktop breakpoint (1440px+)
@media (min-width: 1440px) {
  .why-visit {
    padding: 6rem 2rem;
    
    &__title {
      font-size: 2.5rem;
    }
    
    &__subtitle {
      font-size: 1.375rem;
    }
    
    &__grid {
      gap: 2.5rem;
    }
    
    &__card {
      padding: 2.5rem;
    }
  }
}
</style>
