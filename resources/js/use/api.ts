import axios from "axios";

const language = window.location.pathname.split('/')[1];

const api = axios.create({
    baseURL: `${import.meta.env.VITE_BASE_URL}/${language}`,
    headers: {
        'Content-type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

const token = document.querySelector('meta[name="csrf-token"]');

if (token) {
    api.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
}

export default api;
