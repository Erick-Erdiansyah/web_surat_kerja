<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { throttle } from 'lodash';
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/vue3';

let props = defineProps({
  surats: Object,
  filters: Object,
  can: Object,
})

let search = ref(props.filters.search);

watch(search, throttle(function (value) {
  router.get('/surat', { search: value }, {
    // Keeps the current pagination and state
    preserveState: true,
    replace: true
  });
}, 500));

</script>

<template>
  <AppLayout title="Surat">
    <template #header>
      <div class="flex justify-between">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            SK Elektro
          </h2>
          <!-- <Link v-if="can.createUser" href="/users/create" class="text-blue-500 text-sm ml-3">create new user</Link> -->
        </div>
        <input v-model="search" type="text" class="border px-2 rounded-lg" placeholder="search...">
      </div>
    </template>

    <div class="py-3">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200 ">
              <!-- <tr v-for="surat in surats.data" :key="surat.id"> -->
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div>
                      <div class="text-sm font-medium text-gray-900">
                        <!-- {{ surat.judul }} -->
                          deskripsi
                      </div>
                    </div>
                  </div>
                </td>
                <td class="py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Link :href="`/sk/read`" class="text-indigo-900 hover:text-indigo-900 hover:underline">
                    
                  </Link>
                </td>
                <td class="py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Link :href="`/sk/bookmark`" class="text-indigo-900 hover:text-indigo-900 hover:underline">
                    <font-awesome-icon :icon="['far', 'bookmark']" />
                  </Link>
                </td>
                <td class="pr-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Link :href="`/sk/edit`" class="text-indigo-900 hover:text-indigo-900 hover:underline">edit
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
