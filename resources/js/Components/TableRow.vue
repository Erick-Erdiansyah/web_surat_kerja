<template>
  <tr class="hover:bg-slate-100 dark:hover:bg-slate-800 dark:bg-slate-700 relative">
    <Link :href="!$page.props.auth.user ? `/read/${item.id}` : `/sk/${item.id}/read`" class="block w-full h-full">
    <td class="px-4 py-2 whitespace-pre-wrap">
      <div class="flex items-center">
        <p v-show="baru(item.created_timestamp)"
          class="text-sm px-3 pt-1 rounded-sm text-white dark:text-black dark:bg-white bg-slate-900 w-52 flex items-center absolute top-0 left-0">
          Dibuat {{ item.created_human }}
        </p>
        <div class="flex items-center">
          <p class="text-gray-900 dark:text-white"
            :class="baru(item.created_timestamp) ? 'text-base pt-2 font-medium' : ''">
            {{ item.judul }}</p>
        </div>
      </div>
    </td>
    </Link>
    <td class="w-10"></td>
    <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-3">
      <Read :surat_file="item.surat_file" :id="item.id" />
    </td>
    <td class="pr-2 whitespace-nowrap text-center text-sm font-medium items-center w-3">
      <Dropdown :border="false">
        <!-- trigger element -->
        <template #trigger>
          <button type="button" v-tippy="{ content: 'Info lebih lanjut', theme: 'dark', arrow: true }"
            class="text-4xl text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-800 py-2 px-4 hover:bg-gray-200 dark:hover:bg-gray-700 hover:rounded-lg">
            <font-awesome-icon :icon="['fas', 'ellipsis-vertical']" />
          </button>
        </template>
        <!-- contents display in dropdown -->
        <div class="bg-gray-200 border-none text-gray-800">
          <div v-if="item.can?.update" class="px-2 py-1 text-xl hover:bg-gray-500 hover:text-white rounded-sm">
            <Link :href="`/sk/${item.id}/edit`">
            <font-awesome-icon :icon="['far', 'pen-to-square']" /> ubah
            </Link>
          </div>
          <div v-if="item.can?.delete" class="px-2 py-1 text-xl hover:bg-gray-500 hover:text-white rounded-sm">
            <button @click="openModal">
              <font-awesome-icon :icon="['far', 'trash-can']" /> hapus
            </button>
            <ConfirmationModal :show="isModalOpen" @close="closeModal" title="Confirm Deletion">
              <template #content>
                Beneran mau hapus ?
              </template>
              <template #footer>
                <button @click="closeModal" class="mr-2 px-4 py-2 bg-gray-300 rounded">batal</button>
                <button @click="() => { remove(item.id); closeModal(); }"
                  class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
              </template>
            </ConfirmationModal>
          </div>
          <button @click="handleAuthBookmark($page.props.auth.user)"
            class="px-2 py-1 text-xl hover:bg-gray-500 hover:text-white rounded-sm">
            <font-awesome-icon :icon="isBookmarked(item.id) ? ['fas', 'bookmark'] : ['far', 'bookmark']" /> tandai
          </button>
          <ConfirmationModal v-if="!$page.props.auth.user" :show="isModalOpen" :max-width="'lg'" @close="closeModal"
            title="masuk">
            <template #content>
              masuk dulu mas bro
            </template>
          </ConfirmationModal>
          <div class="px-2 py-1 text-xl hover:bg-gray-500 hover:text-white rounded-sm">
            <Link :href="`http://127.0.0.1:8000/storage/${item.surat_file}`" download>
            <font-awesome-icon :icon="['far', 'circle-down']" /> unduh
            </Link>
          </div>
        </div>
      </Dropdown>
    </td>
  </tr>
</template>

<script setup>
import Dropdown from 'v-dropdown';
import { ref, watch } from 'vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { usePage, useForm, router } from '@inertiajs/vue3';
import { directive as VTippy } from 'vue-tippy'
import Read from '@/Components/Read.vue';
import 'tippy.js/dist/tippy.css'
import 'tippy.js/themes/light.css'

const props = defineProps({
  item: Object,
  toggleBookmark: Function,
  isBookmarked: Function,
  remove: Function,
});


const baru = (timestamp) => {
  const sekarang = Math.floor(Date.now() / 1000);
  const upload = sekarang - timestamp;
  const seminggu = 7 * 24 * 60 * 60;
  return upload <= seminggu;
};

const isModalOpen = ref(false);

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};


const handleAuthBookmark = (auth) => {
  if (auth) {
    toggleBookmark(item.id)
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
