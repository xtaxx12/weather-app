<template>
  <div>
    <!-- Modal del clima -->
    <div v-if="selectedUser" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg max-w-lg w-full p-6">
        <div class="flex justify-between items-start">
          <h3 class="text-xl font-bold text-gray-900">{{ selectedUser.name }}'s Weather</h3>
          <button @click="selectedUser = null" class="text-gray-400 hover:text-gray-600">
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
            Last updated: {{ selectedUser.weather.lastUpdated }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>