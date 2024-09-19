<template>
  <div class="py-3 relative">
    <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <tbody class="bg-white divide-y divide-gray-200 ">
            <!-- <tr v-for="surat in surats.data" :key="surat.id"> -->
              <tr class="hover:bg-slate-100 relative">
              <h2 class="px-3 pt-1 rounded-sm text-white bg-slate-500 w-52 flex items-center absolute top-0 left-0">surat baru telah diupload</h2>
              <td class="px-6 pt-7 pb-4 whitespace-pre-wrap">
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
                <font-awesome-icon :icon="['far', 'bookmark']" />
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
</template>
<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>