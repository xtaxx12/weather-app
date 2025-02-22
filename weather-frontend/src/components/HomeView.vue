<template>
    <div class="container">
      <h1>Usuarios y su Clima</h1>
      <div v-for="user in users" :key="user.id" @click="selectUser(user)">
        <p>{{ user.name }} - {{ user.weather.main?.temp }}°C</p>
      </div>
  
      <div v-if="selectedUser">
        <h2>Detalles del Clima de {{ selectedUser.name }}</h2>
        <p>Temperatura: {{ selectedUser.weather.main?.temp }}°C</p>
        <p>Estado: {{ selectedUser.weather.weather[0]?.description }}</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        users: [],
        selectedUser: null
      };
    },
    async mounted() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/weather');
        this.users = response.data;
      } catch (error) {
        console.error("Error obteniendo los datos del clima", error);
      }
    },
    methods: {
      selectUser(user) {
        this.selectedUser = user;
      }
    }
  };
  </script>
  