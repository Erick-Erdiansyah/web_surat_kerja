<template>
  <div
    :class="$page.props.auth.user ? ' w-full flex flex-col h-screen bg-gradient-to-b from-black to-gray-600' : 'w-3/4 flex flex-col h-screen bg-gradient-to-b from-black to-gray-600'">
    <div class="w-full text-5xl flex-grow bg-cover bg-center image" :style="{ 'background-image': `url(${imageUrl})` }">
      <div :class="$page.props.auth.user ? 'text-center' : ''">
        <h1 v-if="$page.props.auth.user" class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja Teknik
          Elektro</h1>
        <h1 v-if="!$page.props.auth.user" class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja <br>
          Teknik Elektro</h1>
        <h1 v-if="$page.props.auth.user" class="text-7xl font-semibold text-white mt-4 px-4 underline">
          <Link href="/dashboard">Beranda</Link>
        </h1>
        <p class="text-2xl font-semibold text-white mt-4 px-4 pb-28 mb-80">
          Efisienkan manajemen dokumen dengan arsip digital kami. <br> Sistem ini memudahkan Anda dalam menyimpan,
          mencari,
          dan mengakses surat kerja dengan cepat dan aman. <br> Kelola berbagai surat dan dokumen penting yang berkaitan
          dengan proyek, riset, dan kegiatan operasional teknik elektro dengan mudah.
        </p>
      </div>
      <p class="mt-80 hidden">hello</p>
    </div>
  </div>
</template>

<script setup>
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
