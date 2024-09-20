<template>
  <AppLayout title="Update">
    <form @submit.prevent="submit" class="max-w-md mx-auto my-8 bg-slate-100 px-3 pb-6 rounded-md">
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700 pt-3" for="nomorSurat">
          jurusan
        </label>
        <!-- something here -->
        <!-- <select name="kategori_from_id" id="kategori_from_id" v-model="input.from.kategori_from_id">
          <option v-for="kategori in kategories" v-bind:key="'from-'+kategori.id" :value="kategori.id" value="">{{ kategori.name }}</option>
        </select> -->
        <select name="" id="" class="border border-gray-400 p-2 w-full rounded-lg">
          <option value="">jurusan 1</option>
          <option value="">jurusan 2</option>
          <option value="">jurusan 3</option>
        </select>
      </div>
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="nomorSurat">
          kategori
        </label>
        <!-- something here -->
        <!-- <select name="kategori_from_id" id="kategori_from_id" v-model="input.from.kategori_from_id">
          <option v-for="kategori in kategories" v-bind:key="'from-'+kategori.id" :value="kategori.id" value="">{{ kategori.name }}</option>
        </select> -->
        <select name="" id="" class="border border-gray-400 p-2 w-full rounded-lg">
          <option value="">kategori 1</option>
          <option value="">kategori 2</option>
          <option value="">kategori 3</option>
        </select>
      </div>
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="nomorSurat">
          sub kategori
        </label>
        <!-- something here -->
        <!-- <select name="kategori_from_id" id="kategori_from_id" v-model="input.from.kategori_from_id">
          <option v-for="kategori in kategories" v-bind:key="'from-'+kategori.id" :value="kategori.id" value="">{{ kategori.name }}</option>
        </select> -->
        <select name="" id="" class="border border-gray-400 p-2 w-8/12 rounded-lg">
          <option value="">sub 1</option>
          <option value="">sub 2</option>
          <option value="">sub 3</option>
        </select>
        <SubCategori />
      </div>
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="nomorSurat">
          nomor surat
        </label>
        <input v-model="form.nomorSurat" type="text" name="nomorSurat" id="nomorSurat"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="nomor surat">
        <div v-if="form.errors.nomorSurat" v-text="form.errors.nomorSurat" class="text-red-500 text-xs  mt-1"></div>
      </div>
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="tanggal">
          tanggal surat
        </label>
        <input v-model="form.tanggal" type="text" name="tanggal" id="tanggal"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="tanggal surat">
        <div v-if="form.errors.tanggal" v-text="form.errors.tanggal" class="text-red-500 text-xs  mt-1"></div>
      </div>
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="judul">
          judul surat
        </label>
        <input v-model="form.judul" type="text" name="judul" id="judul"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="judul surat">
        <div v-if="form.errors.judul" v-text="form.errors.judul" class="text-red-500 text-xs  mt-1"></div>
      </div>
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="desc">
          deskripsi surat
        </label>
        <textarea v-model="form.desc" type="text" name="desc" id="desc"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="desc surat"></textarea>
        <div v-if="form.errors.desc" v-text="form.errors.desc" class="text-red-500 text-xs  mt-1"></div>
      </div>
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="tahunAjaran">
          tahun ajaran
        </label>
        <input v-model="form.tahunAjaran" type="text" name="tahunAjaran" id="tahunAjaran"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="tahun ajaran">
        <div v-if="form.errors.tahunAjaran" v-text="form.errors.tahunAjaran" class="text-red-500 text-xs  mt-1"></div>
      </div>
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="file">
          file
        </label>
        <input v-on:change="form.file" type="file" name="file" id="file"
          class="border border-gray-400 p-2 w-full rounded-lg" required>
        <div v-if="form.errors.file" v-text="form.errors.file" class="text-red-500 text-xs  mt-1"></div>
      </div>
      <div class="bm-6">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Perbaharui
        </PrimaryButton>
      </div>
    </form>
  </AppLayout>
</template>
<script setup>
import SubCategori from './Partials/SubCategori.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

let form = useForm({
  name: '',
  email: '',
  password: ''
})

let submit = () => {
  form.post('index')
}

</script>
