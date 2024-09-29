<template>
  <ul class="relative font-semibold space-y-2 p-4">
    <SidebarMenuItem
      v-for="(menu, index) in menus"
      :key="index"
      :title="menu.title"
      :route="menu.route"
      :icon="getIconComponent(menu.icon)"
      :hasDropdown="!!menu.subMenu"
      :activeDropdown="activeDropdowns[menu.title]"
      @toggleDropdown="toggleDropdown(menu.title)"
    >
      <template v-if="menu.subMenu">
        <VueCollapsible :isOpen="activeDropdowns[menu.title]">
          <ul class="sub-menu text-sm text-gray-500 pl-4 space-y-1">
            <li v-for="(subMenuItem, subIndex) in menu.subMenu" :key="subIndex">
              <router-link :to="subMenuItem.route" class="block py-1 hover:text-primary transition">
                {{ subMenuItem.title }}
              </router-link>
            </li>
          </ul>
        </VueCollapsible>
      </template>
    </SidebarMenuItem>
  </ul>
</template>

<script lang="ts" setup>
import SidebarMenuItem from './SidebarMenuItem.vue';
import VueCollapsible from 'vue-height-collapsible/vue3';
import { ref, onMounted } from 'vue';

// Import all icons
import IconMenuDashboard from '@/Components/icon/menu/icon-menu-dashboard.vue';
import IconMinus from '@/Components/icon/icon-minus.vue';
import IconMenuChat from '@/Components/icon/menu/icon-menu-chat.vue';
import IconMenuMailbox from '@/Components/icon/menu/icon-menu-mailbox.vue';
import IconMenuTodo from '@/Components/icon/menu/icon-menu-todo.vue';
import IconMenuNotes from '@/Components/icon/menu/icon-menu-notes.vue';
import IconMenuScrumboard from '@/Components/icon/menu/icon-menu-scrumboard.vue';
import IconMenuContacts from '@/Components/icon/menu/icon-menu-contacts.vue';
import IconMenuInvoice from '@/Components/icon/menu/icon-menu-invoice.vue';
import IconMenuCalendar from '@/Components/icon/menu/icon-menu-calendar.vue';
import IconMenuComponents from '@/Components/icon/menu/icon-menu-components.vue';
import IconMenuElements from '@/Components/icon/menu/icon-menu-elements.vue';
import IconMenuCharts from '@/Components/icon/menu/icon-menu-charts.vue';
import IconMenuWidgets from '@/Components/icon/menu/icon-menu-widgets.vue';
import IconMenuFontIcons from '@/Components/icon/menu/icon-menu-font-icons.vue';
import IconMenuDragAndDrop from '@/Components/icon/menu/icon-menu-drag-and-drop.vue';
import IconMenuTables from '@/Components/icon/menu/icon-menu-tables.vue';
import IconMenuForms from '@/Components/icon/menu/icon-menu-forms.vue';
import IconMenuUsers from '@/Components/icon/menu/icon-menu-users.vue';
import IconMenuPages from '@/Components/icon/menu/icon-menu-pages.vue';
import IconMenuAuthentication from '@/Components/icon/menu/icon-menu-authentication.vue';
import IconMenuDocumentation from '@/Components/icon/menu/icon-menu-documentation.vue';

// Import the sidebar menu JSON
import menusData from './sidebarMenu.json';

// Define an icon map to associate each menu item with its icon
const iconMap = {
  dashboard: IconMenuDashboard,
  chat: IconMenuChat,
  mailbox: IconMenuMailbox,
  todoList: IconMenuTodo,
  notes: IconMenuNotes,
  scrumboard: IconMenuScrumboard,
  contacts: IconMenuContacts,
  invoice: IconMenuInvoice,
  calendar: IconMenuCalendar,
  components: IconMenuComponents,
  elements: IconMenuElements,
  charts: IconMenuCharts,
  widgets: IconMenuWidgets,
  fontIcons: IconMenuFontIcons,
  dragAndDrop: IconMenuDragAndDrop,
  tables: IconMenuTables,
  forms: IconMenuForms,
  users: IconMenuUsers,
  pages: IconMenuPages,
  authentication: IconMenuAuthentication,
  documentation: IconMenuDocumentation,
  default: IconMinus,
};

// Type for menu item icon keys
type IconKeys = keyof typeof iconMap;

// Get the corresponding icon component
const getIconComponent = (icon: string) => {
  return icon in iconMap ? iconMap[icon as IconKeys] : iconMap.default;
};

// Reference to the menus from JSON file
const menus = ref(menusData);

// Initialize all dropdowns to false (collapsed by default)
const activeDropdowns = ref<{ [key: string]: boolean }>({});

// Set all dropdowns to false (collapsed) on component mount
onMounted(() => {
  menus.value.forEach((menu: { title: string | number; }) => {
    activeDropdowns.value[menu.title] = false;
  });
});

// Toggle dropdowns for submenus
const toggleDropdown = (menuTitle: string) => {
  activeDropdowns.value[menuTitle] = !activeDropdowns.value[menuTitle];
};
</script>
