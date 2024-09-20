
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight p-2">
                Dashboard
            </h2>
        </template>
        <NewItem />
        <DashboardTable />
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DashboardTable from '@/Components/DashboardTable.vue';
import NewItem from '@/Components/NewItem.vue';
</script>
