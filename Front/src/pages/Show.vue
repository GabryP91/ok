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
    <h1>Le varie tappe</h1>

      <div v-if="showPits" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <div v-if="!store.PitsOfDay || store.PitsOfDay.length === 0">
          <h2>Nessuna tappa presente!</h2>
        </div>
        <div v-else v-for="(pit, i) in store.PitsOfDay" :key="i" class="col">
          <div class="card text-decoration-none">
            <img :src="pit.immagine"  alt="immagine" class="card-img-top" />
            <div class="card-body">
              <h2 class="card-title">{{ pit.titolo }}</h2>
              <h3>Descrizione:</h3>
              <p>{{ pit.Descrizione }}</p>
              <h3>Note:</h3>
              <p class="card-text">{{ pit.Note }}</p>
              <div class="d-flex justify-content-between mt-2">
                <button @click="openModal('pit', pit)" class="btn btn-secondary">Modifica</button>
                <button @click="openModal('vote', pit)" class="btn btn-primary">Aggiungi votazione</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="row row-cols-5">
        <h2>Caricamento.....</h2>
      </div>
    

    <!-- La modale NOTE -->
    <div v-if="isModalOpen" id="myModal" class="modal">
      <div class="modal-content">
        <span @click="closeModal('pit')" class="close">&times;</span>
        <h2>Note:</h2>
        <p>{{ selectedPit.Note }}</p>
        <textarea v-model="selectedPitNote" rows="4" cols="50"></textarea>
        <button @click="savePitNote" class="btn btn-primary mt-3">Salva</button>
      </div>
    </div>

    <div v-if="isModalOpen1" id="myModal1" class="modal">
      <div class="modal-content">
        <span @click="closeModal('vote')" class="close">&times;</span>
        <h2>Dai un voto:</h2>
        <div class="stars" @mouseleave="resetRating">
          <span
            v-for="star in getStars(5)"
            :key="star"
            @mouseover="hoverMouse(star)"
            @click="setRating(star)"
            :class="{ active: isStarActive(star), hover: hoverRating >= star }"
          ></span>
        </div>
        <button @click="saveVote" class="btn btn-primary mt-3">Salva</button>
      </div>
    </div>

    <div class="text-center">
          <button @click="goToHome" class="btn btn-primary mt-3">
            Torna indietro
          </button>
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

  .card-img-top {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  .card-body {
    padding: 15px;
    text-align: center;

    .card-title {
      font-size: 1.2rem;
      font-weight: bold;
      margin: 10px 0;
      color: #333;
    }

    .card-text {
      font-size: 1rem;
      color: #777;
    }
  }
}

/* Adattamenti responsivi per diverse dimensioni dello schermo */
@media (max-width: 576px) {
  .card-img-top {
    height: 140px;
  }

  .card-body .card-title {
    font-size: 1rem;
  }

  .card-body .card-text {
    font-size: 0.9rem;
  }
}

</style>
