<template>
    <Head title="VoiceflowAnalytics" />
  
    <!-- Use AuthenticatedLayout and inject content via slots -->
    <AuthenticatedLayout :translate="translate">
      
      <!-- Header Slot -->
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Analytics Dashboard
        </h2>
      </template>
  
      <!-- Main Slot -->
      <template #main>
        <div class="container mx-auto p-6">
          <h1 class="text-3xl font-bold mb-6">Analytics Dashboard</h1>
  
          <!-- Display each component -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <InteractionsComponent :interactions="interactions" :error="interactionsError" />
            <SessionsComponent :sessions="sessions" :error="sessionsError" />
            <!-- Add the remaining components as necessary -->
            <!-- <TopIntentsComponent :intents="topIntents" :error="intentsError" />
            <TopSlotsComponent :slots="topSlots" :error="slotsError" />
            <UnderstoodMessagesComponent :messages="understoodMessages" :error="messagesError" />
            <UniqueUsersComponent :users="uniqueUsers" :error="usersError" />
            <TokensConsumedComponent :tokens="tokensConsumed" :error="tokensError" /> -->
          </div>
        </div>
      </template>
  
      <!-- Footer Slot (if needed) -->
      <template #footer>
        <p class="text-center text-gray-500 text-sm">
          &copy; 2024 Vristo. All rights reserved.
        </p>
      </template>
  
    </AuthenticatedLayout>
  </template>
  
  <script lang="ts" setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import { useI18n } from 'vue-i18n';
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  // Import components
  import InteractionsComponent from '@/Components/analytics/InteractionsComponent.vue';
  import SessionsComponent from '@/Components/analytics/SessionsComponent.vue';

  // Translation setup
  const { t } = useI18n();
  const translate = t;
  
  
  // State variables for analytics data
  const interactions = ref<number[]>([]);
  const sessions = ref<number[]>([]);

  // Error handling
  const interactionsError = ref<string | null>(null);
  const sessionsError = ref<string | null>(null);

  
  // Fetch data on component mount
onMounted(async () => {
  try {
    const response = await axios.post(route('analytics.interactions')); // Adjust the API endpoint as needed
    interactions.value = response.data.result[0].count; // Assuming the count is at this path
  } catch (error) {
    interactionsError.value = 'Failed to fetch interactions';
  }
});
  </script>
  
  <style scoped>
  /* Add any specific styling here if necessary */
  </style>
  