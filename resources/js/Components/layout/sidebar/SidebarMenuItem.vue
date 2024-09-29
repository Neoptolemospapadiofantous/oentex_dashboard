<template>
  <li class="menu nav-item">
    <!-- Dropdown Menu -->
    <button
      v-if="hasDropdown"
      type="button"
      class="nav-link group w-full flex items-center justify-between"
      :class="{ active: activeDropdown }"
      @click="emitToggleDropdown"
    >
      <div class="flex items-center">
        <component :is="icon" class="group-hover:!text-primary shrink-0 w-4 h-4" />
        <span class="ltr:pl-3 rtl:pr-3 text-sm text-black dark:text-[#506690] dark:group-hover:text-white-dark">
          {{ title }}
        </span>
      </div>
      <IconCaretDown
        :rotate="!activeDropdown ? 0 : 180"
        class="transition-transform duration-300"
      />
    </button>

    <!-- Single Link Menu -->
    <router-link
      v-else
      :to="route"
      class="nav-link group w-full flex items-center justify-between"
      @click="emitClick"
    >
      <div class="flex items-center">
        <component :is="icon" class="group-hover:!text-primary shrink-0 w-4 h-4" />
        <span class="ltr:pl-3 rtl:pr-3 text-sm text-black dark:text-[#506690] dark:group-hover:text-white-dark">
          {{ title }}
        </span>
      </div>
    </router-link>

    <!-- Slot for dropdown sub-menus -->
    <slot />
  </li>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import IconCaretDown from '@/Components/icon/icon-carets-down.vue';

// Define props for the component
const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  route: {
    type: String,
    default: '', // For dropdowns without a direct route
  },
  icon: {
    type: Object,
    required: true,
  },
  hasDropdown: {
    type: Boolean,
    default: false,
  },
  activeDropdown: {
    type: Boolean,
    default: false,
  },
});

// Define the emits for this component
const emit = defineEmits(['toggleDropdown', 'click']);

// Emit the 'toggleDropdown' event
const emitToggleDropdown = () => {
  emit('toggleDropdown');
};

// Emit the 'click' event
const emitClick = () => {
  emit('click');
};
</script>
