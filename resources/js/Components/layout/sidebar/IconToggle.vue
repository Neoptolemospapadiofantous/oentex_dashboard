<template>
    <a
      href="javascript:;"
      class="collapse-icon w-8 h-8 rounded-full flex items-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180 hover:text-primary"
    >
      <component :rotate="rotate" />
    </a>
  </template>
  
  <script lang="ts" setup>
  defineProps({
    rotate: { type: Number, default: 0 },
  });
  </script>
  
  <style scoped>
  /* Custom styles if necessary */
  </style>
  