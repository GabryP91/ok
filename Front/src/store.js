import { reactive } from "vue";

export const store = reactive({
  DayList: [],
  apiURL: "http://localhost:8000/api/v1/voyager",
});
