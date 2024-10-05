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
      isModalOpen1: false, // Stato per gestire l'apertura/chiusura della modale
      selectedPit: null, // Stato per memorizzare la tappa selezionata

      selectedVote: null, // Stato per memorizzare la votazione
      hoverRating: 0, // Valore del rating al passaggio del mouse

      selectedPitNote: "",
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

    //ritorno alla home page
    goToHome() {
      this.$router.push("/");
    },

    openModal(data, value) {
      switch (data) {
        case "pit":
          this.selectedPit = value; // Memorizza la tappa selezionata
          this.isModalOpen = true; // Mostra la modale
          break;
        case "vote":
          this.selectedVote = value; // Memorizza la votazione
          this.isModalOpen1 = true; // Mostra la seconda modale
          break;
        default:
          console.error("Tipo di modale sconosciuto:", data);
      }
    },

    closeModal(data) {
      switch (data) {
        case "pit":
          this.isModalOpen = false; // Chiude la modale
          this.selectedPit = null; // Resetta la tappa selezionata
          break;
        case "vote":
          this.isModalOpen1 = false; // Chiude la seconda modale
          this.selectedVote = null; // Resetta la votazione selezionata
          break;
        default:
          console.error("Tipo di modale sconosciuto:", data);
      }
    },

    // Metodo per ottenere stelle cliccabili
    getStars(maxStars) {
      const stars = [];
      for (let i = 1; i <= maxStars; i++) {
        stars.push(i);
      }
      return stars;
    },

    // Metodo per sapere se una stella è attiva (riempita) o no
    isStarActive(star) {
      return star <= this.selectedVote; // Verifica se la stella è inferiore o uguale al voto selezionato
    },

    setRating(value) {
      this.selectedVote = value; // Imposta il rating al clic
    },

    hoverMouse(value) {
      this.hoverRating = value; // Mostra rating al passaggio del mouse
    },

    resetRating() {
      this.hoverRating = 0; // Resetta il rating al passaggio del mouse
    },

    // Esempio di salvataggio della votazione
    saveVote() {
      console.log("Voto salvato:", this.selectedVote);
      this.closeModal("vote");
    },

    // Metodo per sapere se una stella è attiva (riempita) o no
    isStarActive(star) {
      console.log(star);
      return star <= this.selectedVote;
    },

    savePitNote() {
      if (this.selectedPit) {
        //controllo se ho modificato le note
        if (this.selectedPitNote) {
          const updatedPit = {
            ...this.selectedPit,
            Note: this.selectedPitNote,
          };

          let myURL2 = store.apiURL2 + this.selectedPit.id;
          console.log(myURL2);
          axios
            .put(myURL2, updatedPit)
            .then((response) => {
              // Aggiorna la nota nel frontend
              this.selectedPit.Note = this.selectedPitNote;

              // Eventuali azioni da eseguire dopo l'aggiornamento
              this.closeModal();
            })
            .catch((error) => {
              console.error(
                "Errore durante l'aggiornamento della nota:",
                error
              );
            });
        }
      }
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
          <button @click="openModal('pit', pit)" class="btn btn-secondary mt-2">
            Modifica
          </button>

          <!-- Bottone per aprire la modale per la modifica -->
          <button @click="openModal('vote', vote)" class="btn btn-primary mt-2">
            Aggiungi votazione
          </button>
        </div>
      </div>
      <div class="text-center">
        <button @click="goToHome" class="btn btn-primary mt-3">
          Torna indietro
        </button>
      </div>
    </div>
    <div v-else class="row row-cols-5">
      <h2>Caricamento.....</h2>
    </div>
  </div>

  <!-- La modale NOTE -->
  <div v-if="isModalOpen" id="myModal" class="modal">
    <div class="modal-content">
      <span @click="closeModal('pit')" class="close">&times;</span>
      <h2>Note:</h2>
      <!-- Visualizza le note della tappa selezionata -->
      <p>{{ selectedPit.Note }}</p>
      <!-- Text area per la modifica -->
      <textarea v-model="selectedPitNote" rows="4" cols="50"></textarea>
      <!-- Bottone per salvare le modifiche -->
      <button @click="savePitNote" class="btn btn-primary mt-3">Salva</button>
    </div>
  </div>

  <div v-if="isModalOpen1" id="myModal1" class="modal">
    <div class="modal-content">
      <span @click="closeModal('vote')" class="close">&times;</span>
      <h2>Dai un voto:</h2>
      <!-- Stelle cliccabili -->
      <div class="stars" @mouseleave="resetRating">
        <span
          v-for="star in getStars(5)"
          :key="star"
          @mouseover="hoverMouse(star)"
          @click="setRating(star)"
          :class="{ active: isStarActive(star), hover: hoverRating >= star }"
        >
        </span>
      </div>

      <button @click="saveVote" class="btn btn-primary mt-3">Salva</button>
    </div>
  </div>
</template>

<style lang="scss">
@use "../styles/partials/variables" as *;

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
  width: 40%;
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

/* Stile per le stelle */
.stars {
  display: inline-block;
  font-size: 2rem;
  color: #ccc; /* Colore stelle vuote */
  cursor: pointer;
  text-align: center;
  //direction: rtl; /* Cambia direzione per visualizzare correttamente le stelle */
}
/* Stelle vuote iniziali */
.stars span::before {
  content: "☆"; /* Stelle vuote */
  color: gray;
  transition: color 0.2s ease-in-out;
}

/* Stelle piene al passaggio del mouse */
.stars span.hover::before {
  content: "★"; /* Stelle piene */
  color: gold;
}

/* Quando una stella è selezionata (attiva) */
.stars span.active::before {
  content: "★"; /* Stelle piene */
  color: gold;
}
</style>
