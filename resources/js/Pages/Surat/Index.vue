<template>
  <AppLayout title="Index">
    <template #header>
      <div class="flex justify-between h-10">
        <div class="flex items-center">
          <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Index surat
          </h2>
          <Link v-show="can.create" href="/surat/create"
            class="text-gray-800 dark:text-gray-200 dark:hover:text-white text-xl hover:text-gray-600 ml-3 py-4 px-4"
            v-tippy="{ content: 'Tambah surat baru', theme: 'dark', arrow: true }">
          <font-awesome-icon :icon="['fas', 'file-circle-plus']" />
          </Link>
        </div>
        <input v-model="searchs" type="text" class="border rounded-lg w-1/2" placeholder="Cari...">
        <div class="h-10 mb-5 hidden md:block">
          <select v-model="jenisFilter" id="jenis" class="border border-gray-400 min-w-fit rounded-lg ml-2">
            <option value="all" :value="'all'">Semua jenis</option>
            <option value="surat kerja">surat kerja</option>
            <option value="surat tugas">surat tugas</option>
          </select>
          <select v-model="kategoriFilter" id="kategori" class="border border-gray-400 min-w-fit rounded-lg ml-2">
            <option value="all">Semua kategori</option>
            <option value="Pendidikan dan Pengajaran">Pendidikan dan Pengajaran</option>
            <option value="Penelitian dan Pengembangan">Penelitian dan Pengembangan</option>
            <option value="Pengabdian Kepada Masyarakat">Pengabdian Kepada Masyarakat</option>
          </select>
        </div>
      </div>
    </template>
    <div class="pt-36">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- Table for displaying laporans -->
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
              <!-- Iterate over laporans and render each item using the TableRow component -->
              <TableRow v-for="item in laporans.data" :key="item.id" :item="item" :toggleBookmark="toggleBookmark"
                :isBookmarked="isBookmarked" :remove="remove" />
            </tbody>
          </table>
        </div>
      </div>
      <Pagination :links="laporans.links" />
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
import TableRow from '../../Components/TableRow.vue';
import { directive as VTippy } from 'vue-tippy';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/themes/light.css';

const { laporans, bookmarkedLaporans, can } = usePage().props;
let props = defineProps({
  search: Object,
  jenis: Object,
  kategori: Object,
});

let searchs = ref(props.search.search);
let jenisFilter = ref(props.jenis.jenis ? props.jenis.jenis : 'all');
let kategoriFilter = ref(props.kategori.kategori ? props.kategori.kategori : 'all');
watch([kategoriFilter, searchs, jenisFilter], throttle(() => {
  router.get('/surat/index', {
    kategori: kategoriFilter.value === 'all' ? 'all' : kategoriFilter.value,
    jenis: jenisFilter.value === 'all' ? 'all' : jenisFilter.value,
    search: searchs.value || ''
  }, {
    onSuccess: (response) => {
      laporans.data = response.props.laporans.data;
      laporans.links = response.props.laporans.links;
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
  Inertia.get('/surat/index', {}, { preserveState: true });
};

const remove = (LaporanId) => {
  form.delete(`/surat/${LaporanId}/delete`, {
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
