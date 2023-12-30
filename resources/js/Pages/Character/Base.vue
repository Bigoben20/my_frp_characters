<template>
    <div class="w-full h-full p-4">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="flex flex-col items-start p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 col-span-full">
                <label for="name">İsim</label>
                <TextInput id="name" v-model="character.name" class="w-full" />
            </div>
            <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex flex-col items-start">
                    <label for="high_concept">High Concept</label>
                    <TextInput id="high_concept" v-model="character.high_concept" class="w-full" />
                </div>
                <div class="flex flex-col items-start">
                    <label for="trouble">Trouble</label>
                    <TextInput id="trouble" v-model="character.trouble" class="w-full" />
                </div>
                <div class="flex flex-col items-start">
                    <label for="relationship">Relationships</label>
                    <TextInput id="relationship" v-model="character.relationship" class="w-full" />
                </div>
                <div class="flex flex-col items-start">
                    <label for="aspect">Serbest Aspect</label>
                    <TextInput id="aspect" v-model="character.aspect" class="w-full" />
                </div>
                <div class="flex flex-col items-start">
                    <label for="aspect2">Serbest Aspect</label>
                    <TextInput id="aspect2" v-model="character.aspect2" class="w-full" />
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex flex-col items-start">
                    <label>Fiziksel Stress</label>
                    <div class="flex justify-between w-full gap-2 sm:justify-start">
                        <div v-for="(checkbox, index) in checkboxes" :key="index">
                            <input :id="'checkbox-' + (index + 1)" type="checkbox" v-model="checkbox.checked" @change="countChecked" class="hidden peer">
                            <label :for="'checkbox-' + (index + 1)"
                                class="inline-flex items-center justify-center w-10 h-10 text-transparent bg-white border-2 border-gray-200 rounded-lg cursor-pointer sm:w-12 sm:h-12 dark:bg-gray-800 dark:border-gray-700 peer-checked:border-emerald-600 dark:peer-checked:text-emerald-300 peer-checked:text-emerald-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="text-2xl fa-solid fa-check"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex flex-col items-start">
                    <label for="aspect">Stuntlar</label>
                    <TextAreaInput class="w-full" rows="15" />
                </div>
                <div class="flex justify-between gap-2">
                    <div class="flex flex-col-reverse items-center justify-between md:flex-row">
                        <input type="tel" id="refresh" v-mask="'#'" v-model="character.refresh" class="w-20 h-20 p-4 text-4xl bg-transparent border border-gray-300 rounded-full focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">
                        <label for="refresh" class="ml-2 text-3xl">Refresh</label>
                    </div>
                    <div class="flex flex-col items-center justify-between md:flex-row">
                        <label for="fp" class="mr-2 text-3xl">Fate Point</label>
                        <input type="tel" id="fp" v-mask="'#'" v-model="character.fate_point" class="w-20 h-20 p-4 text-4xl bg-transparent border border-gray-300 rounded-full focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import TextInput from '@/Components/TextInput.vue'
import TextAreaInput from '@/Components/TextAreaInput.vue'
import { ref } from 'vue'

const props = defineProps({
    character: {
        type: Object,
    }
})

const character = ref(props.character);
const checkboxes = ref([
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false }
]);
function countChecked() {
    // Herhangi bir değişiklikte seçili checkbox sayısını hesaplar
    character.value.physical_stress = checkboxes.value.filter(checkbox => checkbox.checked).length;
    console.log(character.value);
}
</script>

<style setup>
label {
    @apply text-gray-700 dark:text-gray-300
}
</style>