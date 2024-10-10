<template>
  <button @click="isModalOpen = true" v-tippy="{ content: 'Lihat', theme: 'dark', arrow: true }"
    class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 hover:rounded-lg py-2 px-2 text-xl focus:outline-none leading-none rounded">
    <font-awesome-icon :icon="['far', 'eye']" />
  </button>
  <DialogModal :show="isModalOpen" :closeable="true" @close="handleCloseModal">
    <!-- <template #title>
      Tambah sub kategori
    </template> -->
    <template #content>
      <div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div>
            <div class="flex justify-end">
              <button @click="toggleBookmark(props.id)" v-tippy="{ content: 'Tandai', theme: 'dark', arrow: true }"
                class="text-gray-800 hover:text-gray-700 px-6 text-xl focus:outline-none leading-none rounded">
                <font-awesome-icon :icon="isBookmarked(props.id) ? ['fas', 'bookmark'] : ['far', 'bookmark']" />
              </button>
            </div>
            <div class="flex justify-center">
              <button @click="page = page > 1 ? page - 1 : page" class="text-gray-800 p-4 text-xl"
                v-tippy="{ content: 'Halaman sebelumnya', theme: 'dark', arrow: true, placement: 'bottom' }">
                <font-awesome-icon :icon="['fas', 'caret-left']" />
              </button>
              <span class="mt-5">{{ page }} / {{ pages }}</span>
              <button @click="page = page < pages ? page + 1 : page" class="text-gray-800 p-4 text-xl"
                v-tippy="{ content: 'Halaman selanjutnya', theme: 'dark', arrow: true, placement: 'bottom' }">
                <font-awesome-icon :icon="['fas', 'caret-right']" />
              </button>
            </div>
          </div>
          <div class=" border-t-2 flex justify-center">
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
import { usePage, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue'
import { directive as VTippy } from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'

let props = defineProps({
  id: Number,
  kategori: String,
  sub_kategori: String,
  deskripsi: String,
  jenis: String,
  surat_file: String
})

let bookmarks = ref('');

const isModalOpen = ref(false);

const handleCloseModal = () => {
  isModalOpen.value = false;
  console.log('are we not ?')
  reinitializePDF()
};

const { bookmarkedLaporans } = usePage().props;

if (Array.isArray(bookmarkedLaporans) && typeof bookmarkedLaporans[0] === 'number') {
  console.log('we should be here');
  bookmarks.value = bookmarkedLaporans;
} else if (Array.isArray(bookmarkedLaporans)) {
  bookmarks.value = bookmarkedLaporans.map(laporan => laporan.id);
} else {
  bookmarks.value = [];
}

watch(() => bookmarkedLaporans, (newBookmarks) => {
  bookmarks.value = typeof bookmarkedLaporans[0] === 'number' ? bookmarks.value = newBookmarks : newBookmarks.map(laporan => laporan.id);
});

const form = useForm({
  laporan_id: null,
});

const isBookmarked = (laporanId) => {
  return bookmarks.value.includes(laporanId);
};

const toggleBookmark = (laporanId) => {
  form.laporan_id = laporanId;

  if (isBookmarked(laporanId)) {
    form.delete(`/bookmarks/${laporanId}`, {
      onSuccess: () => {
        bookmarks.value = bookmarks.value.filter(id => id !== laporanId);
        router.reload({
          preserveScroll: false,
          preserveState: false,
        });
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  } else {
    form.post('/bookmarks', {
      onSuccess: () => {
        bookmarks.value.push(laporanId);
        router.reload({
          preserveScroll: false,
          preserveState: false,
        });
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  }
};

let pdf, pages;

const page = ref(1);
const pdfPath = ref(`/storage/${props.surat_file}`);

({ pdf, pages } = usePDF(pdfPath));

function reinitializePDF() {
  ({ pdf, pages } = usePDF(pdfPath));
}
</script>
