<template>
    <form @submit.prevent="updateCharacter">
        <div class="w-full h-full p-4 pb-32">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <!-- Names -->
                <div class="flex flex-col items-start p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 col-span-full">
                    <label for="name">İsim</label>
                    <Textinput :auth="checkUser" id="name" v-model="character.characterData.name" class="w-full" />
                </div>
                <div class="flex flex-col gap-6">
                    <!-- Aspects -->
                    <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="-mb-4">
                            <span class="header dark:text-gray-200">Aspects</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="high_concept">High Concept</label>
                            <Textinput :auth="checkUser" id="high_concept" v-model="character.characterData.high_concept" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="trouble">Trouble</label>
                            <Textinput :auth="checkUser" id="trouble" v-model="character.characterData.trouble" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="relationship">Relationships</label>
                            <Textinput :auth="checkUser" id="relationship" v-model="character.characterData.relationship" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="aspect">Serbest Aspect</label>
                            <Textinput :auth="checkUser" id="aspect" v-model="character.characterData.aspect" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="aspect2">Serbest Aspect</label>
                            <Textinput :auth="checkUser" id="aspect2" v-model="character.characterData.aspect2" class="w-full" />
                        </div>
                    </div>

                    <!-- Stunts -->
                    <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="-mb-4">
                            <span class="header dark:text-gray-200">Stunts</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="aspect">Stuntlar</label>
                            <TextAreainput :auth="checkUser" v-model="character.characterData.stunts" class="w-full" rows="15" />
                        </div>
                        <div class="flex justify-between gap-2">
                            <div class="flex flex-col-reverse items-center justify-between md:flex-row">
                                <input :disabled="!checkUser" type="number" id="refresh" v-mask="'#'" v-model="character.characterData.refresh"
                                    class="w-20 h-20 p-4 text-4xl bg-transparent border border-gray-300 rounded-full focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">
                                <label for="refresh" class="ml-2 text-3xl">Refresh</label>
                            </div>
                            <div class="flex flex-col items-center justify-between md:flex-row">
                                <label for="fp" class="mr-2 text-3xl">Fate Point</label>
                                <input :disabled="!checkUser" type="number" id="fp" v-mask="'#'" v-model="character.characterData.fate_point"
                                    class="w-20 h-20 p-4 text-4xl bg-transparent border border-gray-300 rounded-full focus:ring-indigo-500 focus:border-indigo-500 dark:text-gray-300">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-6">

                    <!-- Stresses -->
                    <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="-mb-4">
                            <span class="header dark:text-gray-200">Stress</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <label>Fiziksel</label>
                            <div class="flex justify-between w-full gap-2 sm:justify-start">
                                <div v-for="(checkbox, index) in physicalBoxes" :key="index">
                                    <input :disabled="!checkUser" :id="'physical-' + (index + 1)" type="checkbox" v-model="checkbox.checked" @change="countChecked" class="hidden peer">
                                    <label :for="'physical-' + (index + 1)"
                                        class="inline-flex items-center justify-center w-10 h-10 text-transparent bg-white border-2 border-gray-300 rounded-lg cursor-pointer sm:w-12 sm:h-12 dark:bg-gray-800 dark:border-gray-700 peer-checked:border-pink-600 dark:peer-checked:text-pink-300 peer-checked:text-pink-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <i class="text-2xl fa-solid fa-check"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-start">
                            <label>Zihinsel</label>
                            <div class="flex justify-between w-full gap-2 sm:justify-start">
                                <div v-for="(checkbox, index) in mentalBoxes" :key="index">
                                    <input :disabled="!checkUser" :id="'mental-' + (index + 1)" type="checkbox" v-model="checkbox.checked" @change="countChecked" class="hidden peer">
                                    
                                    <label :for="'mental-' + (index + 1)"
                                        class="inline-flex items-center justify-center w-10 h-10 text-transparent bg-white border-2 border-gray-300 rounded-lg cursor-pointer sm:w-12 sm:h-12 dark:bg-gray-800 dark:border-gray-700 peer-checked:border-cyan-600 dark:peer-checked:text-cyan-300 peer-checked:text-cyan-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <i class="text-2xl fa-solid fa-check"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="-mb-4">
                            <span class="header dark:text-gray-200">Consequences</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="mild">Hafif</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">2</div>
                                <Textinput :auth="checkUser" id="mild" v-model="character.characterData.mild" class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="moderate">Orta</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">4</div>
                                <Textinput :auth="checkUser" id="moderate" v-model="character.characterData.moderate" class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="severe">Ağır</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">6</div>
                                <Textinput :auth="checkUser" id="severe" v-model="character.characterData.severe" class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="extreme">Kritik</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">8</div>
                                <Textinput :auth="checkUser" id="extreme" v-model="character.characterData.extreme" class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col items-start opacity-50">
                            <label for="mild2">Hafif</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">2</div>
                                <Textinput :auth="checkUser" id="mild2" v-model="character.characterData.mild2" class="w-full" />
                            </div>
                        </div>
                    </div>
                    <!-- Skills -->
                    <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="-mb-4">
                            <span class="header dark:text-gray-200">Skills</span>
                        </div>
                        <div class="flex flex-col items-stretch gap-4">
                            <div v-for="(skill, index) in skills" :key="index" class="flex items-center gap-2 text-xl tracking-wide dark:text-gray-100">
                                <input v-if="checkUser" type="number" v-mask="'#'" min="0" v-model="skills_data[index]"
                                    class="w-16 h-16 p-2 text-center bg-transparent border border-gray-300 rounded-full dark:border-gray-600">
                                <div v-else class="flex items-center justify-center w-16 h-16 p-2 text-center bg-transparent border border-gray-300 rounded-full dark:border-gray-600">
                                    {{ skills_data[index] }}
                                </div>
                                <span>
                                    {{ $t(`skills.${skill}`) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed left-0 w-full px-2 bottom-2 z-[1000]" v-if="checkUser">
            <div class="flex justify-between gap-2 p-4 bg-white border border-gray-300 rounded-lg dark:bg-opacity-10 dark:border-gray-800 backdrop-blur-md">
                <button type="button" class=" text-amber-600 bg-amber-100 generalButton" @click="openMore = !openMore">
                    <span>Notlar</span>

                    <svg class="ms-2 -me-0.5 h-4 w-4 rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button class="w-1/3 text-green-600 bg-green-100 generalButton" type="submit">
                    <span>Kaydet</span>
                    <MiniLoader :show="saveLoading" radius="4" />
                </button>
            </div>
        </div>
    </form>

    <div class="fixed top-0 left-0 w-full h-full bg-gray-800/30 dark:bg-gray-900/50" v-show="openMore" @click.self="openMore = false">
        <transition name="slide-fade">
            <div class="absolute top-0 right-0 w-4/5 h-full transition-all duration-300 ease-in bg-white shadow-xl dark:bg-gray-800 lg:w-1/3" v-show="openMore">
                <div class="h-full p-4">
                    <button type="button" class="absolute flex items-center justify-center w-6 h-6 rounded-full text-sky-600 bg-sky-100 right-2 top-2" @click="openMore = false">
                        <i class="text-[11px] fa-solid fa-x"></i>
                    </button>
                    <div class="mt-4">
                        <label for="notes" class="">Notes</label>
                        <TextAreainput id="notes" :auth="checkUser" v-model="character.characterData.notes" class="w-full" rows="15" />
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import Textinput from '@/Components/TextInput.vue';
import TextAreainput from '@/Components/TextAreaInput.vue';
import { computed, ref } from 'vue'
import { router, useForm, usePage } from '@inertiajs/vue3';
import MiniLoader from '@/Components/MiniLoader.vue';
import NProgress from 'nprogress'
import Dropdown from '@/Components/Dropdown.vue';

const props = defineProps({
    character: {
        type: Object,
    },
    skills: {
        type: Object,
    }
})

const page = usePage();
const checkUser = ref(page.props.auth.user.id == props.character.user_id);
const character = useForm({ characterData: props.character, skills: props.skills });
// console.log(character);
const physicalBoxes = ref([
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false }
]);
const mentalBoxes = ref([
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false },
    { checked: false }
]);

