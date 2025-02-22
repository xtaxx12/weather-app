<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-3xl font-extrabold text-gray-900">User Weather Dashboard</h2>
      <button 
        @click="refreshData"
        class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors flex items-center gap-2"
        :disabled="loading"
      >
        <span v-if="loading">Refreshing...</span>
        <span v-else>Refresh Weather</span>
      </button>
    </div>

    <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
      {{ error }}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div 
        v-for="user in users" 
        :key="user.id" 
        class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow"
      >
        <div class="flex items-start justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-800">{{ user.name }}</h3>
            <p class="text-sm text-gray-500">{{ user.location }}</p>
          </div>
          <div class="text-right">
            <p class="text-2xl font-bold text-gray-900">{{ user.weather.temperature.toFixed(2) }}°C</p>
            <p class="text-sm text-gray-600">{{ user.weather.condition }}</p>
          </div>
        </div>
        <button 
          @click="showWeather(user.id)"
          class="mt-4 w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors"
        >
          View Details
        </button>
      </div>
    </div>

    <!-- Weather Details Modal -->
    <div 
      v-if="selectedUser" 
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
    >
      <div class="bg-white rounded-lg max-w-lg w-full p-6">
        <div class="flex justify-between items-start">
          <h3 class="text-xl font-bold text-gray-900">{{ selectedUser.name }}'s Weather</h3>
          <button 
            @click="selectedUser = null" 
            class="text-gray-400 hover:text-gray-600"
          >
            <span class="sr-only">Close</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="mt-4">
          <p class="text-4xl font-bold text-gray-900">{{ selectedUser.weather.temperature.toFixed(2) }}°C</p>
          <p class="text-lg text-gray-600">{{ selectedUser.weather.condition }}</p>
          <div class="mt-4 grid grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-500">Humidity</p>
              <p class="font-semibold text-gray-900">{{ selectedUser.weather.humidity }}%</p>
            </div>
            <div>
              <p class="text-sm text-gray-500">Wind Speed</p>
              <p class="font-semibold text-gray-900">{{ selectedUser.weather.windSpeed }} km/h</p>
            </div>
          </div>
          <p class="mt-4 text-sm text-gray-500">
            Last updated: {{ formatDate(selectedUser.weather.lastUpdated) }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../api';
import 'animate.css'; // Importar Animate.css

export default {
  name: 'UserList',
  data() {
    return {
      users: [],
      selectedUser: null,
      loading: true,
      error: false,
    };
  },
  async created() {
    await this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await api.getUsers();
        this.users = response.data.map(user => ({
          ...user,
          weather: {
            ...user.weather,
            temperature: parseFloat(user.weather.temperature) || 0,
          },
        }));
      } catch (error) {
        console.error('Error al obtener los usuarios:', error);
        this.error = 'Error al cargar los usuarios. Inténtalo de nuevo.';
      } finally {
        this.loading = false;
      }
    },
    async refreshData() {
      this.loading = true;
      this.error = false;
      await this.fetchUsers();
    },
    async showWeather(userId) {
      try {
        const response = await api.getWeather(userId);
        this.selectedUser = response.data;
      } catch (error) {
        console.error('Error al obtener el clima:', error);
        this.error = 'Error al obtener el clima. Inténtalo de nuevo.';
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleString(); // Formato de fecha legible
    },
  },
};
</script>

<style scoped>
/* Estilos adicionales si es necesario */
</style>