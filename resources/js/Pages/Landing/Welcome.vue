<template>
  <div class="flex justify-between max-h-full h-4/5">
    <div 
      class="w-80 h-full bg-cover bg-center image" 
      :style="{ 'background-image': `url(${imageUrl})` }">
      <h2 class="font-semibold text-xl bg-black dark:text-white text-gray-800 leading-tight p-2">
        hello world 
      </h2>
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
