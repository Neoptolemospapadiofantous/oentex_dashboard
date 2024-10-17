<template>
  <a
    href="javascript:;"
    class="collapse-icon flex items-center justify-center w-8 h-8 sm:w-6 sm:h-6 md:w-4 md:h-4 rounded-full hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180 hover:text-primary relative"
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
  