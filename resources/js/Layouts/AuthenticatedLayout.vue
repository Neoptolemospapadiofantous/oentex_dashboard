<template>
  <div class="flex flex-col h-screen">
    <!-- Header with Slot -->
    <Header :translate="translate">
      <slot name="header"></slot>
    </Header>
    
    <!-- Main Content Area with Sidebar and Main Content -->
    <div class="flex flex-1 overflow-hidden h-full">
      <!-- Sidebar -->
      <Sidebar>
        <slot name="sidebar"></slot>
      </Sidebar>

      <!-- Main Content -->
      <MainArea>
        <slot name="main"></slot>
      </MainArea>
    </div>

    <!-- Footer -->
    <Footer>
      <slot name="footer"></slot>
    </Footer>
  </div>
</template>

<script setup lang="ts">
defineProps({
  translate: {
    type: Function,
    required: true,
  },
});

import Header from '@/Components/layout/Header.vue';
import Footer from '@/Components/layout/Footer.vue';
import Sidebar from '@/Components/layout/Sidebar.vue';
import MainArea from '@/Components/layout/MainArea.vue';
</script>

<style scoped>
/* Add any additional styles if necessary */
</style>
