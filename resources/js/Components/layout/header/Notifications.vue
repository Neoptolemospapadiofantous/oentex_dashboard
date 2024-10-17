<template>
  <div class="flex items-center space-x-4">
    <!-- Notification Bell -->
    <div class="relative">
      <button @click="toggleNotifications" class="relative p-2 bg-gray-600 rounded-full">
        <icon-bell-bing />
        <span v-if="notifications.length" class="absolute top-0 right-0 w-3 h-3 bg-success rounded-full"></span>
      </button>
      <!-- Notifications Dropdown -->
      <div v-if="showNotifications" class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
        <h4 class="text-lg font-semibold">Notifications</h4>
        <ul class="mt-2">
          <li v-for="notification in notifications" :key="notification.id" class="flex justify-between items-center py-2 border-b border-gray-300 dark:border-gray-600">
            <div>
              <p v-html="notification.message" class="text-sm"></p>
              <span class="text-xs text-gray-500">{{ notification.time }}</span>
            </div>
            <button @click="$emit('removeNotification', notification.id)" class="text-gray-400 hover:text-red-600">
              <icon-x-circle class="w-5 h-5" />
            </button>
          </li>
          <li v-if="!notifications.length" class="text-center py-2">No new notifications</li>
        </ul>
      </div>
    </div>

    <!-- Messages -->
    <div class="relative">
      <button @click="toggleMessages" class="p-2 bg-gray-600 rounded-full">
        <icon-mail-dot />
      </button>
      <!-- Messages Dropdown -->
      <div v-if="showMessages" class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
        <h4 class="text-lg font-semibold">Messages</h4>
        <ul class="mt-2">
          <li v-for="message in messages" :key="message.id" class="flex justify-between items-center py-2 border-b border-gray-300 dark:border-gray-600">
            <div>
              <p v-html="message.title" class="text-sm font-semibold"></p>
              <p class="text-xs">{{ message.message }}</p>
              <span class="text-xs text-gray-500">{{ message.time }}</span>
            </div>
            <button @click="$emit('removeMessage', message.id)" class="text-gray-400 hover:text-red-600">
              <icon-x-circle class="w-5 h-5" />
            </button>
          </li>
          <li v-if="!messages.length" class="text-center py-2">No new messages</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref,  } from 'vue';
import IconBellBing from '@/Components/icon/icon-bell-bing.vue';
import IconMailDot from '@/Components/icon/icon-mail-dot.vue';
import IconXCircle from '@/Components/icon/icon-x-circle.vue';

// Define interfaces for the types of notifications and messages
interface Notification {
  id: number;
  message: string;  // Notification message
  time: string;     // Time of the notification
}

interface Message {
  id: number;
  title: string;    // Title of the message
  message: string;  // Message content
  time: string;     // Time of the message
}

// Define the props types
const props = defineProps<{
  notifications: Notification[];
  messages: Message[];
}>();

const showNotifications = ref(false);
const showMessages = ref(false);

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value;
  showMessages.value = false; // Close messages if open
};

const toggleMessages = () => {
  showMessages.value = !showMessages.value;
  showNotifications.value = false; // Close notifications if open
};
</script>

<style scoped>
/* Add any specific styling here if necessary */
</style>
