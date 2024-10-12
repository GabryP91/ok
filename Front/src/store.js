import { reactive } from "vue";

export const store = reactive({
  DayList: [],
  PitsOfDay: [],
  view: 0,
  apiURL: "http://localhost:8000/api/v1/voyager",
  //seconda chiamata
  apiURL1: "http://localhost:8000/api/v1/tips_voyager?day_id=",
  //terza chiamata
  apiURL2: "http://localhost:8000/api/v1/pits_mod_note?pit_id=",

});
