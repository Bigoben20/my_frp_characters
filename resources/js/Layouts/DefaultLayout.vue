<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ToastList from '@/Components/ToastList.vue';

import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex flex-col items-stretch min-h-screen pt-6 bg-gray-100 sm:pt-0 dark:bg-gray-900">
        <ToastList></ToastList>
        
        <div class="fixed top-0 z-20 flex justify-center w-full bg-white shadow-sm">
            <div class="flex justify-between w-full max-w-6xl p-4">
                <Link href="/">
                    <ApplicationLogo class="w-10 h-10 text-gray-500 fill-current" />
                </Link>
                <div class="flex items-center gap-4">
                    <Link :href="route('login')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>
    
                    <Link :href="route('register')"
                        class="font-semibold text-gray-600 ms-4 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register
                    </Link>
                </div>
            </div>
        </div>

        <div class="mt-[72px]">
            <slot />
        </div>
    </div>
</template>
