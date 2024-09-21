<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { throttle } from 'lodash';
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

// let props = defineProps({
//   surats: Object,
//   filters: Object,
//   can: Object,
// })

// let search = ref(props.filters.search);

// watch(search, throttle(function (value) {
//   router.get('/sk/index', { search: value }, {
//     // Keeps the current pagination and state
//     preserveState: true,
//     replace: true
//   });
// }, 500));

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
          <!-- <Link v-if="can.createUser" href="/users/create" class="text-blue-500 text-sm ml-3">create new user</Link> -->
        </div>
        <!-- <input v-model="search" type="text" class="border px-2 rounded-lg" placeholder="search..."> -->
        <input type="text" class="border rounded-lg h-10 mt-1" placeholder="search...">
      </div>
    </template>

    <div class="py-3">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200 ">
              <!-- <tr v-for="surat in surats.data" :key="surat.id"> -->
              <tr class="hover:bg-slate-100">
                <td class="px-6 py-4 whitespace-pre-wrap">
                  <div class="flex items-center">
                    <div>
                      <div class="">
                        <!-- {{ surat.judul }} -->
                        <p class="font-medium text-gray-900">deskripsi atau judul dari suratnya</p>
                        <p class="text-xs text-gray-500">kategori :</p>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="w-10">
                </td>
                <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                  <Link :href="`/sk/read`"
                    class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                  <font-awesome-icon :icon="['far', 'eye']" />
                  </Link>
                </td>
                <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                  <Link :href="`/sk/bookmark`"
                    class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                  <font-awesome-icon :icon="['far', 'bookmark']"/>
                  </Link>
                </td>
                <td class="pr-6 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                  <Link :href="`/sk/update`"
                    class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                  <font-awesome-icon :icon="['far', 'pen-to-square']" />
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- paginator -->
        <!-- <Pagination :links="surats.links" /> -->
      </div>
    </div>
  </AppLayout>
</template>
