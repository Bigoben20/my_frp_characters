<template>
    <Head title="Karakter Detayı" />
    
    <AuthenticatedLayout v-if="$page.props.auth.user">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Karakter Detayı</h2>
        </template>

        <Base :character="props.character" :skills="props.skills" :skillLabels="props.skillLabels"/>
    </AuthenticatedLayout>

    <DefaultLayout v-else>
        <Base :character="props.character" :skills="props.skills" :skillLabels="props.skillLabels"/>
    </DefaultLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Base from '@/Pages/Character/Base.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();
// console.log(page.props.auth.user);
 

const props = defineProps({
    character: {
        type: Object,
    },
    skills: {
        type: Object,
    },
    skillLabels: {
        type: Array,
    }
})

</script>

<style>

</style>