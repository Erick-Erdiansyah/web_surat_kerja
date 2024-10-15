<template>
  <Dropdown :border="false">
    <!-- Trigger element -->
    <template #trigger>
      <button type="button" v-tippy="{ content: 'Pemberitahuan', theme: 'dark', arrow: true }"
        class="text-xl text-gray-900 dark:text-white dark:hover:text-gray-400 hover:text-gray-800 py-2 px-4 hover:bg-gray-200 dark:hover:bg-gray-700 hover:rounded-lg">
        <font-awesome-icon :icon="['fas', 'bell']" />
        <span v-if="unreadNotifications.length" class="absolute bg-red-600 text-white rounded-full text-xs px-1">
          {{ unreadNotifications.length }}
        </span>
      </button>
    </template>

    <!-- Contents display in dropdown -->
    <table>
      <tbody>
        <tr v-for="notification in unreadNotifications" :key="notification.id" class="hover:bg-gray-200 rounded-full">
          <a :href="notification.data.url">
            <td class="p-1">Surat baru {{ notification.data.judul || 'Judul tidak tersedia' }}</td>
          </a>
          <td class="pr-1">
            <button class=" ml-1" @click="markAsRead(notification.id)"
              v-tippy="{ content: 'tandai sudah dibaca', theme: 'dark', arrow: true }">
              <font-awesome-icon :icon="['fas', 'check']" />
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </Dropdown>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Dropdown from 'v-dropdown';
import { directive as VTippy } from 'vue-tippy';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/themes/light.css';
import axios from 'axios';

const unreadNotifications = ref([]);
const pollingInterval = 5000;

// Fetch notifications from the API without redirecting
const fetchNotifications = async () => {
  try {
    const response = await axios.get('/notifications');
    unreadNotifications.value = response.data.unreadNotifications;
  } catch (error) {
    console.error('Failed to fetch notifications:', error);
  }
};

onMounted(() => {
  fetchNotifications();
  const interval = setInterval(fetchNotifications, pollingInterval);

  onBeforeUnmount(() => {
    clearInterval(interval);
  });
});

const markAsRead = async (notifId) => {
  try {
    const response = await axios.post(`/notifications/${notifId}`);
    if (response.data.success) {
      unreadNotifications.value = unreadNotifications.value.filter(n => n.id !== notifId);
    }
  } catch (error) {
    console.error('fak :', error);
  }
};
</script>
