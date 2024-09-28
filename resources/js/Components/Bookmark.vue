<template>
  <div class="py-3">
    <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="laporan in bookmarkedLaporans" :key="laporan.id"
              class="hover:bg-slate-100 dark:hover:bg-slate-800 dark:bg-slate-700">
              <td class="px-6 py-4 whitespace-pre-wrap">
                <a :href="`/sk/${laporan.id}/read`" class="block w-full h-full">
                  <div class="flex items-center">
                    <div>
                      <p class="font-medium text-gray-900 dark:text-white">{{ laporan.judul }}</p>
                      <p class="text-xs text-gray-500 dark:text-gray-300">Kategori: {{ laporan.kategori.nama ?? 'N/A' }}
                      </p>
                      <p class="text-xs text-gray-500 dark:text-gray-300">Sub Kategori: {{ laporan.sub_kategori.nama ??
                        'N/A' }}</p>
                    </div>
                  </div>
                </a>
              </td>
              <td class="w-10"></td>
              <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                <button @click="toggleBookmark(laporan.id)"
                  class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 py-4 px-6 text-2xl focus:outline-none leading-none rounded">
                  <font-awesome-icon :icon="isBookmarked(laporan.id) ? ['fas', 'bookmark'] : ['far', 'bookmark']" />
                </button>
              </td>
             
              <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                <button @click="openModal"
                  class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 py-4 px-6 text-2xl focus:outline-none leading-none rounded">
                  <font-awesome-icon :icon="['far', 'trash-can']" />
                </button>

                <ConfirmationModal :show="isModalOpen" @close="closeModal" title="Confirm Deletion">
                  <template #content>
                    Are you sure you want to delete this item?
                  </template>

                  <template #footer>
                    <button @click="closeModal" class="mr-2 px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button @click="() => { remove(item.id); closeModal(); }"
                      class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
                  </template>
                </ConfirmationModal>

              </td>

              <td class="pr-6 whitespace-nowrap text-center text-sm font-medium items-center w-5">
                <Link :href="`/sk/${laporan.id}/edit`"
                  class="text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-700 y-4 px-6 text-2xl focus:outline-none leading-none rounded">
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
import { Inertia } from '@inertiajs/inertia';
import { usePage, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import ConfirmationModal from './ConfirmationModal.vue';

const { bookmarkedLaporans } = usePage().props;

const bookmarks = ref(bookmarkedLaporans.map(laporan => laporan.id));

watch(() => bookmarkedLaporans, (newBookmarks) => {
  bookmarks.value = newBookmarks.map(laporan => laporan.id);
});

const form = useForm({
  laporan_id: null,
});


const isModalOpen = ref(false);

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const fetchItems = () => {
  Inertia.get('/sk/index', {}, { preserveState: true });
};

const remove = (LaporanId) => {
  form.delete(`/sk/${LaporanId}/delete`, {
    onFinish: () => {
      fetchItems();
    },
  });
};


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
</script>
