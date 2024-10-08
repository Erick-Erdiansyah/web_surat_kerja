<template>
  <button @click="isModalOpen = true" class="bg-gray-400 hover:bg-gray-500 text-white ml-2 px-4 py-2 rounded"
    v-tippy="{ content: 'Tambah sub kategori', theme: 'dark', arrow: true }">
    <font-awesome-icon :icon="['far', 'square-plus']" />
  </button>
  <DialogModal :show="isModalOpen" :maxWidth="'lg'" :closeable="true" @close="handleCloseModal">
    <template #title>
      <div class="mx-6 mt-6">Tambah sub kategori</div>
    </template>
    <template #content>
      <form @submit.prevent="submit" class="max-w-lg mx-auto mt-8">
        <div class="m-6">
          <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="kategori_id">
            Nama kategori
          </label>
          <select v-model="form.kategori_id" name="kategori_id" id="kategori_id"
            class="border border-gray-400 p-2 w-full rounded-lg">
            <option value="" disabled>Pilih categori</option>
            <option v-for="kategori in Kategories" :key="kategori.id" :value="kategori.id">{{ kategori.nama }}</option>
          </select>
        </div>
        <div class="m-6">
          <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="sub">
            Nama sub kategori
          </label>
          <input v-model="form.nama" type="text" name="sub" id="sub"
            class="border border-gray-400 p-2 w-full rounded-lg" required placeholder="nama sub kategori">
          <div class="text-red-500 text-xs mt-1"></div>
        </div>
        <div class="m-6">
          <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="handleCloseModal">
            Tambah
          </PrimaryButton>
        </div>
      </form>
    </template>
    <template #footer>
      <button @click="handleCloseModal" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded">
        Tutup
      </button>
    </template>
  </DialogModal>
</template>

<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { directive as VTippy } from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'

const isModalOpen = ref(false);

let props = defineProps({
  Kategories: {
    type: Array,
    default: () => [],
  }
});

const handleCloseModal = () => {
  isModalOpen.value = false;
};


let form = useForm({
  kategori_id: '',
  nama: '',
});

// Submit function
let submit = () => {
  form.post('/subkategori/store');
}
</script>
