<template>
  <div
    :class="$page.props.auth.user ? ' w-full flex flex-col h-screen bg-gradient-to-b from-black to-gray-600' : 'w-3/4 flex flex-col h-screen bg-gradient-to-b from-black to-gray-600'">
    <div class="w-full text-5xl flex-grow bg-cover bg-center image" :style="{ 'background-image': `url(${imageUrl})` }">
      <div :class="$page.props.auth.user ? 'text-center' : ''">
        <h1 v-if="$page.props.auth.user" class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja dan
          Surat Tugas Teknik
          Elektro</h1>
        <h1 v-if="!$page.props.auth.user" class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja dan<br>
          Surat Tugas Teknik Elektro</h1>
        <h1 v-if="$page.props.auth.user" class="text-7xl font-semibold text-white mt-4 px-4 underline">
          <Link href="/dashboard">Beranda</Link>
        </h1>
        <div class=" mt-6 sm:pb-6 lg:pb-6 max-w-3xl mx-auto sm:px-6 lg:px-6  bg-gray-600  rounded-lg opacity-70">
          <input v-model="search" type="text" class="border rounded-lg h-10 my-1" placeholder="Cari...">
          <div
            class="bg-gray-200 opacity-100 overflow-hidden max-h-[400px] overflow-y-auto shadow-xl sm:rounded-lg over">
            <table class="min-w-full divide-y divide-gray-200">
              <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-slate-100 dark:hover:bg-slate-800 dark:bg-slate-700 relative"
                  v-for="item in Laporans" :key="item.id" :item="item">
                  <td class="px-4 py-2 whitespace-pre-wrap">
                    <div class="flex items-center">
                      <p v-show="baru(item.created_timestamp)"
                        class="text-sm px-3 pt-1 rounded-sm text-white dark:text-black dark:bg-white bg-slate-900 w-52 flex items-center absolute top-0 left-0">
                        Surat baru telah diupload
                    </p>
                      <div class="flex items-center">
                        <p class="text-gray-900 dark:text-white" :class="baru(item.created_timestamp) ? 'text-base pt-2 font-medium' : ''">
                          {{ item.judul }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="w-10"></td>
                  <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-3">
                    <button v-tippy="{ content: 'Lihat', theme: 'dark', arrow: true }"
                      class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 hover:bg-gray-300 hover:rounded-lg py-2 px-2 text-xl focus:outline-none leading-none rounded">
                      <font-awesome-icon :icon="['far', 'eye']" />
                    </button>
                  </td>
                  <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-3">
                    <Dropdown @visible-change="change" :border="false">
                      <!-- trigger element -->
                      <template #trigger>
                        <button type="button" v-tippy="{ content: 'Info lebih lanjut', theme: 'dark', arrow: true }"
                          class="text-4xl text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 py-2 px-4 hover:bg-gray-300 hover:rounded-lg">
                          <font-awesome-icon :icon="['fas', 'ellipsis-vertical']" />
                        </button>
                      </template>
                      <!-- contents display in dropdown -->
                      <div class="bg-gray-200 border-none text-gray-800">
                        <div class="px-2 py-1 text-xl hover:bg-gray-500 hover:text-white rounded-sm">
                          <font-awesome-icon :icon="['far', 'pen-to-square']" /> ubah
                        </div>
                        <div class="px-2 py-1 text-xl hover:bg-gray-500 hover:text-white rounded-sm">
                          <font-awesome-icon :icon="['far', 'trash-can']" /> hapus
                        </div>
                        <div class="px-2 py-1 text-xl hover:bg-gray-500 hover:text-white rounded-sm">
                          <font-awesome-icon :icon="['far', 'bookmark']" /> bookmark
                        </div>
                        <div class="px-2 py-1 text-xl hover:bg-gray-500 hover:text-white rounded-sm">
                          <font-awesome-icon :icon="['far', 'circle-down']" /> unduh
                        </div>
                      </div>
                    </Dropdown>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <p class="mt-80 hidden">hello</p>
    </div>
  </div>
</template>

<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Dropdown from 'v-dropdown';
import { directive as VTippy } from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'

const imageUrl = new URL('@/assets/images/background.svg', import.meta.url);


let props = defineProps({
  Laporans: Object,
  filters: Object,
})

const baru = (timestamp) => {
  const sekarang = Math.floor(Date.now() / 1000);
  const upload = sekarang - timestamp;
  const seminggu = 7 * 24 * 60 * 60;
  return upload <= seminggu;
};

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
