<template>
  <footer class="bg-gray-800 text-white p-2 border-t border-gray-300 dark:border-gray-700">
    <div class="container mx-auto flex items-center justify-end">
      <!-- Right-aligned content inside the bordered container -->
      <div class="shadow-sm flex items-center justify-between border border-gray-200 dark:border-gray-600 p-1 rounded-lg w-full md:w-auto">
        <div class="flex items-center space-x-4">
          <!-- Copyright text inside the bordered container -->
          <span class="block">
            © {{ new Date().getFullYear() }}. OENTEX. All rights reserved.
          </span>
          <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
          <a href="#" class="text-blue-600 hover:underline">Terms of Service</a>
        </div>
      </div>
    </div>
  </footer>
</template>


<script lang="ts" setup>
// No specific script needed unless you're adding additional functionality
</script>

<style scoped>
/* Add any specific footer styles here if needed */
</style>
