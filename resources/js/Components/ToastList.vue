<template>
    <transition-group tag="div" 
    enter-from-class="translate-x-full opacity-0"
    enter-active-class="duration-500"
    leave-active-class="duration-500"
    leave-to-class="translate-x-full opacity-0"
    class="fixed z-20 max-w-xs space-y-4 right-2 top-2 md:right-6 md:top-6">
        <ToastListItem 
        v-for="(item, index) in toast.items" :key="item.key"
        :toaster="item.type" :message="item.message"
        @remove="remove(index)"
        />
    </transition-group>
</template>

<script setup>
import ToastListItem from '@/Components/ToastListItem.vue'
import { onMounted, onUnmounted, ref, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import toast from '@/Stores/toast'

const page = usePage();

router.on('finish', () => {
    if (page.props.success && page.props.success != null) {
        toast.add({
            type:'success', message: page.props.success
        });

    }
    else if (page.props.warning && page.props.warning != null) {
        toast.add({
            type:'warning', message: page.props.warning
        });

    }
    else if (page.props.error && page.props.error != null) {
        toast.add({
            type:'error', message: page.props.error
        });

    }
});

function remove(index) {
    toast.remove(index);
}
</script>

<style>

</style>