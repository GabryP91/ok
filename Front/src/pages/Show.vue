<script>
import axios from "axios";
import { store } from "../store";

export default {
  components: {
    name: "Show",
  },

  data() {
    return {
      store,
      showPits: false,
      isModalOpen: false, // Stato per gestire l'apertura/chiusura della modale
      selectedPit: null, // Stato per memorizzare la tappa selezionata
    };
  },

  methods: {
    getPitDay() {
      const urlString = window.location.href;
      const segments = urlString.split("/");
      const id = segments.pop() || segments.pop();
      let myURL1 = store.apiURL1 + id;

      axios
        .get(myURL1)
        .then((res) => {
          store.PitsOfDay = res.data.messages;
        })
        .catch((err) => {
          console.log("Errori", err);
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

    goToHome() {
      this.$router.push("/");
    },

    openModal(pit) {
      this.selectedPit = pit; // Memorizza la tappa selezionata
      this.isModalOpen = true; // Mostra la modale
    },

    closeModal() {
      this.isModalOpen = false; // Chiude la modale
      this.selectedPit = null; // Resetta la tappa selezionata
    },
  },

  mounted() {
    this.getPitDay();
    setTimeout(() => {
      this.showPits = true;
    }, 700);
  },
};
</script>

<template>
  <div class="container">
    <h1>le varie tappe</h1>
    <div v-if="showPits">
      <div v-if="!store.PitsOfDay || store.PitsOfDay.length === 0">
        <h2>Nessuna tappa presente!</h2>
      </div>
      <div v-else class="row row-cols-5">
        <div v-for="(pit, i) in store.PitsOfDay" :key="i" class="col p-2">
          <h2>{{ pit.titolo }}</h2>
          <img :src="pit.immagine" alt="immagine" />
          <h3>Descrizione:</h3>
          <p>{{ pit.Descrizione }}</p>
          <h3>Note:</h3>
          <p>{{ pit.Note }}</p>

          <!-- Bottone per aprire la modale per la modifica -->
          <button @click="openModal(pit)" class="btn btn-secondary mt-2">
            Modifica
          </button>
        </div>
      </div>
      <button @click="goToHome" class="btn btn-primary mt-3">
        Torna indietro
      </button>
    </div>
    <div v-else class="row row-cols-5">
      <h2 style="text-align: center">Caricamento.....</h2>
    </div>
  </div>

  <!-- La modale -->
  <div v-if="isModalOpen" id="myModal" class="modal">
    <div class="modal-content">
      <span @click="closeModal" class="close">&times;</span>
      <h2>Note:</h2>
      <p>{{ selectedPit?.Note }}</p>
      <!-- Visualizza le note della tappa selezionata -->
    </div>
  </div>
</template>

<style lang="scss">
@use "../styles/partials/variables" as *;

h1,
h2,
h3 {
  text-align: center;
  margin-top: 20px;
}

/* Stile della modale */
.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

/* Contenuto della modale */
.modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* Pulsante di chiusura */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
