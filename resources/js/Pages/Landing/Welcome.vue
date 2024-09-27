<template>
  <div class="flex justify-between max-h-full h-4/5">
    <div 
      class=" w-3/4 text-5xl h-full bg-cover bg-center image" 
      :style="{ 'background-image': `url(${imageUrl})` }">
      <h1 class=" text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja</h1>
      <h1 class=" text-7xl font-semibold text-white mt-4 px-4">teknik Elektro</h1>
      <p class=" text-3xl font-semibold text-white mt-4 px-4 pb-28 mb-80">
        Sederhanakan Arsip Surat Anda : <br>
        Efisiensi dan Keamanan Dalam <br>
        Satu Aplikasi
      </p>
      <p class=" mt-80 hidden">hello</p>
    </div>
    
    <div class="flex-grow bg-white overflow-hidden p-4">
      <Login />
    </div>
  </div>
</template>

<script setup>
import Login from './Partials/Login.vue';
import Register from './Partials/Register.vue';
const imageUrl = new URL('@/assets/images/background.svg', import.meta.url);
</script>

<style>
.image {
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  width: 100%;
  height: 100%;
}
</style>
