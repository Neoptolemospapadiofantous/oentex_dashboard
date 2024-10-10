<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();  // Translation function
const translate = t;
</script>

<template>
  <Head title="Dashboard" />

  <!-- Using AuthenticatedLayout and injecting content via slots -->
  <AuthenticatedLayout :translate="translate">
    
    <!-- Header Slot -->
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <!-- Main Slot -->
    <template #main>
      <div class="flex-1 flex justify-center items-center">
        <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
          <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
          <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
        </div>
      </div>
    </template>

    <!-- Optional Footer Slot (if needed) -->
    <!-- <template #footer>
      <p class="text-center text-gray-500 text-sm">
        &copy; 2024 Vristo. All rights reserved.
      </p>
    </template> -->
  </AuthenticatedLayout>
</template>

<style scoped>
/* Add any specific styles here if needed */
</style>
