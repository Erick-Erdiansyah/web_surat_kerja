<template>
  <div class="mt-6">
    <Component :is="link.url ? 'Link' : 'span'" v-for="link in links" :href="link.url" v-html="link.label" class="px-1" :class="{'text-gray-600': ! link.url, 'font-bold' : link.active }" />
    <!-- :class="link.url ? '' : 'text-gray-600'"  -->
   </div>
</template>
<script>
export default{
  props:{
    links:Array
  }
}
</script>