<template>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
      <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-200">Unique Users</h2>
      <p class="text-gray-800 dark:text-gray-200">Total Unique Users: {{ users.count }}</p>
    </div>
  </template>
  
  <script lang="ts" setup>
  // Define the User type
  interface User {
    count: number;
  }
  
  // Correctly define props with PropType and specify 'users'
  const props = defineProps<{
    users: User
  }>();
  </script>
  
  <style scoped></style>
  