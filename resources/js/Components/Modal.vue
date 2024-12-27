<script setup>
import { computed, onMounted, onUnmounted, watch, ref } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);

const isMobile = ref(window.innerWidth < 640);

const handleResize = () => {
    isMobile.value = window.innerWidth < 640;
};

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
    }
);

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => {
    document.addEventListener('keydown', closeOnEscape);
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    window.removeEventListener('resize', handleResize);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        'sm:max-w-sm': props.maxWidth === 'sm',
        'md:max-w-md': props.maxWidth === 'md',
        'lg:max-w-lg': props.maxWidth === 'lg',
        'xl:max-w-xl': props.maxWidth === 'xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <Teleport to="body">
        <transition name="mobile-slide" :duration="400">
            <div v-if="isMobile" class="outer fixed top-0 left-0 z-50 flex items-end w-[100vw] h-[100svh] overflow-hidden bg-black/60" v-show="show" @click.self="close()">
                <div class="w-full inner h-[60vh] px-8 pt-0 pb-6 overflow-y-scroll bg-white rounded-t-2xl">
                    <slot v-if="show" />
                </div>
            </div>
        </transition>
        <transition leave-active-class="duration-200">
            <div v-if="!isMobile" v-show="show" class="fixed inset-0 z-50 px-4 py-6 overflow-y-auto sm:px-0" scroll-region>
                <transition enter-active-class="duration-300 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="duration-200 ease-in"
                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <div v-show="show" class="fixed inset-0 transition-all transform">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"  @click.self="close()"/>
                    </div>
                </transition>

                <transition enter-active-class="duration-300 ease-out" enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95" enter-to-class="translate-y-0 opacity-100 sm:scale-100"
                    leave-active-class="duration-200 ease-in" leave-from-class="translate-y-0 opacity-100 sm:scale-100" leave-to-class="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95">
                    <div v-show="show" class="mb-6 overflow-hidden transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:w-full sm:mx-auto" :class="maxWidthClass">
                        <slot v-if="show" />
                    </div>
                </transition>
            </div>
        </transition>
    </Teleport>
</template>
