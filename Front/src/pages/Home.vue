<script>
import axios from "axios";

//importo store
import { store } from "./../store";

export default {
  components: {
    name: "Home",
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
  },

  mounted() {
    this.getTech();
  },
};
</script>

<template>
  <div class="container">
    <h1>Il mio primo viaggio</h1>
    <div class="row row-cols-5">
      <div v-for="(day, i) in store.DayList" :key="i" class="col p-2">
        {{ day.titolo }}
        <img :src="getImageUrl(day)" alt="immagine" />
      </div>
    </div>
  </div>
</template>

<style lang="scss"></style>
