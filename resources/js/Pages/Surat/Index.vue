<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { throttle } from 'lodash';
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

let props = defineProps({
  Laporans: Object,
  filters: Object,
  can: Object,
});

let search = ref(props.filters.search);

watch(search, throttle((value) => {
  router.get('/sk/index', { search: value }, {
    preserveState: true,
    replace: true
  });
}, 500));
</script>

<template>
  <AppLayout title="index">
    <template #header>
      <div class="flex justify-between h-10">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            SK Elektro
          </h2>
          <Link href="/sk/create" class="text-gray-800 dark:text-gray-200 dark:hover:text-white hover:text-gray-600 ml-3 py-4 px-4">
            <font-awesome-icon :icon="['fas', 'file-circle-plus']" />
          </Link>
        </div>
        <input type="text" class="border rounded-lg h-10 mt-1" placeholder="Search..." v-model="search">
      </div>
    </template>

    <div class="py-3">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="laporan in Laporans.data" :key="laporan.id" class="hover:bg-slate-100">
                <td class="px-6 py-4 whitespace-pre-wrap">
                  <div class="flex items-center">
                    <div>
                      <p class="font-medium text-gray-900">{{ laporan.judul }}</p>
                      <p class="text-xs text-gray-500">Kategori: {{ laporan.kategori ?? 'N/A' }}</p>
                      <p class="text-xs text-gray-500">Sub Kategori: {{ laporan.sub_kategori ?? 'N/A' }}</p>
                    </div>
                  </div>
                </td>
                <td class="w-10"></td>
                <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                  <Link :href="`/sk/${laporan.id}/read`" class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                    <font-awesome-icon :icon="['far', 'eye']" />
                  </Link>
                </td>
                <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                  <Link :href="`/sk/${laporan.id}/bookmark`" class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                    <font-awesome-icon :icon="['far', 'bookmark']"/>
                  </Link>
                </td>
                <td class="pr-6 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                  <Link :href="`/sk/${laporan.id}/edit`" class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                    <font-awesome-icon :icon="['far', 'pen-to-square']" />
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <Pagination :links="Laporans.links" />
      </div>
    </div>
  </AppLayout>
</template>
