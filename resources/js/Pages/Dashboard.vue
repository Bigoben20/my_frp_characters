<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps({
    characters: {
        type: Object,
    },
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 dark:text-gray-100 mb-4 font-semibold text-lg">Your Characters</div> 
                    <div class="mb-2">
                        <button class="px-4 py-1 bg-sky-100 text-sky-700 rounded hoverEffect">
                            Create
                        </button>
                    </div>
                    <div>
                        <table class="table-auto w-full text-left">
                            <thead class="dark:text-gray-300">
                              <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-3 py-1.5 rounded-l">ID</th>
                                <th class="px-3 py-1.5">Name</th>
                                <th class="px-3 py-1.5">High Concept</th>
                                <th class="px-3 py-1.5 rounded-r">
                                    <span>Actions</span>
                                </th>
                              </tr>
                            </thead>
                            <tbody class="dark:text-gray-100">
                              <tr v-for="character in characters" :key="character.id">
                                <td class="px-3 py-1.5">{{ character.id }}</td>
                                <td class="px-3 py-1.5">{{ character.name }}</td>
                                <td class="px-3 py-1.5">{{ character.high_concept }}</td>
                                <td class="px-3 py-1.5 w-[168px]">
                                    <div class="flex gap-2 items-center w-fit">
                                        <button class="px-4 py-1 bg-sky-100 text-sky-700 rounded hoverEffect">
                                            Details
                                        </button>
                                        <button class="px-4 py-1 bg-rose-100 text-rose-700 rounded hoverEffect">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
