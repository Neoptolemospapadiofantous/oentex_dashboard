<template>
  <div :class="{ 'dark text-white-dark': store.semidark }">
    <!-- Sidebar with dynamic width based on collapse state -->
    <nav
      :class="[ 'sidebar fixed min-h-screen h-full top-0 bottom-0 shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300', store.sidebar ? 'w-[60px]' : 'w-[260px]' ]"
    >
      <div class="bg-white dark:bg-[#0e1726] h-full">
        <div class="flex justify-between items-center px-4 py-3">
          <router-link
            v-if="!store.sidebar"
            to="/"
            class="main-logo flex items-center shrink-0"
          >
            <img
              class="w-8 ml-[5px] flex-none"
              src="../assets//logo.png"
              alt="Logo"
            />
            <span
              class="text-2xl ltr:ml-1.5 rtl:mr-1.5 font-semibold align-middle lg:inline dark:text-white-light"
            >
              VRISTO
            </span>
          </router-link>

          <!-- Collapse/Expand icon -->
          <button
            class="collapse-icon w-8 h-8 rounded-full flex items-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180 hover:text-primary"
            @click="toggleSidebar"
            type="button"
          >
            <IconCaretsDown :rotate="store.sidebar ? 90 : 270" />
          </button>
        </div>

        <!-- Render the Sidebar Menu -->
        <perfect-scrollbar
          v-if="!store.sidebar"
          :options="{ swipeEasing: true, wheelPropagation: false }"
          class="h-[calc(100vh-80px)] relative"
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
