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
      this.currentSlide =
        (this.currentSlide - 1 + this.slides.length) % this.slides.length;
    },
    goToSlide(index) {
      this.currentSlide = index;
    },
  },
  mounted() {
    setInterval(() => {
      this.nextSlide();
    }, 50000); // Cambia slide ogni 5 secondi
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
      <div class="overlay"></div>
      <div class="content">
        <h1>{{ slide.title }}</h1>
        <p>{{ slide.description }}</p>
        <button class="cta">Scopri di più</button>
      </div>
    </div>

    <!-- Navigazione -->
    <button class="prev" @click="prevSlide">❮</button>
    <button class="next" @click="nextSlide">❯</button>

    <!-- Indicatori -->
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
  height: 100%;
  font-family: "Arial", sans-serif;
}


/* Stile delle slide */
.slide {
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  background-repeat: no-repeat;
  background-size: cover;
  transition: opacity 1s ease-in-out;
}

/* Sovrapposizione scura per il testo */
.overlay {
  
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

/* Contenuto del testo */
.content {
  position: absolute;
  bottom: 10%;
  left: 5%;
  color: white;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}



.content p {
  font-size: 1.5rem;
  margin: 10px 0;
}

.cta {
  background-color: #f47a20;
  border: none;
  color: white;
  padding: 10px 20px;
  cursor: pointer;
  font-size: 1.2rem;
  border-radius: 5px;
}

.cta:hover {
  background-color: #e36917;
}

/* Pulsanti di navigazione */
.prev,
.next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  padding: 15px;
  font-size: 2rem;
  cursor: pointer;
  border-radius: 50%;
}

.prev {
  left: 20px;
}

.next {
  right: 20px;
}

.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Indicatori (punti per il controllo dello slider) */
.indicators {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
}

.indicators span {
  height: 15px;
  width: 15px;
  margin: 0 5px;
  background-color: rgba(255, 255, 255, 0.5);
  border-radius: 50%;
  cursor: pointer;
}

.indicators span.active {
  background-color: white;
}

.indicators span:hover {
  background-color: #ddd;
}
</style>
