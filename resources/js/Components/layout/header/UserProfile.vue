<template>
  <div class="flex items-center space-x-2">
    <Popper
      :placement="store.rtlClass === 'rtl' ? 'bottom-end' : 'bottom-start'"
      offsetDistance="8"
      class="dropdown-menu"
    >
      <!-- User icon button with updated colors -->
      <button
        type="button"
        class="relative p-2 rounded-full bg-primary hover:bg-primary-light dark:bg-dark dark:hover:bg-dark-light"
      >
        <icon-user class="relative w-full h-full rounded-full object-cover" alt="User Icon" />
      </button>

      <!-- Dropdown content -->
      <template #content="{ close }">
        <ul class="dropdown-content text-dark dark:text-white-dark py-2 w-[230px] font-semibold bg-white dark:bg-black border border-gray-200 dark:border-gray-700">
          <li class="flex items-center px-4 py-4">
            <icon-user class="relative w-8 h-8 rounded-full" alt="User Icon" />
            <div class="ltr:pl-4 rtl:pr-4 truncate">
              <h4 class="text-base">{{user.name}}
                <span class="text-xs bg-success-light text-success rounded px-1 ltr:ml-2 rtl:ml-2">Pro</span>
              </h4>
              <a class="text-dark hover:text-primary dark:text-white-light dark:hover:text-primary">
                {{user.email}}
              </a>
            </div>
          </li>
          <li>
            <router-link to="/users/profile" class="dark:hover:text-white flex items-center py-2 px-4" @click="close()">
              <icon-user class="relative w-5 h-5 ltr:mr-2 rtl:ml-2" /> Profile
            </router-link>
          </li>
          <li>
            <router-link to="/apps/mailbox" class="dark:hover:text-white flex items-center py-2 px-4" @click="close()">
              <icon-mail-dot class="relative w-5 h-5 ltr:mr-2 rtl:ml-2" /> Inbox
            </router-link>
          </li>
          <li>
            <router-link to="/auth/boxed-lockscreen" class="dark:hover:text-white flex items-center py-2 px-4" @click="close()">
              <icon-lock-dots class="relative w-5 h-5 ltr:mr-2 rtl:ml-2" /> Lock Screen
            </router-link>
          </li>
          <li class="border-t border-gray-200 dark:border-gray-700">
            <DropdownLink :href="route('logout')" method="post" as="button" class="flex items-center py-2 px-4">
              <icon-logout class="relative w-5 h-5 ltr:mr-2 rtl:ml-2 rotate-90" /> Sign Out
            </DropdownLink>
          </li>
        </ul>
      </template>
    </Popper>
  </div>
</template>

<script lang="ts" setup>
import { useAppStore } from '@/stores';
import DropdownLink from '@/Components/DropdownLink.vue';
import IconUser from '@/Components/icon/icon-user.vue';
import IconMailDot from '@/Components/icon/icon-mail-dot.vue';
import IconLockDots from '@/Components/icon/icon-lock-dots.vue';
import IconLogout from '@/Components/icon/icon-logout.vue';
import { usePage } from '@inertiajs/vue3';
const { user } = usePage().props.auth;

const store = useAppStore();
</script>

<style scoped>
/* Define Popper-related CSS using variables */
:root {
  --popper-theme-background-color: #ffffff;
  --popper-theme-background-color-hover: #f9f9f9;
  --popper-theme-text-color: inherit;
  --popper-theme-border-width: 1px;
  --popper-theme-border-style: solid;
  --popper-theme-border-color: #eeeeee;
  --popper-theme-border-radius: 6px;
  --popper-theme-padding: 16px;
  --popper-theme-box-shadow: 0 6px 30px -6px rgba(0, 0, 0, 0.25);
}

.dropdown-menu {
  background-color: var(--popper-theme-background-color);
  box-shadow: var(--popper-theme-box-shadow);
  border: var(--popper-theme-border-width) var(--popper-theme-border-style) var(--popper-theme-border-color);
  border-radius: var(--popper-theme-border-radius);
  padding: var(--popper-theme-padding);
}
</style>
