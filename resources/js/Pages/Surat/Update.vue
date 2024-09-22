<template>
  <AppLayout title="Update">
    <form @submit.prevent="submit" class="max-w-xl mx-auto my-8 bg-slate-100 px-6 pb-6 rounded-md" enctype="multipart/form-data">
      <!-- Jurusan -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700 pt-3" for="jurusan_id">
          Jurusan
        </label>
        <select v-model="form.jurusan_id" id="jurusan_id" class="border border-gray-400 p-2 w-full rounded-lg">
          <option value="" disabled>Pilih Jurusan</option>
          <option v-for="jurus in Jurusan" :key="jurus.id" :value="jurus.id">{{ jurus.jurusan }}</option>
        </select>
      </div>

      <!-- Kategori -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="kategori_id">
          Kategori
        </label>
        <select v-model="form.kategori_id" id="kategori_id" class="border border-gray-400 p-2 w-full rounded-lg">
          <option value="" disabled>Pilih Kategori</option>
          <option v-for="kategori in Kategories" :key="kategori.id" :value="kategori.id">{{ kategori.nama }}</option>
        </select>
      </div>

      <!-- Sub Kategori -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="sub_kategori_id">
          Sub Kategori
        </label>
        <select v-model="form.sub_kategori_id" id="sub_kategori_id" class="border border-gray-400 p-2 w-8/12 rounded-lg">
          <option value="" disabled>Pilih Sub Kategori</option>
          <option v-for="sub in SubKategories" :key="sub.id" :value="sub.id">{{ sub.nama }}</option>
        </select>
        <SubCategori :Kategories="Kategories" />
      </div>

      <!-- Nomor Surat -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="nomorSurat">
          Nomor Surat
        </label>
        <input v-model="form.nomor_surat" type="text" id="nomorSurat"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="Nomor Surat">
      </div>

      <!-- Tanggal Surat -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="tanggal_surat">
          Tanggal Surat
        </label>
        <input v-model="form.tanggal_surat" type="text" id="tanggal_surat"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="Tanggal Surat">
      </div>

      <!-- Judul Surat -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="judul">
          Judul Surat
        </label>
        <input v-model="form.judul" type="text" id="judul"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="Judul Surat">
      </div>

      <!-- Deskripsi Surat -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="desc">
          Deskripsi Surat
        </label>
        <textarea v-model="form.deskripsi" id="desc"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="Deskripsi Surat"></textarea>
      </div>

      <!-- Tahun Ajaran -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="tahunAjaran">
          Tahun Ajaran
        </label>
        <input v-model="form.tahun_ajaran" type="text" id="tahunAjaran"
          class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="Tahun Ajaran">
      </div>

      <!-- File Upload -->
      <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="file">
          File
        </label>
        <input type="file" @change="handleFileChange" id="file" class="border border-gray-400 p-2 w-full rounded-lg">
      </div>

      <!-- Submit Button -->
      <div class="bm-6">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Perbaharui
        </PrimaryButton>
      </div>
    </form>
  </AppLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SubCategori from './Partials/SubCategori.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

let props = defineProps({
  Kategories: Array,
  SubKategories: Array,
  Jurusan: Array,
  laporan: Object // Pass existing data as a prop
});

// Initialize form with existing data
let form = useForm({
  jurusan_id: props.laporan.jurusan_id || '',
  kategori_id: props.laporan.kategori_id || '',
  sub_kategori_id: props.laporan.sub_kategori_id || '',
  nomor_surat: props.laporan.nomor_surat || '',
  tanggal_surat: props.laporan.tanggal_surat || '',
  judul: props.laporan.judul || '',
  deskripsi: props.laporan.deskripsi || '',
  tahun_ajaran: props.laporan.tahun_ajaran || '',
  file: null,
});

// Handle file change
const handleFileChange = (e) => {
  form.file = e.target.files[0];
};

// Submit function
let submit = () => {
  form.put(`/sk/${props.laporan.id}/update`);
}
</script>
