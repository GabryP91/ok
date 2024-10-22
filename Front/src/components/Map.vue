<script>
import axios from "axios";

//importo store
import { store } from "./../store";

export default {

  name: 'MapComponent',

  data() {
    return {
      searchQuery: '',
      store,
      markerMode: false, // Stato per attivare/disattivare la modalità markers
    };
  },

  mounted() {
    this.initMap();
  },

  methods: {
    initMap() {

      const mapInPage = tt.map({
        key: store.KeyApp,
        container: this.$refs.mapInPage,
        center: [16.28399, 41.31928], // (lon,lat) Coordinate per citta
        zoom: 12,
      });

      // Opzionalmente, aggiungi un marker
        var speedyPizzaCoordinates = [12.4964, 41.9028]; 
        var marker = new tt.Marker().setLngLat(speedyPizzaCoordinates).addTo(mapInPage)
        
        var popupOffsets = { 
            top: [0, 0], 
            bottom: [0, -70], 
            'bottom-right': [0, -70], 
            'bottom-left': [0, -70], 
            left: [25, -35], 
            right: [-25, -35] 
          } 
        var popup = new tt.Popup({offset: popupOffsets}).setHTML("<b>Speedy's pizza</b>"); 
        marker.setPopup(popup).togglePopup(); 
        
        store.map = mapInPage;
        console.log(store.map)

        // Aggiungi un evento click alla mappa per aggiungere markers
      mapInPage.on('click', (e) => {
        if (this.markerMode) {
          
          const coordinates = [e.lngLat.lng, e.lngLat.lat]; // acquisisco longitudine e latitudine
          this.addMarker(coordinates, "Nuovo marker", mapInPage);
          
        }
      });

    },
    
    

    toggleMarkerMode() {
      this.markerMode = !this.markerMode; // Attiva/disattiva la modalità markers
      
    },

    addMarker(coordinates, title, map) {
    const marker = new tt.Marker().setLngLat(coordinates).addTo(map);
    
    const popupOffsets = {
      top: [0, 0],
      bottom: [0, -70],
      'bottom-right': [0, -70],
      'bottom-left': [0, -70],
      left: [25, -35],
      right: [-25, -35]
    };
    const popup = new tt.Popup({offset: popupOffsets}).setHTML(`<b>${title}</b>`);
    
    marker.setPopup(popup).togglePopup();
  },
  

    searchLocation() {
      
      let Search = store.callMap +`${encodeURIComponent(this.searchQuery)}.json?key=`+ store.KeyApp;

      console.log(Search);


      //chiamata axios
      axios
        .get(Search)
        .then((res) => {
         
          let lat = res.data.results[0].position.lat;

          let lng = res.data.results[0].position.lon;

          store.map.setCenter([lng,lat]);

          store.map.setZoom(14); // Zoom in for the search result
        })
        .catch((err) => {
          console.log("Errori", err);
        });
    },
  },
};
</script>

<template>
  <div class="input-container">
    <input
      class="input-field"
      type="text"
      v-model="searchQuery"
      @keyup.enter="searchLocation"
      placeholder="Cerca una località"
    />
  </div>
  <div ref="mapInPage" class="map-container">
    <div class="addMarker">
      <button @click="toggleMarkerMode"> Aggiungi un segnaposto</button>
      <i ref="flagIcon" :class="['fa-solid', 'fa-flag', 'band', { 'active': markerMode }]" ></i></div>
    </div>
    
</template>

<style scoped>
.input-container {
  display: flex;
  justify-content: center;
  margin-bottom: 20px; /* Spazio sotto l'input */
}

.input-field {
  width: 50%; /* Regola la larghezza come necessario */
  padding: 10px; /* Aggiungi un po' di padding */
  border: 1px solid #ccc; /* Bordo chiaro */
  border-radius: 5px; /* Angoli arrotondati */
  font-size: 16px; /* Aumenta la dimensione del font */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ombra leggera */
  transition: border-color 0.3s; /* Transizione per effetto focus */
}

.input-field:focus {
  outline: none; /* Rimuovi il contorno predefinito */
  border-color: #007bff; /* Cambia colore del bordo al focus */
}

.map-container {
  position: relative;
  left: 25%;
  width: 50%;
  height: 500px; /* Altezza della mappa */
  margin-bottom: 10px;
}

.addMarker {
  position: absolute;
  top: 20px; 
  right: 20px; 
  font-size: 24px; 
  z-index: 10;
}

.band {
  
  color: black;
  
  transition: color 0.3s;
}

.band.active {
  color: yellow; /* Colore quando attiva */
}

</style>
