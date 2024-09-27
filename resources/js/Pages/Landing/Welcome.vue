<template>
  <div class="flex justify-between max-h-full">
    <div class=" w-80 h-20" :style="{'background-image':`url(${imageUrl})`,'background-size':`100%`}">
      <!-- <img :src="imageUrl" alt="img"/> -->
      <h2 class="font-semibold text-xl bg-black dark:text-white text-gray-800 leading-tight p-2">
      </h2>
    </div>
    <div class="bg-white overflow-hidden">
      <h2 class="font-semibold text-xl dark:text-white text-gray-800 leading-tight p-2">
        Dashboard
      </h2>
    </div>
  </div>
</template>

<script setup>
const imageUrl = new URL('@/assets/images/background.svg', import.meta.url);
</script>
