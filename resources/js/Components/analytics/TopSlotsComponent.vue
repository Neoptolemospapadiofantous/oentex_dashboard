<template>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
      <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-200">Top Slots</h2>
      <ul>
        <li v-for="slot in props.slots" :key="slot.name" class="text-gray-800 dark:text-gray-200">
          {{ slot.name }} - <span class="font-bold">{{ slot.count }}</span>
        </li>
      </ul>
    </div>
  </template>
  
  <script lang="ts" setup>
  // Define the Slot type
  interface Slot {
    name: string;
    count: number;
  }
  
  // Correctly define props with PropType and specify 'slots'
  const props = defineProps<{
    slots: Slot[]
  }>();
  </script>
  
  <style scoped></style>
  