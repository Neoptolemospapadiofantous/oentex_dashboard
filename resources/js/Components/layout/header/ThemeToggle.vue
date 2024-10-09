<template>
    <div class="flex items-center space-x-2">
      <button v-if="theme === 'light'" @click="$emit('toggleTheme', 'dark')" class="p-2 bg-gray-600 rounded-full">
        <icon-sun />
      </button>
      <button v-if="theme === 'dark'" @click="$emit('toggleTheme', 'system')" class="p-2 bg-gray-600 rounded-full">
        <icon-moon />
      </button>
      <button v-if="theme === 'system'" @click="$emit('toggleTheme', 'light')" class="p-2 bg-gray-600 rounded-full">
        <icon-laptop />
      </button>
    </div>
  </template>
  
  <script lang="ts" setup>
  import IconSun from '@/Components/icon/icon-sun.vue';
  import IconMoon from '@/Components/icon/icon-moon.vue';
  import IconLaptop from '@/Components/icon/icon-laptop.vue';
  
  const props = defineProps({
    theme: String,
  });
  </script>
  