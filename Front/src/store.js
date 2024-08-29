import { reactive } from "vue";

export const store = reactive({
  DayList: [],
  view: 0,
  apiURL: "http://localhost:8000/api/v1/voyager",
});
