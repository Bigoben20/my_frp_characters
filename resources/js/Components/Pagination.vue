<template>
    <div class="flex gap-6">
        <button class="px-2 py-0.5 rounded-full bg-indigo-50 hover:cursor-pointer"
            v-for="link in links" 
            :key="link.url" 
            @click="goTo(link.url)"
            :disabled="!link.url"
            v-html="link.label"
        >

        </button>
    </div>
</template>

<script>
import { router } from '@inertiajs/vue3';

export default {
    props: {
        links: Array
    },
    methods: {
        goTo(url) {
            router.visit(url);
        }
    }
}
</script>