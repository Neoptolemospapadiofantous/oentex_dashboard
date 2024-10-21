<template>
  <Head title="Voiceflow Analytics" />

  <AuthenticatedLayout :translate="translate">
    <template #header>
      <div class="px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600">
        <h2 class="text-2xl font-bold text-white text-center">
          Voiceflow Analytics Dashboard
        </h2>
      </div>
    </template>

    <template #main>
      <div class="py-10">
        <div class="max-w-5xl mx-auto px-4">

          <!-- Form for Date Range -->
          <form @submit.prevent="fetchAnalyticsData" class="bg-white p-6 mb-8 shadow-md rounded-md grid gap-4 md:grid-cols-2">
            <div>
              <label class="block text-sm font-medium text-gray-700">Start Time:</label>
              <input
                type="datetime-local"
                v-model="startTimeInput"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">End Time:</label>
              <input
                type="datetime-local"
                v-model="endTimeInput"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
              />
            </div>
            <div class="md:col-span-2">
              <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-md transition"
              >
                Fetch Analytics Data
              </button>
            </div>
          </form>

          <!-- Loading indicator -->
          <div v-if="isLoading" class="flex justify-center mt-4">
            <span class="animate-spin rounded-full h-12 w-12 border-t-2 border-blue-500"></span>
          </div>

          <!-- Error message -->
          <div v-if="globalError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-md transition" role="alert">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline">{{ globalError }}</span>
          </div>

          <!-- Full-Width Analytics Components for Each Agent -->
          <div v-for="agent in agents" :key="agent.id" class="w-full my-8 bg-white p-6 rounded-md shadow-md">
            <AgentAnalyticsComponent
              :agent="agent"
              :interactions="agent.interactions"
              :sessions="agent.sessions"
              :topIntents="agent.topIntents"
              :topSlots="agent.topSlots"
              :understoodMessages="agent.understoodMessages"
              :uniqueUsers="agent.uniqueUsers"
              :tokensConsumed="agent.tokensConsumed"
              :error="agent.error"
            />
          </div>

          <!-- Full-Width Chart Analytics Component -->
          <div class="my-8">
            <ChartAnalyticsComponent
              v-for="agent in agents" 
              :key="agent.id"
              :interactions="agent.interactions"
              :sessions="agent.sessions"
              :topIntents="agent.topIntents"
              :topSlots="agent.topSlots"
              :understoodMessages="agent.understoodMessages"
              :uniqueUsers="agent.uniqueUsers"
              :tokensConsumed="agent.tokensConsumed"
            />
          </div>
        </div>
      </div>
    </template>

    <template #footer>
      <footer class="bg-gray-800 text-white py-4 mt-4">
        <div class="container mx-auto text-center">
          <p>&copy; 2024 Vristo. All rights reserved.</p>
        </div>
      </footer>
    </template>
  </AuthenticatedLayout>
</template>

<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import AgentAnalyticsComponent from '@/Components/analytics/AgentAnalyticsComponent.vue';
import ChartAnalyticsComponent from '@/Components/analytics/ChartComponent.vue';

const startTimeInput = ref<string | null>(new Date().toISOString().slice(0, 16));
const endTimeInput = ref<string | null>(new Date().toISOString().slice(0, 16));

const isLoading = ref(false);
const globalError = ref<string | null>(null);

const agents = ref([
  {
    id: 1,
    name: "Agent 1",
    interactions: 0, 
    sessions: 0,
    topIntents: 0,
    topSlots: 0,
    understoodMessages: 0,
    uniqueUsers: 0,
    tokensConsumed: 0,
    error: null
  },
]);

const fetchAnalyticsData = async () => {
  isLoading.value = true;
  globalError.value = null;

  const metrics = ['interactions', 'sessions', 'intents', 'slots', 'messages', 'users', 'tokens'];
  
  try {
    for (const agent of agents.value) {
      for (const metric of metrics) {
        const response = await axios.post('/analytics/data', {
          startTime: new Date(startTimeInput.value).toISOString(),
          endTime: new Date(endTimeInput.value).toISOString(),
          name: metric,
        });

        if (response.data.result && response.data.result.length > 0) {
          agent[metric] = response.data.result[0].count;
        }
        agent.error = null;
      }
    }
  } catch (err) {
    globalError.value = 'Failed to fetch analytics data. Please try again.';
    console.error('Error fetching data:', err.message);
  } finally {
    isLoading.value = false;
  }
};
</script>

<style scoped>
/* Scoped style for animations and specific customizations as needed */
.modal-scale-fade-enter-active, .modal-scale-fade-leave-active {
  transition: opacity 0.5s ease, transform 0.5s ease;
}
.modal-scale-fade-enter, .modal-scale-fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>