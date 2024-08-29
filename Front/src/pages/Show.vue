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

<template>ciao sono la show</template>

<style lang="scss">
//Scss relativo alla sola sezione di header
@use "../styles/partials/variables" as *;

h1 {
  text-align: center;
  margin-top: 20px;
  //color: $secondary;
}
</style>
