import axios from "axios";
const url = "http://localhost:8000";
// const url = "https://miniurl.test/api";

const http = axios.create({
  baseURL: url,
  withCredentials: true,
});

// Function to fetch CSRF token
async function setCsrfToken() {
  try {
    const response = await http.get("/api/csrf-token");
    const csrfToken = response.data.csrfToken;
    http.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;
  } catch (error) {
    console.error("Error fetching CSRF token:", error);
  }
}
setCsrfToken();

export default http;