if (character.characterData.physical_stress != null) {
    for (let index = 0; index < character.characterData.physical_stress; index++) {
        physicalBoxes.value[index].checked = true;
    }
}
if (character.characterData.mental_stress != null) {
    for (let index = 0; index < character.characterData.mental_stress; index++) {
        mentalBoxes.value[index].checked = true;
    }
}

const saveLoading = ref(false);
const errors = ref([]);

function countChecked() {
    // Herhangi bir değişiklikte seçili checkbox sayısını hesaplar
    character.characterData.physical_stress = physicalBoxes.value.filter(checkbox => checkbox.checked).length;
    character.characterData.mental_stress = mentalBoxes.value.filter(checkbox => checkbox.checked).length;
    console.log(character.characterData);
}

const skills = ref(JSON.parse(props.skills.skills));
const skills_data = ref(JSON.parse(props.skills.skills_data));
// console.log(JSON.parse(props.skills.skills));

const updateCharacter = async () => {
    NProgress.start()
    saveLoading.value = true;
    character.skills.skills_data = JSON.stringify(skills_data.value);
    character.post('/character-update', {
        preserveScroll: true,
        onSuccess: (success) => {
            // console.log(success);
        },
        onError: (error) => {
            // console.log(error);
            let keys = Object.keys(error)
            for (let index = 0; index < keys.length; index++) {
                errors.value.push(error[keys[index]]);
            }
        },
        onFinish: () => {
            saveLoading.value = false;
            NProgress.done()
        }
    });
}

const openMore = ref(false);
</script>

<style setup>
label {
    @apply text-gray-700 dark:text-gray-300;
}
</style>