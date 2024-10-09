<template>
  <AppLayout title="read">
    <template #header>
      <div class="flex justify-between h-10">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            SK Elektro
          </h2>
          <button @click="toggleBookmark(laporan.id)"
            class="text-gray-800 dark:text-white hover:text-gray-700 py-4 px-6 text-xl focus:outline-none leading-none rounded">
            <font-awesome-icon :icon="isBookmarked(laporan.id) ? ['fas', 'bookmark'] : ['far', 'bookmark']" />
          </button>
        </div>
        <div class="flex items-center">
          <button @click="page = page > 1 ? page - 1 : page" class="text-gray-800 dark:text-white p-4 text-xl">
            <font-awesome-icon :icon="['fas', 'caret-left']" />
          </button>
          <span>{{ page }} / {{ pages }}</span>
          <button @click="page = page < pages ? page + 1 : page" class="text-gray-800 dark:text-white p-4 text-xl">
            <font-awesome-icon :icon="['fas', 'caret-right']" />
          </button>
        </div>
        <div class=" pr-32"></div>
      </div>
    </template>
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 pt-36">
      <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg p-5">
        <div class="p-5 bg-slate-200 dark:bg-slate-700 rounded sm:rounded-lg">
          <h1 class="text-xl dark:text-white font-semibold mb-2">{{ laporan.judul }} </h1>

          <p class="dark:text-white">kategori : {{ laporan.kategori.nama }} </p>

          <p class="dark:text-white">kategori : {{ laporan.sub_kategori.nama }} </p>

          <p class="dark:text-white">deskripsi : {{ laporan.deskripsi }}</p>
        </div>
        <div class=" border-t-2 flex justify-center mt-5">
          <VuePDF :pdf="pdf" :page="page" :scale="1.50" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
<script setup>
import { ref, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { VuePDF, usePDF } from '@tato30/vue-pdf'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { usePage, useForm } from '@inertiajs/vue3';

const { laporan, bookmarkedLaporans } = usePage().props;

const bookmarks = ref(bookmarkedLaporans);

watch(() => bookmarkedLaporans, (newBookmarks) => {
  bookmarks.value = newBookmarks;
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
        console.log(`Laporan ${laporanId} removed from bookmarks.`);
        bookmarks.value = bookmarks.value.filter(id => id !== laporanId);
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  } else {
    form.post('/bookmarks', {
      onSuccess: () => {
        console.log(`Laporan ${laporanId} added to bookmarks.`);
        bookmarks.value.push(laporanId);
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  }
};

const page = ref(1)
const pdfPath = ref(`/storage/${laporan.surat_file}`);
if (pdfPath) {
  const { pdf, pages } = usePDF(pdfPath)
} else {
  const pdfPath = ref(`/storage/${laporan.surat_file}`);
  const { pdf, pages } = usePDF(pdfPath)
}
</script>
