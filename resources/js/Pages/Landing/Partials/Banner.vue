<template>
  <div class="w-3/4 flex flex-col h-screen bg-gradient-to-b from-black to-gray-600">
    <div 
      class="w-full text-5xl flex-grow bg-cover bg-center image" 
      :style="{ 'background-image': `url(${imageUrl})` }">
      <h1 class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja</h1>
      <h1 class="text-7xl font-semibold text-white mt-4 px-4">Teknik Elektro</h1>
      <p class="text-xl font-semibold text-white mt-4 px-4 pb-28 mb-80">
        Sederhanakan Arsip Surat Anda : <br>
        Efisiensi dan Keamanan Dalam <br>
        Satu Aplikasi
      </p>
      <p class="mt-80 hidden">hello</p>
    </div>
  </div>
</template>

<script setup>
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
