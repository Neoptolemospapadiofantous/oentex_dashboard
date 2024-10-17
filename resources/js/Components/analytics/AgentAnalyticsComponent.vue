<template>
  <div class="bg-white p-6 shadow rounded-lg w-full md:w-3/4 mx-auto">
    <h3 class="text-lg font-semibold mb-4 text-center">{{ agent.name }} Analytics</h3>

    <!-- Display table with data -->
    <div class="grid grid-cols-2 gap-4 mb-6">
      <div class="flex justify-between border-b py-2">
        <span>Interactions</span>
        <span>{{ interactions }}</span>
      </div>
      <div class="flex justify-between border-b py-2">
        <span>Sessions</span>
        <span>{{ sessions }}</span>
      </div>
      <div class="flex justify-between border-b py-2">
        <span>Top Intents</span>
        <span>{{ topIntents }}</span>
      </div>
      <div class="flex justify-between border-b py-2">
        <span>Top Slots</span>
        <span>{{ topSlots }}</span>
      </div>
      <div class="flex justify-between border-b py-2">
        <span>Understood Messages</span>
        <span>{{ understoodMessages }}</span>
      </div>
      <div class="flex justify-between border-b py-2">
        <span>Unique Users</span>
        <span>{{ uniqueUsers }}</span>
      </div>
      <div class="flex justify-between border-b py-2">
        <span>Tokens Consumed</span>
        <span>{{ tokensConsumed }}</span>
      </div>
    </div>

    <!-- ChartComponent -->
    <ChartComponent
      :interactions="interactions"
      :sessions="sessions"
      :topIntents="topIntents"
      :topSlots="topSlots"
      :understoodMessages="understoodMessages"
      :uniqueUsers="uniqueUsers"
      :tokensConsumed="tokensConsumed"
    />

    <InputError :message="error" />
  </div>
</template>

<script setup lang="ts">
import ChartComponent from './ChartComponent.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps<{
  agent?: any;
  interactions?: number;
  sessions?: number;
  topIntents?: number;
  topSlots?: number;
  understoodMessages?: number;
  uniqueUsers?: number;
  tokensConsumed?: number;
  error?: string | null;
}>();
</script>

<style scoped>
/* Add any component-specific styling here */
</style>
