<template>
  <header
    :class="{ dark: store.semidark && store.menu === 'horizontal' }"
    class="w-full bg-gray-800 text-white p-4 border-b border-gray-300 dark:border-gray-700"
  >
    <div class="container mx-auto flex flex-wrap items-center justify-between">
      <!-- Logo Section Outside Bordered Container -->
      <div class="w-full md:w-auto mb-4 md:mb-0">
        <Logo />
      </div>

      <!-- Search and Icons Section Inside Bordered Container -->
      <div class="shadow-sm flex items-center justify-between border border-gray-200 dark:border-gray-600 p-4 rounded-lg w-full md:w-auto">
        <div class="flex items-center space-x-4">
          <SearchBar :search="search" @toggleSearch="toggleSearch" />
          <ThemeToggle :theme="store.theme" @toggleTheme="toggleTheme" />
          <Notifications :messages="messages" :notifications="notifications" @removeNotification="removeNotification" @removeMessage="removeMessage" />
          <UserProfile />
        </div>
      </div>
    </div>
  </header>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { useAppStore } from '@/stores/index';
import Logo from './header/Logo.vue';
import SearchBar from './header/SearchBar.vue';
import ThemeToggle from './header/ThemeToggle.vue';
import Notifications from './header/Notifications.vue';
import UserProfile from './header/UserProfile.vue';

// Define types for notifications and messages
interface Notification {
  id: number;
  message: string;
  time: string;
}

interface Message {
  id: number;
  title: string;
  message: string;
  time: string;
}

// Store and reactive data
const store = useAppStore();
const search = ref(false);

// Initialize notifications and messages as arrays with the proper types
const notifications = ref<Notification[]>([]); // Array of Notification objects
const messages = ref<Message[]>([]); // Array of Message objects

// Methods to toggle functionality
const toggleSearch = () => {
  search.value = !search.value;
};

const toggleTheme = (theme: string) => {
  store.toggleTheme(theme);
};

// Methods for removing notifications and messages
const removeNotification = (id: number) => {
  notifications.value = notifications.value.filter((n) => n.id !== id);
};

const removeMessage = (id: number) => {
  messages.value = messages.value.filter((m) => m.id !== id);
};
</script>

<style scoped>
/* Add any specific styling here if necessary */
</style>
