<template>
    <!-- From Uiverse.io by Galahhad -->
    <label class="switch">
        <input type="checkbox" :checked="modelValue" @change="toggle">
        <div class="slider">
            <div class="circle">
                <svg class="cross" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 365.696 365.696" y="0" x="0" height="6" width="6" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path data-original="#000000" fill="currentColor" d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0"></path>
                    </g>
                </svg>
                <svg class="checkmark" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 24 24" y="0" x="0" height="10" width="10" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path class="" data-original="#000000" fill="currentColor" d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
                    </g>
                </svg>
            </div>
        </div>
    </label>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    modelValue: {
        type: [Boolean,Number],
        default: false
    }
});

const emit = defineEmits(['update:modelValue']);

const toggle = (event) => {
    emit('update:modelValue', event.target.checked);
};
</script>

<style setup>
/* From Uiverse.io by Galahhad */
.switch {
    /* switch */
    --switch-width: 46px;
    --switch-height: 24px;
    --switch-bg: rgb(131, 131, 131);
    --switch-checked-bg: rgb(0, 218, 80);
    --switch-offset: calc((var(--switch-height) - var(--circle-diameter)) / 2);
    --switch-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
    /* circle */
    --circle-diameter: 18px;
    --circle-bg: #fff;
    --circle-shadow: 1px 1px 2px rgba(146, 146, 146, 0.45);
    --circle-checked-shadow: -1px 1px 2px rgba(163, 163, 163, 0.45);
    --circle-transition: var(--switch-transition);
    /* icon */
    --icon-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
    --icon-cross-color: var(--switch-bg);
    --icon-cross-size: 6px;
    --icon-checkmark-color: var(--switch-checked-bg);
    --icon-checkmark-size: 10px;
    /* effect line */
    --effect-width: calc(var(--circle-diameter) / 2);
    --effect-height: calc(var(--effect-width) / 2 - 1px);
    --effect-bg: var(--circle-bg);
    --effect-border-radius: 1px;
    --effect-transition: all .2s ease-in-out;
}

.switch input {
    display: none;
}

.switch {
    display: inline-block;
    width: var(--switch-width);
    height: var(--switch-height);
    background: var(--switch-bg);
    border-radius: var(--switch-height);
    position: relative;
    cursor: pointer;
    transition: var(--switch-transition);
}

.switch .slider {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: var(--switch-height);
    transition: var(--switch-transition);
}

.switch .circle {
    position: absolute;
    top: var(--switch-offset);
    left: var(--switch-offset);
    width: var(--circle-diameter);
    height: var(--circle-diameter);
    background: var(--circle-bg);
    border-radius: 50%;
    box-shadow: var(--circle-shadow);
    transition: var(--circle-transition);
}

.switch input:checked + .slider {
    background: var(--switch-checked-bg);
}

.switch input:checked + .slider .circle {
    transform: translateX(calc(var(--switch-width) - var(--circle-diameter) - var(--switch-offset) * 2));
    box-shadow: var(--circle-checked-shadow);
}

.switch input:checked + .slider .circle .cross {
    opacity: 0;
}

.switch input:checked + .slider .circle .checkmark {
    opacity: 1;
}

.switch .circle .cross,
.switch .circle .checkmark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transition: var(--icon-transition);
}

.switch .circle .cross {
    width: var(--icon-cross-size);
    height: var(--icon-cross-size);
    color: var(--icon-cross-color);
}

.switch .circle .checkmark {
    width: var(--icon-checkmark-size);
    height: var(--icon-checkmark-size);
    color: var(--icon-checkmark-color);
    opacity: 0;
}
</style>