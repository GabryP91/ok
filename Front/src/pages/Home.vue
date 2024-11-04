<script>
import axios from "axios";
import { store } from "./../store";
import Sliderimg from "../components/Sliderimg.vue";
import Map from "../components/Map.vue";

export default {
  components: {
    Sliderimg,
    Map,
  },
  data() {
    return {
      store,
    };
  },
  methods: {
    getTech() {
      let myURL = store.apiURL;
      axios
        .get(myURL)
        .then((res) => {
          store.DayList = res.data.messages;
        })
        .catch((err) => {
          console.log("Error", err);
        });
    },
    getImageUrl(day) {
      return `http://localhost:8000/storage/${day.immagine}`;
    },
    riempiVet(id) {
      store.DayList.forEach((element) => {
        if (element.id == id) {
          store.List = element;
          localStorage.setItem("teacher", JSON.stringify(store.DayList));
          store.view = 1;
          localStorage.setItem("view", store.view);
        }
      });
    },
  },
  mounted() {
    this.getTech();
  },
};
</script>

<template>
  <Sliderimg />
  <div class="container">
    <h1>Il mio primo viaggio</h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <div v-for="(day, i) in store.DayList" :key="i" class="col">
        <RouterLink
          tag="div"
          :to="{ name: 'show', params: { id: day.id } }"
          @click="riempiVet(day.id), (store.view = 2)"
          class="card text-decoration-none"
        >
          <!-- Immagine di copertura -->
          <div class="card-img-wrapper">
            <img :src="getImageUrl(day)" alt="immagine" class="card-img-top" />
            <div class="overlay">
              <h2 class="card-title">{{ day.titolo }}</h2>
            </div>
          </div>
          <div class="card-body">
            <p class="card-text">{{ day.data }}</p>
          </div>
        </RouterLink>
      </div>
    </div>
  </div>
  <Map />
</template>

<style lang="scss">
@use "../styles/partials/variables" as *;

h1 {
  text-align: center;
  margin-top: 20px;
}

.container {
  padding: 20px;
}

.card {
  border: none;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #fff;

  &:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }

  .card-img-wrapper {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;

    .card-img-top {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Overlay scuro semi-trasparente */
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      text-align: center;

      .card-title {
        font-size: 1.4rem;
        font-weight: bold;
        color: #fff;
      }
    }

    &:hover .overlay {
      opacity: 1;
    }
  }

  .card-body {
    padding: 10px;
    text-align: center;

    .card-text {
      font-size: 1rem;
      color: #777;
    }
  }
}

/* Adattamenti responsivi per diverse dimensioni dello schermo */
@media (max-width: 576px) {
  .card-img-wrapper {
    height: 180px;
  }

  .card-body .card-text {
    font-size: 0.9rem;
  }
}
</style>
