<template>
  <aside :class="[store.semidark ? 'dark text-white-dark' : '', sidebarClasses]">
    <!-- Sidebar container -->
    <nav
      :class="[ 
        'relative shadow-md z-50 transition-all duration-300',
        store.sidebar ? 'w-16 overflow-hidden' : 'w-64',
        sidebarBackgroundClass
      ]"
      class="h-full flex flex-col"
    >
      <!-- Header: Title and Collapse button, aligned -->
      <div class="flex items-center justify-between px-7 py-7 w-full box-border">
        <!-- Title (aligned with the button) -->
        <router-link
          v-if="!store.sidebar"
          :to="homeLink"

        >
          <span class="text-3xl font-semibold dark:text-white pl-2 ">
            {{ brandName }}
          </span>
        </router-link>

        <!-- Collapse/Expand button -->
        <button
          class="w-8 h-8 rounded-full flex items-center justify-center 
                 hover:bg-gray-500/10 dark:hover:bg-gray-700/10 dark:text-white 
                 transition duration-300 hover:text-primary"
          @click="toggleSidebar"
        >
          <IconCaretsDown :rotate="store.sidebar ? 90 : 270" />
        </button>
      </div>

      <!-- Sidebar Menu with Perfect Scrollbar -->
      <div v-if="!store.sidebar" ref="scrollbarContainer" class="flex-1 relative overflow-hidden px-4 pt-4 pb-4 w-full box-border">
        <SidebarMenu />
      </div>
    </nav>
  </aside>
</template>



<script lang="ts" setup>
import { ref, onMounted, onBeforeUnmount, watch, defineProps } from 'vue';
import { useAppStore } from '@/stores/index';
import SidebarMenu from './sidebar/SidebarMenu.vue';
import IconCaretsDown from '@/Components/icon/icon-carets-down.vue';
import PerfectScrollbar from 'perfect-scrollbar';
import 'perfect-scrollbar/css/perfect-scrollbar.css';

const props = defineProps({
  brandName: {
    type: String,
    default: 'OENTEX',
  },
  homeLink: {
    type: String,
    default: '/',
  },
  sidebarClasses: {
    type: String,
    default: '',
  },
  sidebarBackgroundClass: {
    type: String,
    default: 'bg-white dark:bg-gray-800',
  },
});

const store = useAppStore();
const scrollbarContainer = ref<HTMLElement | null>(null);
let psInstance: PerfectScrollbar | null = null;

// Custom options for Perfect Scrollbar
const scrollOptions = {
  wheelSpeed: 1,
  wheelPropagation: false,
  suppressScrollX: true,
};

// Toggle the sidebar open and closed
const toggleSidebar = () => {
  store.toggleSidebar();

  if (store.sidebar) {
    // Sidebar is collapsed, destroy Perfect Scrollbar
    if (psInstance) {
      psInstance.destroy();
      psInstance = null;
    }
  } else {
    // Sidebar is expanded, initialize Perfect Scrollbar
    setTimeout(() => {
      if (scrollbarContainer.value) {
        psInstance = new PerfectScrollbar(scrollbarContainer.value, scrollOptions);
        // Apply initial theme styles to the scrollbar
        updateScrollbarTheme();
      }
    }, 300); // Wait for the transition to complete
  }
};

// Initialize Perfect Scrollbar on mount if sidebar is expanded
onMounted(() => {
  if (!store.sidebar && scrollbarContainer.value) {
    psInstance = new PerfectScrollbar(scrollbarContainer.value, scrollOptions);
    // Handle scroll event manually to trigger necessary UI updates
    scrollbarContainer.value.addEventListener('ps-scroll-y', handleScrollY);
    // Apply initial theme styles to the scrollbar
    updateScrollbarTheme();
  }
});

// Destroy Perfect Scrollbar on unmount
onBeforeUnmount(() => {
  if (psInstance) {
    psInstance.destroy();
    psInstance = null;
  }
});

// Watch for changes in the store theme (dark/light mode)
watch(
  () => store.isDarkMode,
  () => {
    if (psInstance) {
      updateScrollbarTheme();
      psInstance.update(); // Update Perfect Scrollbar after changing styles
    }
  }
);

// Handle the scroll event (for further customization, if needed)
const handleScrollY = () => {
  // Your code for handling scrolling can be added here if needed.
};

// Update Scrollbar theme dynamically based on the current theme
const updateScrollbarTheme = () => {
  if (scrollbarContainer.value) {
    // Select scrollbar elements
    const thumbElements = scrollbarContainer.value.querySelectorAll('.ps__thumb-y, .ps__thumb-x');
    const railElements = scrollbarContainer.value.querySelectorAll('.ps__rail-y, .ps__rail-x');

    // Update thumb style (handle appearance)
    thumbElements.forEach((thumb) => {
      const thumbElement = thumb as HTMLElement;
      thumbElement.style.backgroundColor = store.isDarkMode ? '#42b883' : '#3490dc'; // Update colors based on theme
      thumbElement.style.borderRadius = '4px';
      thumbElement.style.transition = 'background-color 0.2s linear, width 0.2s ease-in-out';
    });

    // Update rail style (track appearance)
    railElements.forEach((rail) => {
      const railElement = rail as HTMLElement;
      railElement.style.backgroundColor = store.isDarkMode ? '#1f2937' : '#f1f5f9'; // Match light/dark theme colors
      railElement.style.transition = 'background-color 0.2s linear';
    });
  }
};
</script>
