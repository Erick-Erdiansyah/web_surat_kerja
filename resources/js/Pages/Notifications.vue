<!-- resources/js/Pages/Notifications.vue -->

<template>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-bold">Notifications</h2>
        <ul>
            <li v-for="notification in notifications" :key="notification.id" class="py-2 border-b">
                <a :href="notification.data.link" class="text-blue-500 hover:underline">{{ notification.data.message
                    }}</a>
                <span class="text-gray-500 text-sm">{{ notification.created_at }}</span>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const notifications = ref([]);

const fetchNotifications = async () => {
    try {
        const response = await fetch('/notifications');
        notifications.value = await response.json();
    } catch (error) {
        console.error('Error fetching notifications:', error);
    }
};

let pollingInterval;

onMounted(() => {
    fetchNotifications();
    pollingInterval = setInterval(fetchNotifications, 10000);
});

onBeforeUnmount(() => {
    clearInterval(pollingInterval);
});
</script>
