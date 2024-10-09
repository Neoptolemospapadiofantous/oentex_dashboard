<template>
    <div class="dropdown shrink-0">
      <Popper :placement="store.rtlClass === 'rtl' ? 'bottom-end' : 'bottom-start'" offsetDistance="8">
        <button type="button" class="relative block p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:text-primary">
          <img class="w-9 h-9 rounded-full object-cover" src="/assets/images/user-profile.jpeg" alt="User Profile" />
        </button>
        <template #content="{ close }">
          <ul class="text-dark dark:text-white-dark !py-0 w-[230px] font-semibold dark:text-white-light/90">
            <li>
              <div class="flex items-center px-4 py-4">
                <img class="rounded-md w-10 h-10 object-cover" src="/assets/images/user-profile.jpeg" />
                <div class="ltr:pl-4 rtl:pr-4 truncate">
                  <h4 class="text-base">John Doe<span class="text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Pro</span></h4>
                  <a class="text-black/60 hover:text-primary dark:text-dark-light/60 dark:hover:text-white">johndoe@gmail.com</a>
                </div>
              </div>
            </li>
            <li><router-link to="/users/profile" class="dark:hover:text-white" @click="close()">Profile</router-link></li>
            <li><router-link to="/apps/mailbox" class="dark:hover:text-white" @click="close()">Inbox</router-link></li>
            <li><router-link to="/auth/boxed-lockscreen" class="dark:hover:text-white" @click="close()">Lock Screen</router-link></li>
            <li class="border-t border-white-light dark:border-white-light/10">
              <DropdownLink :href="route('logout')" method="post" as="button">Sign Out</DropdownLink>
            </li>
          </ul>
        </template>
      </Popper>
    </div>
  </template>
  
  <script lang="ts" setup>
import { useAppStore } from '@/stores';
import DropdownLink from '@/Components/DropdownLink.vue';

  const store = useAppStore(); // make sure useAppStore is correctly imported

  </script>
  
  <style scoped>
  /* Add specific styles here */
  </style>
  