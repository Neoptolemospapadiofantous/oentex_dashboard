<template>
    <div class="relative h-auto sm:h-80 md:h-96 lg:h-[500px] w-full">
      <canvas ref="agentChart" class="block w-full h-full"></canvas>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, watch, onUnmounted } from 'vue';
  import { Chart, BarController, CategoryScale, LinearScale, Tooltip, Legend, BarElement } from 'chart.js';
  
  Chart.register(BarController, CategoryScale, LinearScale, Tooltip, Legend, BarElement);
  
  // Define props for data input
  const props = defineProps<{
    interactions?: number;
    sessions?: number;
    topIntents?: number;
    topSlots?: number;
    understoodMessages?: number;
    uniqueUsers?: number;
    tokensConsumed?: number;
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
      // Destroy previous chart before rendering a new one
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
          maintainAspectRatio: false, // Allow dynamic height adjustments
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
              stacked: true,
              grid: {
                display: false,
              },
            },
            y: {
              beginAtZero: true,
              stacked: true,
              grid: {
                display: true,
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
  /* Ensure the canvas takes up the full width and height of its container */
  canvas {
    width: 100%;
    height: 100%;
  }
  </style>
  