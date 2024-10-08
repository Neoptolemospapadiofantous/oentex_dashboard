<template>
    <div class="flex flex-col h-screen">
      <Header>
        <slot name="header"></slot>
      </Header>
      <div class="flex flex-1 overflow-hidden h-full">
        <Sidebar>
          <slot name="sidebar"></slot>
        </Sidebar>
        <MainArea>
          <slot name="main"></slot>
        </MainArea>
      </div>
      <Footer>
        <slot name="footer"></slot>
      </Footer>
    </div>
  </template>


<script setup lang="ts">
import Header from '@/Components/layout/Header.vue'
import Footer from '@/Components/layout/Footer.vue'
import Sidebar from '@/Components/layout/Sidebar.vue'
import MainArea from '@/Components/layout/MainArea.vue'
</script>
