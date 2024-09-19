<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { throttle } from 'lodash';
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/vue3';

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
      <div class="flex justify-between">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            SK Elektro
          </h2>
          <Link href="/sk/create" class="text-blue-500 text-sm ml-3">tambah surat baru</Link>
          <!-- <Link v-if="can.createUser" href="/users/create" class="text-blue-500 text-sm ml-3">create new user</Link> -->
        </div>
        <!-- <input v-model="search" type="text" class="border px-2 rounded-lg" placeholder="search..."> -->
        <input type="text" class="border px-2 rounded-lg" placeholder="search...">
      </div>
    </template>

    <div class="py-3">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th>fuck</th>
                <th>fuck</th>
                <th>fuck</th>
                <th>fuck</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 ">
              <!-- <tr v-for="surat in surats.data" :key="surat.id"> -->
              <tr>
                <td class="px-6 py-4 whitespace-pre-wrap w-85">
                  <div class="flex items-center">
                    <div>
                      <div class="">
                        <!-- {{ surat.judul }} -->
                        <p class="font-medium text-gray-900">deskripsi Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit asperiores accusamus omnis officiis fuga deserunt saepe quidem voluptatibus velit. Sapiente.</p>
                        <p class="text-xs text-gray-500">kategori</p>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="whitespace-nowrap text-center text-sm font-medium items-center w-24">
                  <Link :href="`/sk/read`"
                    class="text-indigo-900 hover:text-indigo-900 hover:bg-red-200 py-4 px-6 text-sm focus:outline-none leading-none bg-red-100 rounded">
                  Lihat
                  </Link>
                </td>
                <td class="whitespace-nowrap text-center text-sm font-medium items-center w-24">
                  <Link :href="`/sk/bookmark`"
                    class="text-indigo-900 hover:text-indigo-900 hover:bg-red-200 py-4 px-6 text-sm focus:outline-none leading-none bg-red-100 rounded">
                  bookmark
                  </Link>
                </td>
                <td class="whitespace-nowrap text-center text-sm font-medium items-center w-24">
                  <Link :href="`/sk/update`"
                    class="text-indigo-900 hover:text-indigo-900 hover:bg-red-200 py-4 px-6 text-sm focus:outline-none leading-none bg-red-100 rounded">
                  edit
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
