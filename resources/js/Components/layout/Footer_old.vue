<template>
  <footer>
    <div class="max-w-screen-xl mx-auto px-4 py-3 text-center sm:text-left text-sm md:flex md:items-center md:justify-between">
      <!-- Left-aligned text (on larger screens) -->
      <span class="block sm:inline ">
        © {{ new Date().getFullYear() }}. Vristo. All rights reserved.
      </span>
      
      <!-- Right-aligned links (optional) -->
      <div class="mt-2 md:mt-0">
        <a href="#" class="text-blue-600 hover:underline ml-4">Privacy Policy</a>
        <a href="#" class="text-blue-600 hover:underline ml-4">Terms of Service</a>
      </div>
    </div>
  </footer>
</template>
