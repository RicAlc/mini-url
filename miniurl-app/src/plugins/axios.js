// src/plugins/axios.js
import axios from "axios";
const url = "http://localhost:8000";
// const url = "https://miniurl.test/api";
const http = axios.create({
    baseURL: url,
    headers: {
        "Content-Type": "application/json",
        // Authorization: options.token ? `Bearer ${options.token}` : "",
    },
});

export default http;
