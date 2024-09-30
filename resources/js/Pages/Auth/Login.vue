<template>
  <div class="flex h-screen">
    <Banner />

    <Form v-if="!$page.props.auth.user"/>
  </div>
</template>

<script setup>
import Banner from '../Landing/Partials/Banner.vue';
import Form from '../Landing/Partials/Form.vue';
</script>
