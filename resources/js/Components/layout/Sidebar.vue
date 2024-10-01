<template>
  <div :class="{ 'dark text-white-dark': store.semidark }">
    <!-- Sidebar with dynamic width based on collapse state -->
    <nav
      :class="[ 'fixed top-[64px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300', store.sidebar ? 'w-[60px]' : 'w-[250px]' ]"
      style="height: calc(100vh - 64px);"
    >
      <div class="bg-white dark:bg-[#0e1726] h-full flex flex-col">
        <!-- Logo and Collapse Button -->
        <div class="flex justify-between items-center px-4 py-3">
          <!-- Main Logo (only visible when sidebar is expanded) -->
          <router-link
            v-if="!store.sidebar"
            to="/"
            class="main-logo flex items-center shrink-0"
          >
            <img
              class="w-8 ml-[5px] flex-none"
              src="../assets/logo.png"
              alt="Logo"
            />
            <span
              class="text-2xl ltr:ml-1.5 rtl:mr-1.5 font-semibold align-middle lg:inline dark:text-white-light"
            >
              VRISTO
            </span>
          </router-link>

          <!-- Collapse/Expand Button -->
          <button
            class="collapse-icon w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180 hover:text-primary"
            @click="toggleSidebar"
            type="button"
          >
            <IconCaretsDown :rotate="store.sidebar ? 90 : 270" />
          </button>
        </div>

        <!-- Sidebar Menu with perfect-scrollbar -->
        <perfect-scrollbar
          v-if="!store.sidebar"
          :options="{ swipeEasing: true, wheelPropagation: false }"
          class="flex-1 relative overflow-hidden"
        >
          <SidebarMenu />
        </perfect-scrollbar>
      </div>
    </nav>
  </div>
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
