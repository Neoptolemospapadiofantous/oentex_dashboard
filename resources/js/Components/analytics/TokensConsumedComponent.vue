<template>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
      <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-200">Tokens Consumed</h2>
      <p class="text-2xl font-bold text-primary">{{ tokensConsumed.count }}</p>
    </div>
  </template>
  
  <script lang="ts" setup>
  const props = defineProps({
    tokensConsumed: {
      type: Object,
      required: true,
    },
  });
  </script>
  
  <style scoped></style>
  