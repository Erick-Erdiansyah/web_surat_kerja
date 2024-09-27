<template>
  <div class="min-h-screen bg-gradient-to-b from-black to-orange-800 flex justify-center items-center">
    <div class="flex w-full justify-end pr-20">
      <div class="ml-12 w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <!-- Toggle Buttons -->
        <div class="flex justify-center mb-8">
          <button 
            @click="showLogin = true" 
            class="px-4 py-2 rounded-l-lg" 
            :class="showLogin ? 'bg-gray-800 text-white' : 'bg-gray-300 text-gray-800'">
            Masuk
          </button>
          <button 
            @click="showLogin = false" 
            class="px-4 py-2 rounded-r-lg" 
            :class="!showLogin ? 'bg-gray-800 text-white' : 'bg-gray-300 text-gray-800'">
            Registrasi
          </button>
        </div>

        <!-- Form Header -->
        <h2 class="text-3xl text-center mb-6">{{ showLogin ? 'Masuk' : 'Register' }}</h2>

        <!-- Form Section -->
        <form>
          <input 
            type="email" 
            placeholder="Masukkan Email" 
            class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300" 
          />
          <input 
            type="password" 
            placeholder="Masukkan Password" 
            class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300" 
          />
          <div v-if="showLogin" class="flex justify-between items-center mb-4">
            <a href="#" class="text-sm text-gray-500 hover:underline">Lupa Password?</a>
          </div>
          <button 
            type="submit" 
            class="w-full bg-gray-800 text-white py-2 rounded-lg hover:bg-gray-700">
            {{ showLogin ? 'Masuk' : 'Registrasi' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Reactive state to toggle between Login and Register
const showLogin = ref(true);
</script>
