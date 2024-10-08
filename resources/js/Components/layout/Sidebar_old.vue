<template>
  <aside :class="store.semidark ? 'dark text-white-dark' : ''" class="relative h-full">
    <!-- Sidebar container -->
    <nav
      :class="[
        'relative shadow-md z-50 transition-all duration-300', 
        store.sidebar ? 'w-16' : 'w-64' 
      ]"
      class="bg-white dark:bg-gray-800 h-full flex flex-col"
    >
      <!-- Header: Logo and collapse button -->
      <div class="flex justify-between items-center px-4 py-3">
        <!-- Main logo (visible only when expanded) -->
        <router-link
          v-if="!store.sidebar"
          to="/"
          class="flex items-center"
        >
          <img class="w-8" src="../assets/logo.png" alt="Logo" />
          <span class="text-2xl ml-2 font-semibold dark:text-white">
            VRISTO
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

      <!-- Sidebar Menu -->
      <div class="flex-1 overflow-auto">
        <SidebarMenu v-if="!store.sidebar" />
      </div>
    </nav>
  </aside>
</template>
<script lang="ts" setup>
defineProps({
            translate: {
                type: Function,
                required: true,
            },
});
import { useAppStore } from '@/stores/index';
import SidebarMenu from './sidebar/SidebarMenu.vue';
import IconCaretsDown from '@/Components/icon/icon-carets-down.vue';

const store = useAppStore();

const toggleSidebar = () => {
  store.toggleSidebar();
};
</script>
