<template>
  <Head title="VoiceflowAnalytics" />

  <AuthenticatedLayout :translate="translate">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 text-center">
        Analytics Dashboard
      </h2>
    </template>

    <template #main>
      <div class="container mx-auto p-6 space-y-6">
        <h1 class="text-3xl font-bold mb-6 text-center">Analytics Dashboard</h1>

        <!-- Form to enter API Key and Project ID -->
        <div class="grid gap-4 mb-6 md:grid-cols-2">
          <div>
            <label class="block text-gray-700">Voiceflow API Key:</label>
            <input
              type="text"
              v-model="apiKeyInput"
              class="border p-2 rounded-lg w-full"
              placeholder="Enter your Voiceflow API Key"
            />
          </div>
          <div>
            <label class="block text-gray-700">Voiceflow Project ID:</label>
            <input
              type="text"
              v-model="projectIdInput"
              class="border p-2 rounded-lg w-full"
              placeholder="Enter your Voiceflow Project ID"
            />
          </div>
        </div>

        <!-- Form to select startTime and endTime -->
        <div class="grid gap-4 mb-6 md:grid-cols-2">
          <div>
            <label class="block text-gray-700">Start Time:</label>
            <input
              type="datetime-local"
              v-model="startTimeInput"
              class="border p-2 rounded-lg w-full"
            />
          </div>
          <div>
            <label class="block text-gray-700">End Time:</label>
            <input
              type="datetime-local"
              v-model="endTimeInput"
              class="border p-2 rounded-lg w-full"
            />
          </div>
        </div>

        <!-- Button to fetch data -->
        <div class="flex justify-center">
          <button
            @click="fetchAnalyticsData"
            class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-lg"
          >
            Fetch Analytics Data
          </button>
        </div>

        <!-- Table and Chart for Each Agent -->
        <div v-for="agent in agents" :key="agent.id" class="my-8">
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
      </div>
    </template>

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
import { ref } from 'vue';
import axios from 'axios';
import AgentAnalyticsComponent from '@/Components/analytics/AgentAnalyticsComponent.vue';

// State variables for input fields
const apiKeyInput = ref<string>('VF.DM.66f2a65d8d9312ecde1d7264.G7z7QOHV97maEKi1'); // Default API Key
const projectIdInput = ref<string>('66e5a810791dba93cee4e8b7'); // Default Project ID
const startTimeInput = ref<string | null>(new Date().toISOString().slice(0, 16)); // Default to current date
const endTimeInput = ref<string | null>(new Date().toISOString().slice(0, 16)); // Default to current date

// Mock agents array for demonstration
const agents = ref([
  {
    id: 1,
    name: "Agent 1",
    projectID: "",
    apiKey: "",
    interactions: 0,
    sessions: 0,
    topIntents: 0,
    topSlots: 0,
    understoodMessages: 0,
    uniqueUsers: 0,
    tokensConsumed: 0,
    error: null
  },
  // Add more agents as needed
]);

// Function to fetch analytics data for all metrics per agent
const fetchAnalyticsData = async () => {
  const metrics = ['interactions', 'sessions', 'intents', 'slots', 'messages', 'users', 'tokens'];

  // Validate the API key and project ID
  if (!apiKeyInput.value || !projectIdInput.value) {
    alert("Please enter a valid API key and Project ID.");
    return;
  }

  for (const agent of agents.value) {
    agent.apiKey = apiKeyInput.value; // Set API key
    agent.projectID = projectIdInput.value; // Set Project ID

    for (const metric of metrics) {
      try {
        const response = await axios.post('/analytics/data', {
          projectID: agent.projectID,
          apiKey: agent.apiKey,
          startTime: new Date(startTimeInput.value).toISOString(),
          endTime: new Date(endTimeInput.value).toISOString(),
          name: metric,
        });

        // Assign the result to the corresponding metric
        if (response.data.result && response.data.result.length > 0) {
          agent[metric] = response.data.result[0].count;
        }
        agent.error = null;
      } catch (err) {
        agent.error = `Failed to fetch ${metric} for ${agent.name}`;
        console.error(`Error fetching ${metric} for ${agent.name}:`, err.message);
      }
    }
  }
};
</script>


<style scoped>
/* Add any specific styling here */
</style>
