<template>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
      <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-200">Top Intents</h2>
      <ul>
        <li v-for="intent in intents" :key="intent.name" class="text-gray-800 dark:text-gray-200">
          {{ intent.name }} - <span class="font-bold">{{ intent.count }}</span>
        </li>
      </ul>
    </div>
  </template>
  
  <script lang="ts" setup>
  // Define the Intent type
  interface Intent {
    name: string;
    count: number;
  }
  
  // Correctly define props with PropType and specify 'intents'
  const props = defineProps<{
    intents: Intent[]
  }>();
  </script>
  
  <style scoped></style>
  