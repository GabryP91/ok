<script>
import axios from "axios";

//importo store
import { store } from "../store";

export default {
  components: {
    name: "Show",
  },

  data() {
    return {
      store,
    };
  },

  methods: {
    getPitDay() {
      // Ottieni la stringa dell'URL corrente
      const urlString = window.location.href;

      // Suddividi l'URL in base al carattere "/"
      const segments = urlString.split("/");

      // Recupera l'ultimo segmento (o quello appropriato)
      const id = segments.pop() || segments.pop(); // pop() viene chiamato due volte per gestire un'eventuale barra finale "/"

      let myURL1 = store.apiURL1 + id; //associo l'id all'URL

      //prima chiamata axios
      axios
        .get(myURL1)
        .then((res) => {
          store.PitsOfDay = res.data.messages;

          console.log(store.PitsOfDay);
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
    this.getPitDay();
  },
};
</script>

<template>
  <div class="container">
    <h1>le varie tappe</h1>
    <div v-if="!store.PitsOfDay || store.PitsOfDay.length === 0">
      <h2 style="text-align: center">Nessuna tappa presente!</h2>
    </div>
    <div v-else class="row row-cols-5">
      <div v-for="(pit, i) in store.PitsOfDay" :key="i" class="col p-2">
        <h2>{{ pit.titolo }}</h2>
        <img :src="pit.immagine" alt="immagine" />
        <p>DEscrizione: {{ pit.Descrizione }}</p>
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
