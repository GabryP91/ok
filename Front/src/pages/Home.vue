<script>
import axios from "axios";

//importo store
import { store } from "./../store";

import Sliderimg from "../components/Sliderimg.vue";

export default {
  components: {
    Sliderimg,
  },

  data() {
    return {
      store,
    };
  },

  methods: {
    getTech() {
      let myURL = store.apiURL;

      console.log(myURL);

      //prima chiamata axios
      axios
        .get(myURL)
        .then((res) => {
          store.DayList = res.data.messages;

          console.log(store.DayList);
        })
        .catch((err) => {
          console.log("Errori", err);
        });
    },

    getImageUrl(day) {
      return `http://localhost:8000/storage/${day.immagine}`;
    },

    // funzione chiamata quando si clicca su un giorno
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
  <div class="container">
    <Sliderimg />
    <h1>Il mio primo viaggio</h1>

    <div class="row row-cols-5">
      <div v-for="(day, i) in store.DayList" :key="i" class="col p-2">
        <RouterLink
          tag="div"
          :to="{ name: 'show', params: { id: day.id } }"
          @click="riempiVet(day.id), (store.view = 2)"
          class="text-decoration-none"
        >
          <h2>{{ day.titolo }}</h2>
          <img :src="getImageUrl(day)" alt="immagine" />
          <p>{{ day.data }}</p>
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
//Scss relativo alla sola sezione di header
@use "../styles/partials/variables" as *;

h1 {
  text-align: center;
  margin-top: 20px;
  //color: $secondary;
}
</style>
