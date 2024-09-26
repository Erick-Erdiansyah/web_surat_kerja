<template>
  <div class="py-3">
    <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="laporan in bookmarkedLaporans" :key="laporan.id" class="hover:bg-slate-100">
              <!-- Main content with judul, kategori, and sub_kategori -->
              <td class="px-6 py-4 whitespace-pre-wrap">
                <div class="flex items-center">
                  <div>
                    <p class="font-medium text-gray-900">{{ laporan.judul }}</p>
                    <p class="text-xs text-gray-500">Kategori: {{ laporan.kategori.nama ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-500">Sub Kategori: {{ laporan.sub_kategori.nama ?? 'N/A' }}</p>
                  </div>
                </div>
              </td>

              <!-- Empty space -->
              <td class="w-10"></td>

              <!-- Read link -->
              <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                <Link :href="`/sk/${laporan.id}/read`"
                  class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                  <font-awesome-icon :icon="['far', 'eye']" />
                </Link>
              </td>

              <!-- Bookmark button -->
              <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                <button @click="toggleBookmark(laporan.id)" 
                  class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                  <font-awesome-icon :icon="isBookmarked(laporan.id) ? ['fas', 'bookmark'] : ['far', 'bookmark']" />
                </button>
              </td>

              <!-- Edit link -->
              <td class="pr-6 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                <Link :href="`/sk/${laporan.id}/edit`"
                  class="text-gray-900 hover:text-gray-700 hover:bg-slate-400 py-4 px-6 text-sm focus:outline-none leading-none bg-slate-200 rounded">
                  <font-awesome-icon :icon="['far', 'pen-to-square']" />
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { usePage, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';


// Retrieve the bookmarked laporans
const { bookmarkedLaporans } = usePage().props;

// Track the local bookmark state
const bookmarks = ref(bookmarkedLaporans.map(laporan => laporan.id));

// Watch for changes in the initial bookmarks prop
watch(() => bookmarkedLaporans, (newBookmarks) => {
  bookmarks.value = newBookmarks.map(laporan => laporan.id);
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
</script>
