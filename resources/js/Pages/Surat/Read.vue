<script setup>
import { ref,watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { VuePDF, usePDF } from '@tato30/vue-pdf'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { usePage, useForm } from '@inertiajs/vue3';

// Get props and page data
const { laporan, bookmarkedLaporans } = usePage().props;

// Track the local bookmark state
const bookmarks = ref(bookmarkedLaporans);

// Watch for changes in the initial bookmarks prop
watch(() => bookmarkedLaporans, (newBookmarks) => {
  bookmarks.value = newBookmarks;
});

// Initialize form with default fields
const form = useForm({
  laporan_id: null, // Define the field here
});

// Function to check if a Laporan is bookmarked
const isBookmarked = (laporanId) => {
  return bookmarks.value.includes(laporanId);
};

// Toggle bookmark status
const toggleBookmark = (laporanId) => {
  form.laporan_id = laporanId; // Set the laporan_id field dynamically

  if (isBookmarked(laporanId)) {
    // If already bookmarked, remove the bookmark
    form.delete(`/bookmarks/${laporanId}`, {
      onSuccess: () => {
        console.log(`Laporan ${laporanId} removed from bookmarks.`);
        // Remove from local bookmarks after successful deletion
        bookmarks.value = bookmarks.value.filter(id => id !== laporanId);
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  } else {
    // If not bookmarked, add the bookmark
    form.post('/bookmarks', {
      onSuccess: () => {
        console.log(`Laporan ${laporanId} added to bookmarks.`);
        // Add to local bookmarks after successful addition
        bookmarks.value.push(laporanId);
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  }
};

const page = ref(1)
const pdfPath = ref(`/storage/${laporan.surat_file}`); // Adjust the path as needed
const { pdf, pages } = usePDF(pdfPath)
</script>

<template>
  <AppLayout title="read">
    <template #header>
      <div class="flex justify-between h-10">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            SK Elektro
          </h2>
          <button @click="toggleBookmark(laporan.id)"
            class="text-gray-800 dark:text-white hover:text-gray-700 py-4 px-6 text-sm focus:outline-none leading-none rounded">
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
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">

        <p>{{ laporan.judul }} </p>
        
        <p>kategori : {{ laporan.kategori.nama}} </p>
        
        <p>kategori : {{ laporan.sub_kategori.nama}} </p>
        
        <p class="">
          deskripsi : {{ laporan.deskripsi }}
        </p>
        <div class=" border-t-2 flex justify-center mt-5">
          <VuePDF :pdf="pdf" :page="page" :scale="1.50" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>