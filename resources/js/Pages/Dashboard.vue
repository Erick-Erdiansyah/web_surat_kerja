<template>
    <AppLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl dark:text-white text-gray-800 leading-tight p-2">
          Dashboard
        </h2>
      </template>
      <NewItem :newItems="newItems" />
      <Bookmark :bookmarkedLaporans="bookmarkedLaporans" />
    </AppLayout>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import NewItem from '@/Components/NewItem.vue';
  import Bookmark from '@/Components/Bookmark.vue';
  import { usePage } from '@inertiajs/vue3';
  
  // Fetch props from the server
  const { newItems, bookmarkedLaporans } = usePage().props;
  </script>
  