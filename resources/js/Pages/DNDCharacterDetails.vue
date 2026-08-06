<template>
    <Head title="D&D Character Details" />
    
    <AuthenticatedLayout v-if="$page.props.auth.user">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">D&D Character Details</h2>
        </template>

        <Base :character="props.character"/>
    </AuthenticatedLayout>

    <DefaultLayout v-else>
        <Base :character="props.character"/>
    </DefaultLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Base from '@/Pages/Character/DndBase.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();
// console.log(page.props.auth.user);
 

const props = defineProps({
    character: {
        type: Object,
    },
    classes: {
        type: Object,
    },
})

page.props.classes = props.classes;
</script>

<style>

</style>