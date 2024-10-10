<template>
  <div class="bg-white p-4 shadow rounded-lg">
    <h3 class="text-lg font-semibold mb-4">Sessions</h3>
    <canvas ref="sessionsChart"></canvas>
    <InputError :message="error" />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Chart } from 'chart.js';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  sessions: {
    type: Array,
    required: true
  },
  error: {
    type: String,
    default: null
  }
});

const sessionsChart = ref(null);

onMounted(() => {
  if (sessionsChart.value && props.sessions.length) {
    new Chart(sessionsChart.value, {
      type: 'bar',
      data: {
        labels: props.sessions.map((_, index) => `Session ${index + 1}`),
        datasets: [{
          label: 'Number of Sessions',
          data: props.sessions,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true
      }
    });
  }
});
</script>
