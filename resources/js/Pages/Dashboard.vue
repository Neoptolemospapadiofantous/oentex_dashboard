<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
const { t } = useI18n();  // Translation function
const translate = t;       // Alias for better naming consistency


</script>


<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout :translate="translate">
        <!-- Header Slot -->
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
        <!-- Flex container to handle the layout between header, sidebar, and footer -->
        <div class="flex flex-col flex-1">
            <!-- Main content area with flex-grow to fill available space between header and footer -->
            <div class="flex-1 flex justify-center items-center">
                <div class="w-full max-w-3xl bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <h1 class="text-2xl font-bold mb-4">You're logged in!</h1>
                    <p class="text-gray-600">Welcome to your dashboard. Here you can manage your data, settings, and more.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>