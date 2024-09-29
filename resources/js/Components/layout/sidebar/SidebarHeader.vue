<template>
  <div class="flex justify-between items-center px-4 py-3">
    <router-link v-if="!store.sidebar" to="/" class="main-logo flex items-center shrink-0">
      <img class="w-8 ml-[5px] flex-none" src="/assets/images/logo.svg" alt="Logo" />
      <span class="text-2xl ltr:ml-1.5 rtl:mr-1.5 font-semibold align-middle lg:inline dark:text-white-light">
        VRISTO
      </span>
    </router-link>

    <!-- Use a button element instead of href="javascript:;" for better accessibility -->
    <button
      class="collapse-icon w-8 h-8 rounded-full flex items-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180 hover:text-primary"
      @click="handleClick"
      type="button"
    >
      <IconCaretsDown :rotate="store.sidebar ? 90 : 270" />
    </button>
  </div>
</template>

<script lang="ts" setup>
// Importing necessary components
import IconCaretsDown from '@/Components/icon/icon-carets-down.vue';
import { useAppStore } from '@/stores/index';

// Initialize the store
const store = useAppStore();

// Define props with TypeScript
const props = defineProps<{
  toggleSidebar: () => void;
}>();

// Function to handle click events
const handleClick = (event: MouseEvent) => {
  props.toggleSidebar(); // Call the passed prop function
};
</script>
