<template>
  <button @click="isModalOpen = true" class="bg-gray-400 hover:bg-gray-500 text-white ml-2 px-4 py-2 rounded">
    <font-awesome-icon :icon="['far', 'square-plus']" />
  </button>
  <DialogModal :show="isModalOpen" :maxWidth="'lg'" :closeable="true" @close="handleCloseModal">
    <template #title>
      Tambah sub kategori
    </template>
    <template #content>
      <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
        <div class="mb-6">
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
          <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="sub">
            Nama sub kategori
          </label>
          <input v-model="form.sub" type="text" name="sub" id="sub" class="border border-gray-400 p-2 w-full rounded-lg"
            required placeholder="nama sub kategori">
          <div v-if="form.errors.sub" v-text="form.errors.sub" class="text-red-500 text-xs  mt-1"></div>
        </div>
        <div class="bm-6">
          <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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

const isModalOpen = ref(false);

const handleCloseModal = () => {
  isModalOpen.value = false;
};

let form = useForm({
  name: '',
  email: '',
  password: ''
})

let submit = () => {
  form.post('index')
}

</script>