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

<style scoped>
/* Mobile-first Why Visit section */
.why-visit {
  padding: 5rem 1rem;
  background: white;
}

.why-visit__container {
  max-width: 72rem;
  margin: 0 auto;
}

.why-visit__header {
  text-align: center;
  margin-bottom: 4rem;
}

.why-visit__title {
  font-size: 1.875rem;
  font-weight: bold;
  margin-bottom: 1rem;
  color: #111827;
  line-height: 1.2;
}

.why-visit__subtitle {
  font-size: 1.25rem;
  color: #6b7280;
  max-width: 32rem;
  margin: 0 auto;
  line-height: 1.6;
}

.why-visit__grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

.why-visit__card {
  text-align: center;
  padding: 1.5rem;
  border-radius: 0.5rem;
  transition: box-shadow 0.3s ease;
}

.why-visit__card:hover {
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.why-visit__icon {
  width: 4rem;
  height: 4rem;
  margin: 0 auto 1.5rem;
  background: linear-gradient(135deg, #fbbf24, #f59e0b);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.why-visit__icon-svg {
  width: 2rem;
  height: 2rem;
  color: white;
}

.why-visit__card-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
  color: #111827;
}

.why-visit__card-description {
  color: #6b7280;
  line-height: 1.6;
}

/* Responsive design */
@media (min-width: 768px) {
  .why-visit {
    padding: 5rem 2rem;
  }
  
  .why-visit__title {
    font-size: 2.25rem;
  }
  
  .why-visit__grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .why-visit__card {
    padding: 2rem;
  }
}

@media (min-width: 1024px) {
  .why-visit__grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

@media (min-width: 1440px) {
  .why-visit {
    padding: 6rem 2rem;
  }
  
  .why-visit__title {
    font-size: 3rem;
  }
  
  .why-visit__subtitle {
    font-size: 1.375rem;
  }
  
  .why-visit__grid {
    gap: 2.5rem;
  }
  
  .why-visit__card {
    padding: 2.5rem;
  }
}
</style>
