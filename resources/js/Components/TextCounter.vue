<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    value: {
        type: String,
        required: true,
    },
    maxlength: {
        type: String,
        required: true
    }
});

</script>

<template>
    
    <div class="flex items-center justify-end w-full text-sm dark:text-white">
        <span class="text-lime-600 dark:text-lime-300">
            {{ value }}
        </span>
        &nbsp;/&nbsp; 
        <span class="">
            {{ maxlength }}
        </span>
    </div>
</template>
