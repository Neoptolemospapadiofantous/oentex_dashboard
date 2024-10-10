<template>
    <div class="bg-white p-2 shadow rounded-lg">
      <h3 class="text-md font-semibold mb-2">Interactions</h3>
      <!-- Display the interaction count -->
      <p class="text-xl font-bold">{{ interactions }}</p>
  
      <!-- Canvas for donut chart with dynamic size -->
      <div class="mx-auto" :style="{ width: chartSize, height: chartSize }">
        <canvas ref="interactionsChart"></canvas>
      </div>
  
      <!-- Error handling -->
      <InputError :message="error" />
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, watch, computed } from 'vue';
  import { Chart, DoughnutController, ArcElement, Tooltip, Legend } from 'chart.js';
  import InputError from '@/Components/InputError.vue';
  
  // Register necessary chart components
  Chart.register(DoughnutController, ArcElement, Tooltip, Legend);
  
  // Define props
  const props = defineProps({
    interactions: {
      type: Number,
      required: true,
    },
    error: {
      type: String,
      default: null,
    },
    size: {
      type: String,
      default: '300px', // Default size for the chart
    },
  });
  
  // Computed property to get the chart size dynamically
  const chartSize = computed(() => props.size);
  
  // Reference for chart DOM element
  const interactionsChart = ref(null);
  
  // Watch for changes in the interactions prop and load the chart when data is ready
  watch(() => props.interactions, (newInteractions) => {
    if (interactionsChart.value && newInteractions !== null) {
      const remaining = Math.max(0, 100 - newInteractions); // Ensure remaining is at least 0
  
      // Create or update the doughnut chart to represent the interactions
      new Chart(interactionsChart.value, {
        type: 'doughnut',
        data: {
          labels: ['Interactions', 'Remaining'],
          datasets: [
            {
              data: [newInteractions, remaining], // Show interactions and remaining
              backgroundColor: ['rgba(75, 192, 192, 0.8)', 'rgba(192, 75, 75, 0.2)'],
              borderColor: ['rgba(75, 192, 192, 1)', 'rgba(192, 75, 75, 0.2)'],
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false, // Allow the chart to resize based on the container
          plugins: {
            tooltip: {
              enabled: true,
            },
            legend: {
              position: 'top',
            },
          },
        },
      });
    }
  }, { immediate: true });
  </script>
  
  <style scoped>
  /* Add any specific styling here if necessary */
  </style>
  