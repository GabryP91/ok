<script>
export default {
  data() {
    return {
      currentSlide: 0,
      slides: [
        {
          image: "/images/immagine1a.jpg",
          title: "Tracking ed Esplorazione",
          description: "Viaggio nella natura selvaggia.",
        },
        {
          image: "/images/immagine7.jpg",
          title: "City Tour",
          description: "Relax tra le capitali del mondo.",
        },
        {
          image: "/images/immagine3.jpg",
          title: "Desert explorer",
          description:"Avventura tra le dune.",
        },
      ],
    };
  },
  methods: {
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % this.slides.length;
    },
    prevSlide() {
      this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
    },
    goToSlide(index) {
      this.currentSlide = index;
    },
  },
  mounted() {
    setInterval(() => {
      this.nextSlide();
    }, 5000); // Slide change every 5 seconds
  },
};
</script>

<template>
  <div class="slider">
    <div
      v-for="(slide, index) in slides"
      :key="index"
      class="slide"
      :style="{ backgroundImage: `url(${slide.image})` }"
      v-show="currentSlide === index"
    >
      <div class="content">
        <h1>{{ slide.title }}</h1>
        <p>{{ slide.description }}</p>
        <button class="cta">Scopri di più</button>
      </div>
    </div>

    <!-- Navigation -->
    <button class="prev" @click="prevSlide">❮</button>
    <button class="next" @click="nextSlide">❯</button>

    <!-- Indicators -->
    <div class="indicators">
      <span
        v-for="(slide, index) in slides"
        :key="index"
        :class="{ active: currentSlide === index }"
        @click="goToSlide(index)"
      ></span>
    </div>
  </div>
</template>

<style scoped>
html,
body,
#app {
  font-family: "Arial", sans-serif;
}

/* Slider adjustments for partial height */
.slider {
  position: relative;
  height: 60vh; /* Reduce height to fit similar layout */
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Slide style */
.slide {
  width: 80%; /* Adjust width for a more compact look */
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  background-repeat: no-repeat;
  background-size: cover;
  display: flex;
  justify-content: center;
  align-items: flex-end; /* Move content to the bottom */
  position: relative;
  transition: opacity 1s ease-in-out;
}

/* Text content styling below the image */
.content {
  width: 100%;
  background-color: rgba(255, 255, 255, 0.8); /* White semi-transparent background */
  padding: 20px;
  text-align: center;
  color: #333; /* Dark text for better readability */
}

.content h1 {
  font-size: 1.8rem;
  margin-bottom: 10px;
}

.content p {
  font-size: 1.2rem;
  margin: 10px 0;
}

.cta {
  background-color: #f47a20;
  border: none;
  color: white;
  padding: 10px 20px;
  cursor: pointer;
  font-size: 1rem;
  border-radius: 5px;
}

.cta:hover {
  background-color: #e36917;
}

/* Navigation buttons */
.prev,
.next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  padding: 10px;
  font-size: 1.5rem;
  cursor: pointer;
  border-radius: 50%;
  z-index: 1;
}

.prev {
  left: 10px;
}

.next {
  right: 10px;
}

.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Indicators style */
.indicators {
  position: absolute;
  bottom: 10px;
  display: flex;
  gap: 8px;
}

.indicators span {
  height: 12px;
  width: 12px;
  background-color: rgba(0, 0, 0, 0.3);
  border-radius: 50%;
  cursor: pointer;
}

.indicators span.active {
  background-color: #333;
}

.indicators span:hover {
  background-color: #666;
}
</style>

