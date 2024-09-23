<template>
  <AppLayout title="View PDF">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg" @scroll="handleScroll" ref="scrollContainer">
      <h2 class="text-xl font-semibold mb-4">Judul</h2>
      <div v-for="page in visiblePages" :key="page" class="pdf-page">
        <VuePDF :pdf="pdf" :page="page" />
      </div>
      <div v-if="loading" class="mt-4 text-gray-500">Loading more pages...</div>
      <div v-if="errorMessage" class="mt-4 text-red-500">{{ errorMessage }}</div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { usePDF, VuePDF } from '@tato30/vue-pdf';
import AppLayout from '@/Layouts/AppLayout.vue';

let props = defineProps({
  Surat: Object // assuming Surat contains the PDF path
});

const pdfPath = ref(`/storage/${props.Surat.surat_file}`); // Adjust the path as needed
const errorMessage = ref('');
const loading = ref(false);
const visiblePages = ref([1, 2, 3]); // Start with the first few pages
const totalPages = ref(0); // You can set this to the total pages in the PDF later
const { pdf } = usePDF(pdfPath);

const onError = (error) => {
  errorMessage.value = 'Failed to load PDF: ' + error.message;
};

const handleScroll = () => {
  const container = $refs.scrollContainer;
  if (container.scrollTop + container.clientHeight >= container.scrollHeight - 10 && !loading.value) {
    loadMorePages();
  }
};

const loadMorePages = () => {
  if (visiblePages.value.length < totalPages.value) {
    loading.value = true;
    setTimeout(() => { // Simulating async loading, replace with actual page fetching
      const nextPage = visiblePages.value.length + 1;
      const newPages = [];
      for (let i = nextPage; i <= nextPage + 2; i++) { // Load 3 more pages
        if (i <= totalPages.value) newPages.push(i);
      }
      visiblePages.value.push(...newPages);
      loading.value = false;
    }, 1000); // Simulate network delay
  }
};

onMounted(() => {
  totalPages.value = 10; // Example total pages; replace with actual logic
});
</script>

<style scoped>
.pdf-page {
  margin-bottom: 20px; /* Space between pages */
}
</style>
