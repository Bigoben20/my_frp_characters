<template>
    <svg viewBox="0 0 100 100" class="dice-face drop-shadow-sm" :class="stateClasses" aria-hidden="true">
        <circle v-if="sides === 2" cx="50" cy="50" r="46" class="dice-shape" />
        <rect v-else-if="sides === 6" x="8" y="8" width="84" height="84" rx="18" class="dice-shape" />
        <polygon v-else :points="shape.points" class="dice-shape" stroke-linejoin="round" />
        <text
            x="50"
            :y="shape.textY"
            text-anchor="middle"
            dominant-baseline="central"
            font-weight="600"
            :font-size="fontSize"
            class="dice-value"
        >{{ display }}</text>
    </svg>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    sides: { type: Number, required: true },
    value: { type: Number, default: null },
    label: { type: String, default: '?' },
    rolling: { type: Boolean, default: false },
    settled: { type: Boolean, default: false },
    // Ardışık zarların ters yönde dönmesi için
    reverse: { type: Boolean, default: false },
});

// Kenar sayısına göre 2D siluet ve sayının dikey hizası
const SHAPES = {
    2: { textY: 52 },
    4: { points: '50,6 96,90 4,90', textY: 64 },
    6: { textY: 52 },
    8: { points: '50,3 97,50 50,97 3,50', textY: 51 },
    10: { points: '50,3 93,40 50,97 7,40', textY: 46 },
    12: { points: '50,8 94,40 77,91 23,91 6,40', textY: 55 },
    20: { points: '50,3 91,27 91,74 50,97 9,74 9,27', textY: 52 },
    100: { points: '50,4 77,13 94,36 94,64 77,87 50,96 23,87 6,64 6,36 23,13', textY: 52 },
};

const shape = computed(() => SHAPES[props.sides] ?? SHAPES[6]);

const display = computed(() => props.value ?? props.label);

const fontSize = computed(() => {
    const length = String(display.value).length;
    if (length <= 1) return 42;
    if (length === 2) return 36;
    if (length === 3) return 30;
    return 25;
});

const isCritMax = computed(() => props.settled && props.sides >= 4 && props.value === props.sides);
const isCritMin = computed(() => props.settled && props.sides >= 4 && props.value === 1);

const stateClasses = computed(() => ({
    'dice-face-rolling': props.rolling,
    'dice-face-reverse': props.rolling && props.reverse,
    'dice-face-settled': props.settled,
    'dice-face-max': isCritMax.value,
    'dice-face-min': isCritMin.value,
}));
</script>

<style scoped>
.dice-face {
    @apply w-full h-auto select-none;
}

.dice-shape {
    @apply fill-white stroke-indigo-500 dark:fill-gray-900 dark:stroke-indigo-400;
    stroke-width: 5;
    transition: stroke 0.2s ease;
}

.dice-value {
    @apply fill-gray-800 dark:fill-gray-100;
}

.dice-face-max .dice-shape {
    @apply stroke-emerald-500 dark:stroke-emerald-400;
}
.dice-face-max .dice-value {
    @apply fill-emerald-600 dark:fill-emerald-400;
}

.dice-face-min .dice-shape {
    @apply stroke-red-500 dark:stroke-red-400;
}
.dice-face-min .dice-value {
    @apply fill-red-600 dark:fill-red-400;
}

.dice-face-rolling {
    animation: dice-tumble 0.45s linear infinite;
}
.dice-face-reverse {
    animation-direction: reverse;
}

.dice-face-settled {
    animation: dice-pop 0.3s ease-out;
}

@keyframes dice-tumble {
    0% {
        transform: rotate(0deg) scale(1);
    }
    25% {
        transform: rotate(90deg) scale(0.88) translateY(-5%);
    }
    50% {
        transform: rotate(180deg) scale(1.06);
    }
    75% {
        transform: rotate(270deg) scale(0.9) translateY(4%);
    }
    100% {
        transform: rotate(360deg) scale(1);
    }
}

@keyframes dice-pop {
    0% {
        transform: scale(0.5);
    }
    60% {
        transform: scale(1.18);
    }
    100% {
        transform: scale(1);
    }
}

@media (prefers-reduced-motion: reduce) {
    .dice-face-rolling,
    .dice-face-settled {
        animation: none;
    }
}
</style>
