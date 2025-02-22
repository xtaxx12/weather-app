import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/', // URL de tu backend Laravel
  headers: {
    'Content-Type': 'application/json',
  },
});

export default {
  getUsers() {
    return api.get('/users'); // Endpoint para obtener la lista de usuarios
  },
  getWeather(userId) {
    return api.get(`/weather/${userId}`); // Endpoint para obtener el clima de un usuario
  },
};