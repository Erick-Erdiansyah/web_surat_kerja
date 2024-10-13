<template>
  <div
    :class="$page.props.auth.user ? 'min-h-screen w-full flex flex-col h-screen bg-gradient-to-b from-black to-gray-600' : 'min-h-screen w-3/4 flex flex-col h-screen bg-gradient-to-b from-black to-gray-600'">
    <div class="w-full text-5xl flex-grow bg-cover bg-center image" :style="{ 'background-image': `url(${imageUrl})` }">
      <div :class="$page.props.auth.user ? 'text-center' : ''">
        <h1 v-if="$page.props.auth.user" class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja dan
          Surat Tugas Teknik
          Elektro</h1>
        <h1 v-if="!$page.props.auth.user" class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja dan<br>
          Surat Tugas Teknik Elektro</h1>
        <h1 v-if="$page.props.auth.user" class="text-7xl font-semibold text-white mt-4 px-4">
          <Link href="/dashboard" class="hover:underline">Beranda</Link>
        </h1>
        <div class=" mt-6 sm:pb-6 lg:pb-6 max-w-3xl mx-auto sm:px-6 lg:px-6  bg-gray-600  rounded-lg opacity-80">
          <div class="h-10 mb-5">
            <input v-model="search" type="text" class="border rounded-lg w-4/5" placeholder="Cari...">
            <PrimaryButton class="ml-2">
              cari
            </PrimaryButton>
          </div>
          <div
            class="bg-gray-200 opacity-100 overflow-hidden max-h-[400px] overflow-y-auto shadow-xl sm:rounded-lg over">
            <table class="min-w-full divide-y divide-gray-200">
              <tbody class="bg-white divide-y divide-gray-200">
                <TableRow v-for="item in Laporans" :key="item.id" :item="item" :toggleBookmark="toggleBookmark"
                  :isBookmarked="isBookmarked" :remove="remove" />
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <p class="mt-80 hidden">hello</p>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { usePage, useForm, router } from '@inertiajs/vue3';
import { throttle } from 'lodash';
import { directive as VTippy } from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'
import TableRow from '@/Pages/Surat/Partials/TableRow.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const imageUrl = new URL('@/assets/images/background.svg', import.meta.url);


let props = defineProps({
  filters: Object,
})

const { Laporans, bookmarkedLaporans, can } = usePage().props;


// let search = ref(props.filters.search);

// watch(search, throttle((value) => {
//   router.get('/sk/index', { search: value }, {
//     onSuccess: (response) => {
//       // assign new value, the page not reload properly -_-
//       Laporans.data = response.props.Laporans.data;
//       Laporans.links = response.props.Laporans.links;
//     },
//     preserveState: true,
//     replace: true,
//   });
// }, 500));

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

<style>
.image {
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  width: 100%;
  height: 100%;
}
</style>
