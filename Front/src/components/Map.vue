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
  <input
      type="text"
      v-model="searchQuery"
      @keyup.enter="searchLocation"
      placeholder="Cerca una località"
    />
 <div ref="mapInPage" class="map-container"></div>
</template>

<style scoped>
.map-container {
  position: relative;
  left: 25%;
  width: 50%;
  height: 500px; /* Altezza della mappa */
}
</style>
