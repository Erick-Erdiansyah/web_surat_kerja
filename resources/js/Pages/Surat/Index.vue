<template>
  <AppLayout title="Index">
    <template #header>
      <div class="flex justify-between h-10">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            SK Elektro
          </h2>
          <Link v-show="can.create" href="/sk/create"
            class="text-gray-800 dark:text-gray-200 dark:hover:text-white text-xl hover:text-gray-600 ml-3 py-4 px-4"
            v-tippy="{ content: 'Tambah surat baru', theme: 'dark', arrow: true }">
          <font-awesome-icon :icon="['fas', 'file-circle-plus']" />
          </Link>
        </div>
        <input v-model="search" type="text" class="border rounded-lg h-10 mt-1" placeholder="Cari...">
      </div>
    </template>
    <div class=" pt-36">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
              <TableRow v-for="item in Laporans.data" :key="item.id" :item="item" :toggleBookmark="toggleBookmark"
                :isBookmarked="isBookmarked" :remove="remove" />
            </tbody>
          </table>
        </div>
      </div>
      <Pagination :links="Laporans.links" />
    </div>
  </AppLayout>
</template>
<script setup>
import { ref, watch } from 'vue';
import { usePage, useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { throttle } from 'lodash';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Inertia } from '@inertiajs/inertia';
import TableRow from './Partials/TableRow.vue';
import { directive as VTippy } from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'

const { Laporans, bookmarkedLaporans, can } = usePage().props;

let props = defineProps({
  filters: Object,
})

let search = ref(props.filters.search);

watch(search, throttle((value) => {
  router.get('/sk/index', { search: value }, {
    onSuccess: (response) => {
      // assign new value, the page not reload properly -_-
      Laporans.data = response.props.Laporans.data;
      Laporans.links = response.props.Laporans.links;
    },
    preserveState: true,
    replace: true,
  });
}, 500));

const bookmarks = ref(bookmarkedLaporans);

watch(() => bookmarkedLaporans, (newBookmarks) => {
  bookmarks.value = newBookmarks;
});

const form = useForm({
  laporan_id: null,
});

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
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  } else {
    form.post('/bookmarks', {
      onSuccess: () => {
        bookmarks.value.push(laporanId);
      },
      onError: (errors) => {
        console.log('Error:', errors);
      },
    });
  }
};

</script>