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
          <div class="bg-gray-200 opacity-100 overflow-hidden shadow-xl sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-slate-100 dark:hover:bg-slate-800 dark:bg-slate-700 relative">
                  <td class="px-6 py-4 whitespace-pre-wrap">
                    <div class="flex items-center">
                      <div>
                        <p class="font-medium text-gray-900 dark:text-white">hello</p>
                      </div>
                    </div>
                  </td>
                  <td class="w-10"></td>
                  <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                    <button
                      class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 py-4 px-6 text-2xl focus:outline-none leading-none rounded">
                      <font-awesome-icon :icon="['far', 'eye']" />
                    </button>
                  </td>
                  <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                    <button
                      class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 py-4 px-6 text-2xl focus:outline-none leading-none rounded">
                      <font-awesome-icon :icon="['far', 'bookmark']" />
                    </button>
                  </td>
                  <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                    <button
                      class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 py-4 px-6 text-2xl focus:outline-none leading-none rounded">
                      <font-awesome-icon :icon="['far', 'trash-can']" />
                    </button>
                  </td>
                  <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                    <button
                      class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 py-4 px-6 text-2xl focus:outline-none leading-none rounded">
                      <font-awesome-icon :icon="['far', 'pen-to-square']" />
                    </button>
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
