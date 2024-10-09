<template>
    <div class="flex items-center space-x-2">
      <form v-if="search" @submit.prevent="$emit('toggleSearch')" class="relative">
        <input type="text" class="form-input" placeholder="Search..." />
        <button class="absolute inset-y-0 left-0 p-2">
          <icon-search />
        </button>
        <button @click="$emit('toggleSearch')" class="absolute right-0 p-2">
          <icon-x-circle />
        </button>
      </form>
      <button v-else @click="$emit('toggleSearch')" class="p-2 bg-gray-600 rounded-full">
        <icon-search />
      </button>
    </div>
  </template>
  
  <script lang="ts" setup>
  import IconSearch from '@/Components/icon/icon-search.vue';
  import IconXCircle from '@/Components/icon/icon-x-circle.vue';
  const props = defineProps({
    search: Boolean
  });
  </script>
  