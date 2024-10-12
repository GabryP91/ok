<script>
export default {
  name: 'MapComponent',
  mounted() {
    this.initMap();
  },
  methods: {
    initMap() {
      const map = tt.map({
        key: 'dB9lQpqT9okIueN0UQiGjXVqjGI1AGmL',
        container: this.$refs.map,
        center: [12.4964, 41.9028], // Coordinate per Roma
        zoom: 12,
      });

      //console.log(map);

      // Opzionalmente, aggiungi un marker
        var speedyPizzaCoordinates = [12.4964, 41.9028]; 
        var marker = new tt.Marker().setLngLat(speedyPizzaCoordinates).addTo(map)
        
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
    },
  },
};
</script>

<template>
 <div ref="map" class="map-container"></div>
</template>

<style scoped>
.map-container {
  position: relative;
  left: 25%;
  width: 50%;
  height: 500px; /* Altezza della mappa */
}
</style>
