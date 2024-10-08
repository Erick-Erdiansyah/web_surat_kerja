<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl dark:text-white text-gray-800 leading-tight p-2">
        Dashboard
      </h2>
    </template>
    <div class="pt-36">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
              <TableRow v-for="item in bookmarkedLaporans" :key="item.id" :item="item" :toggleBookmark="toggleBookmark"
                :isBookmarked="isBookmarked" :remove="remove" />
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TableRow from './Surat/Partials/TableRow.vue';
import { ref, watch } from 'vue';
import { usePage, useForm, router } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const { newItems, bookmarkedLaporans } = usePage().props;

const goTo = (itemId) => {
  this.$router.push(`/sk/${itemId}/read`)
};

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
        bookmarks.value = bookmarks.value.filter(id => id !== laporanId);
        Inertia.get('/dashboard');
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  } else {
    form.post('/bookmarks', {
      onSuccess: () => {
        bookmarks.value.push(laporanId);
        Inertia.get('/dashboard');
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  }
};
</script>