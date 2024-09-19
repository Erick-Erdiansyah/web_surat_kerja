<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
  <AppLayout title="Read">
    <template #header>
      <div class="flex justify-between">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Judul sk nya
          </h2>
          <Link href="/sk/bookmark" class="text-gray-800 hover:text-gray-600 ml-3 py-4 px-4">
          <font-awesome-icon :icon="['far', 'bookmark']" />
          </Link>
        </div>
      </div>
    </template>
    <div class="py-3">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="px-3 py-3">
            <p>Judul : something something</p>
            <p>Kategori : kategori 1</p>
            <p>Sub kategori : sub 1</p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
