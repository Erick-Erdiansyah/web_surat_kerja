<template>

  <Head :title="'Read'" />
  <div class="bg-gray-400">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="opacity-80 z-50 sm:top-10 md:top-56 ml-2 fixed rounded-md">
        <div class="mb-1">
          <button @click="goBack" class="text-gray-800 rounded-lg bg-gray-400 dark:text-white p-4 text-xl">
            <font-awesome-icon :icon="['fas', 'caret-left']" /> Kembali
          </button>
        </div>
        <div class="">
          <button @click="handleAuthBookmark($page.props.auth.user)"
            class="text-gray-800 rounded-lg bg-gray-400 dark:text-white p-4 text-xl">
            <font-awesome-icon :icon="isBookmarked(laporan.id) ? ['fas', 'bookmark'] : ['far', 'bookmark']" /> Tandai
          </button>
          <ConfirmationModal v-if="!$page.props.auth.user" :show="isModalOpen" :max-width="'lg'" @close="closeModal"
            title="masuk">
            <template #content>
              masuk dulu mas bro
            </template>
          </ConfirmationModal>
        </div>
      </div>
      <div class="flex justify-center">
        <div class=" bg-gray-400 opacity-80 z-50 flex bottom-0 fixed items-center rounded-md">
          <button @click="page = page > 1 ? page - 1 : page" class="text-gray-800 dark:text-white p-4 text-xl">
            <font-awesome-icon :icon="['fas', 'caret-left']" />
          </button>
          <span>{{ page }} / {{ pages }}</span>
          <button @click="page = page < pages ? page + 1 : page" class="text-gray-800 dark:text-white p-4 text-xl">
            <font-awesome-icon :icon="['fas', 'caret-right']" />
          </button>
        </div>
      </div>
      <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg p-5">
        <div class="p-5 bg-slate-200 dark:bg-slate-700 rounded sm:rounded-lg">
          <h1 class="text-xl dark:text-white font-semibold mb-2">{{ laporan.judul }} </h1>

          <p class="dark:text-white">jenis surat : {{ laporan.jenis }}</p>

          <p class="dark:text-white">kategori : {{ laporan.kategori.nama }} </p>

          <p class="dark:text-white">sub kategori : {{ laporan.sub_kategori.nama }} </p>

          <p class="dark:text-white">deskripsi : {{ laporan.deskripsi }}</p>
        </div>
        <div class=" border-t-2 flex justify-center mt-5">
          <VuePDF :pdf="pdf" :page="page" :scale="1.25" />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, watch } from 'vue'
import { VuePDF, usePDF } from '@tato30/vue-pdf'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

const { laporan } = usePage().props;

const goBack = () => {
  if (window.history.length > 1) {
    window.history.back();
  } else {
    Inertia.visit('/'); // Fallback to Welcome
  }
}

const page = ref(1)
const pdfPath = ref(`/storage/${laporan.surat_file}`);
const { pdf, pages } = usePDF(pdfPath)


const isModalOpen = ref(false);

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};


const handleAuthBookmark = (auth) => {
  if (auth) {
    toggleBookmark(laporan.id)
  } else {
    openModal()
  }
}


let bookmarks = ref('');

const { bookmarkedLaporans } = usePage().props;

if (typeof bookmarkedLaporans[0] === 'number') {
  bookmarks = ref(bookmarkedLaporans);
} else {
  bookmarks = ref(bookmarkedLaporans.map(laporan => laporan.id));
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
</script>
