<template>
  <div class="flex h-screen">
    <Banner :Laporans="Laporans" :filters="filters"/>

    <Form v-if="!$page.props.auth.user" />
  </div>
</template>

<script setup>

let props = defineProps({
  Laporans: Object,
  filters: Object,
})

import Banner from './Partials/Banner.vue';
import Form from './Partials/Form.vue';
</script>
