<template>
  <div
    :class="$page.props.auth.user ? 'min-h-screen w-full flex flex-col bg-gradient-to-b from-black to-gray-600' : 'min-h-screen w-3/4 flex flex-col bg-gradient-to-b from-black to-gray-600'">
    <div class="w-full text-5xl flex-grow bg-cover bg-center image" :style="{ 'background-image': `url(${imageUrl})` }">
      <div :class="$page.props.auth.user ? 'text-center' : ''">
        <h1 v-if="$page.props.auth.user" class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja dan
          Surat Tugas Teknik
          Elektro</h1>
        <h1 v-if="!$page.props.auth.user" class="text-7xl font-semibold text-white mt-10 px-4">Arsip Surat Kerja dan<br>
          Surat Tugas Teknik Elektro</h1>
        <h1 v-if="$page.props.auth.user" class="text-5xl font-semibold text-white mt-4 px-4">
          <Link href="/dashboard" class="hover:underline">
          <FontAwesomeIcon :icon="['fas', 'house']" /> Beranda</Link>
        </h1>
        <div class=" mt-6 sm:pb-6 lg:pb-6 max-w-3xl mx-auto sm:px-6 lg:px-6  bg-gray-600  rounded-lg opacity-80">
          <div class="h-10 mb-5">
            <input v-model="search" type="text" class="border rounded-lg w-4/5" placeholder="Cari...">
            <PrimaryButton class="ml-2" @click="searchs(search)">
              cari
            </PrimaryButton>
            <button @click="toggleDark()"
              class=" ml-2 text-base text-white rounded-lg"
              v-tippy="{ content: 'Ganti tema tabel', theme: 'dark', arrow: true, placement: 'top' }">
              <font-awesome-icon :icon="isActive ? ['far', 'sun'] : ['far', 'moon']" />
            </button>
          </div>
          <div
            class="bg-gray-200 opacity-100 overflow-hidden max-h-[400px] overflow-y-auto shadow-xl sm:rounded-lg over">
            <table class="min-w-full divide-y divide-gray-200">
              <tbody class="bg-white divide-y divide-gray-200">
                <TableRow v-for="item in laporans" :key="item.id" :item="item" :toggleBookmark="toggleBookmark"
                  :isBookmarked="isBookmarked" :remove="remove" />
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { usePage, useForm, router } from '@inertiajs/vue3';
import { directive as VTippy } from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'
import TableRow from '@/Components/TableRow.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useDark, useToggle } from '@vueuse/core';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faMoon, faSun } from '@fortawesome/free-solid-svg-icons';


const imageUrl = new URL('@/assets/images/background.svg', import.meta.url);


let props = defineProps({
  filters: Object,
  laporans: Object
})

const { bookmarkedLaporans, can } = usePage().props;


let search = ref(props.filters.search);

let laporans = ref(props.laporans);

let searchs = (value) => {
  router.get('/', { search: value }, {
    onSuccess: (response) => {
      laporans.value = response.props.laporans;
    },
    preserveState: true,
    replace: true,
  });
}

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

library.add(faMoon, faSun)
const isDark = useDark()
const toggleDark = useToggle(isDark)
const isActive = ref(isDark)

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
