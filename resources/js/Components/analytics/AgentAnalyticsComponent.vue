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

    <!-- Chart for visualization -->
    <div class="relative h-80">
      <canvas ref="agentChart" class="block w-full h-full"></canvas>
    </div>

    <InputError :message="error" />
  </div>
</template>

<script setup lang="ts">
import { ref, watch, onUnmounted } from 'vue';
import { Chart, BarController, CategoryScale, LinearScale, Tooltip, Legend, BarElement } from 'chart.js';
import InputError from '@/Components/InputError.vue';

Chart.register(BarController, CategoryScale, LinearScale, Tooltip, Legend, BarElement);

// Define props
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

// Chart reference
const agentChart = ref<HTMLCanvasElement | null>(null);
let chartInstance: Chart | null = null;

// Function to destroy the existing chart
const destroyChart = () => {
  if (chartInstance) {
    chartInstance.destroy();
    chartInstance = null;
  }
};

// Render the chart
const renderChart = () => {
  if (agentChart.value) {
    // Destroy the previous chart before rendering a new one
    destroyChart();

    chartInstance = new Chart(agentChart.value, {
      type: 'bar',
      data: {
        labels: ['Interactions', 'Sessions', 'Top Intents', 'Top Slots', 'Understood Messages', 'Unique Users', 'Tokens Consumed'], // Metric names as labels
        datasets: [
          {
            label: 'Interactions',
            data: [props.interactions || 0, 0, 0, 0, 0, 0, 0],
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
          },
          {
            label: 'Sessions',
            data: [0, props.sessions || 0, 0, 0, 0, 0, 0],
            backgroundColor: 'rgba(192, 75, 75, 0.8)',
            borderColor: 'rgba(192, 75, 75, 1)',
            borderWidth: 1,
          },
          {
            label: 'Top Intents',
            data: [0, 0, props.topIntents || 0, 0, 0, 0, 0],
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
          },
          {
            label: 'Top Slots',
            data: [0, 0, 0, props.topSlots || 0, 0, 0, 0],
            backgroundColor: 'rgba(255, 206, 86, 0.8)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1,
          },
          {
            label: 'Understood Messages',
            data: [0, 0, 0, 0, props.understoodMessages || 0, 0, 0],
            backgroundColor: 'rgba(153, 102, 255, 0.8)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1,
          },
          {
            label: 'Unique Users',
            data: [0, 0, 0, 0, 0, props.uniqueUsers || 0, 0],
            backgroundColor: 'rgba(255, 159, 64, 0.8)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1,
          },
          {
            label: 'Tokens Consumed',
            data: [0, 0, 0, 0, 0, 0, props.tokensConsumed || 0],
            backgroundColor: 'rgba(255, 99, 132, 0.8)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,  // Allow the chart to adjust to the container size
        plugins: {
          tooltip: { enabled: true },
          legend: {
            position: 'top',
            onClick: (e, legendItem, legend) => {
              const index = legendItem.datasetIndex;
              const chart = legend.chart;
              const meta = chart.getDatasetMeta(index);
              meta.hidden = !meta.hidden;
              chart.update();
            },
          },
        },
        scales: {
          x: {
            stacked: true,  // Keep bars stacked for better alignment
            grid: {
              display: false,  // Optional: remove vertical grid lines
            },
          },
          y: {
            beginAtZero: true,
            stacked: true,  // Ensure bars remain full-scale even when hidden
            grid: {
              display: true,  // Optional: show horizontal grid lines
            },
          },
        },
      },
    });
  }
};

// Watch for changes in the props to re-render the chart
watch(
  [
    () => props.interactions,
    () => props.sessions,
    () => props.topIntents,
    () => props.topSlots,
    () => props.understoodMessages,
    () => props.uniqueUsers,
    () => props.tokensConsumed,
  ],
  () => {
    renderChart();
  }
);

// Destroy the chart when the component is unmounted
onUnmounted(() => {
  destroyChart();
});
</script>

<style scoped>
canvas {
  margin: 0 auto;
}
</style>
