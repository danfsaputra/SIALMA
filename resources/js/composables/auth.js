import { computed, ref, reactive } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

const state = reactive({
  authenticated: false,
  user: {},
});

const errors = ref({});
const loading = ref(false);

export default function auth() {
  const authenticated = computed(() => state.authenticated);
  const user = computed(() => state.user);

  const setAuthenticated = (authenticated) => {
    state.authenticated = authenticated;
  };

  const setUser = (user) => {
    state.user = user;
  };

  const login = async (credentials) => {
    loading.value = true;

    try {
      await axios.get("/sanctum/csrf-cookie");

      try {
        await axios.post("/login", credentials);
        loading.value = false;
        return attempt();
      } catch (e) {
        if (e.response.status === 422) {
          errors.value = e.response.data.errors;
          loading.value = false;
        }
      }
    } catch (e) {
      console.log(e);
    }
  };

  const attempt = async () => {
    try {
      let response = await axios.get("/api/user");

      setAuthenticated(true);
      setUser(response.data);

      //   get current route name
      let currentRouteName = router.page.url;
      if (currentRouteName === "/login") {
        return router.visit("/dashboard", { method: "get" });
      }
    } catch (e) {
      setAuthenticated(false);
      setUser({});
    }
  };

  return {
    authenticated,
    user,
    login,
    attempt,
    errors,
    loading,
  };
}
