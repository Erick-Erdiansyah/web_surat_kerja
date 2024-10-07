<template>
  <button @click="isModalOpen = true" v-tippy="{ content: 'Lihat', theme: 'dark', arrow: true }"
    class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 hover:bg-gray-300 hover:rounded-lg py-2 px-2 text-xl focus:outline-none leading-none rounded">
    <font-awesome-icon :icon="['far', 'eye']" />
  </button>
  <DialogModal :show="isModalOpen" :closeable="true" @close="handleCloseModal">
    <!-- <template #title>
      Tambah sub kategori
    </template> -->
    <template #content>
      <div>
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div class="flex justify-center">
            <button @click="page = page > 1 ? page - 1 : page" class="text-gray-800 dark:text-white p-4 text-xl">
              <font-awesome-icon :icon="['fas', 'caret-left']" />
            </button>
            <span class="mt-5">{{ page }} / {{ pages }}</span>
            <button @click="page = page < pages ? page + 1 : page" class="text-gray-800 dark:text-white p-4 text-xl">
              <font-awesome-icon :icon="['fas', 'caret-right']" />
            </button>
          </div>
          <div class="p-5 bg-slate-200 dark:bg-slate-700 rounded sm:rounded-lg">
            <!-- <h1 class="text-xl dark:text-white font-semibold mb-2">{{ laporan.judul }} </h1> -->

            <p class="dark:text-white">kategori : {{ kategori }} </p>

            <p class="dark:text-white">sub kategori : {{ sub_kategori }} </p>

            <p class="dark:text-white">deskripsi : {{ deskripsi }}</p>

            <!-- <p class="dark:text-white">jenis : {{ jenis }}</p> -->
          </div>
          <div class=" border-t-2 flex justify-center mt-5">
            <VuePDF :pdf="pdf" :page="page" :scale="1.25" />
          </div>
        </div>
      </div>
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
import { VuePDF, usePDF } from '@tato30/vue-pdf'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { usePage, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue'
import { directive as VTippy } from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'

const isModalOpen = ref(false);

const handleCloseModal = () => {
  isModalOpen.value = false;
};


// const { laporan, bookmarkedLaporans } = usePage().props;

// const bookmarks = ref(bookmarkedLaporans);

// watch(() => bookmarkedLaporans, (newBookmarks) => {
//   bookmarks.value = newBookmarks;
// });

// const form = useForm({
//   laporan_id: null,
// });

// const isBookmarked = (laporanId) => {
//   return bookmarks.value.includes(laporanId);
// };

// const toggleBookmark = (laporanId) => {
//   form.laporan_id = laporanId;

//   if (isBookmarked(laporanId)) {
//     form.delete(`/bookmarks/${laporanId}`, {
//       onSuccess: () => {
//         console.log(`Laporan ${laporanId} removed from bookmarks.`);
//         bookmarks.value = bookmarks.value.filter(id => id !== laporanId);
//       },
//       onError: (errors) => {
//         console.log('Error:', errors);
//       },
//     });
//   } else {
//     form.post('/bookmarks', {
//       onSuccess: () => {
//         console.log(`Laporan ${laporanId} added to bookmarks.`);
//         bookmarks.value.push(laporanId);
//       },
//       onError: (errors) => {
//         console.log('Error:', errors);
//       },
//     });
//   }
// };


let props = defineProps({
  kategori: String,
  sub_kategori: String,
  deskripsi: String,
  jenis: String,
  surat_file: String
})

const page = ref(1)
const pdfPath = ref(`/storage/${props.surat_file}`);
const { pdf, pages } = usePDF(pdfPath)
</script>
