<template>
    <form @submit.prevent="updateCharacter">
        <div class="w-full h-full p-4 pb-32">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <!-- Names -->
                <div class="grid grid-cols-[110px_auto] items-center gap-4 p-4 bg-white rounded-lg shadow-md col-span-full dark:bg-gray-800">
                    <div class="w-[110px] h-[110px]">
                        <div class="w-full h-full overflow-hidden border rounded dark:border-gray-600">
                            <div class="relative flex items-center justify-center w-full h-full bg-gray-100 dark:bg-gray-900 group">
                                <i class="text-5xl text-gray-500 fa-solid fa-user" v-if="!character.characterData.img_url"></i>
                                <img :src="character.characterData.img_url" v-else>
                                <div class="absolute invisible bottom-1 right-2 group-hover:visible">
                                    <CharacterImageModal :auth="checkUser" :character="character.characterData"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-start w-full">
                        <label for="name">Name</label>
                        <TextAreainput maxlength="300" rows="2" :auth="checkUser" id="name" v-model="character.characterData.name" class="w-full" />
                        <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.name)" />
                    </div>
                </div>
                <div class="flex flex-col gap-6">
                    <!-- Aspects -->
                    <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="-mb-4">
                            <span class="header dark:text-gray-200">Aspects</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="high_concept">High Concept</label>
                            <TextAreainput maxlength="300" rows="2" :auth="checkUser" id="high_concept" v-model="character.characterData.high_concept" class="w-full" />
                            <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.high_concept)" />
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="trouble">Trouble</label>
                            <TextAreainput maxlength="300" rows="2" :auth="checkUser" id="trouble" v-model="character.characterData.trouble" class="w-full" />
                            <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.trouble)" />
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="relationship">Relationships</label>
                            <TextAreainput maxlength="300" rows="2" :auth="checkUser" id="relationship" v-model="character.characterData.relationship" class="w-full" />
                            <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.relationship)" />
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="aspect">Serbest Aspect</label>
                            <TextAreainput maxlength="300" rows="2" :auth="checkUser" id="aspect" v-model="character.characterData.aspect" class="w-full" />
                            <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.aspect)" />
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="aspect2">Serbest Aspect</label>
                            <TextAreainput maxlength="300" rows="2" :auth="checkUser" id="aspect2" v-model="character.characterData.aspect2" class="w-full" />
                            <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.aspect2)" />
                        </div>
                    </div>

                    <!-- Stunts -->
                    <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="-mb-4">
                            <span class="header dark:text-gray-200">Stunts</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="aspect">Stuntlar</label>
                            <TextAreainput maxlength="2000" :auth="checkUser" v-model="character.characterData.stunts" class="w-full" rows="15" />
                            <TextCounter v-if="checkUser" maxlength="2000" :value="getLength(character.characterData.stunts)" />
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
                                <Textinput :auth="checkUser" maxlength="200" id="mild" v-model="character.characterData.mild" class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="moderate">Orta</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">4</div>
                                <Textinput :auth="checkUser" maxlength="200" id="moderate" v-model="character.characterData.moderate" class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="severe">Ağır</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">6</div>
                                <Textinput :auth="checkUser" maxlength="200" id="severe" v-model="character.characterData.severe" class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col items-start">
                            <label for="extreme">Kritik</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">8</div>
                                <Textinput :auth="checkUser" maxlength="200" id="extreme" v-model="character.characterData.extreme" class="w-full" />
                            </div>
                        </div>
                        <div class="flex flex-col items-start opacity-50">
                            <label for="mild2">Hafif</label>
                            <div class="flex w-full gap-1">
                                <div class="h-[42px] max-w-[42px] w-full text-center p-2 border border-gray-300 dark:border-gray-700 rounded font-semibold text-gray-400">2</div>
                                <Textinput :auth="checkUser" maxlength="200" id="mild2" v-model="character.characterData.mild2" class="w-full" />
                            </div>
                        </div>
                    </div>
                    <!-- Skills -->
                    <div class="flex flex-col gap-4 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="dark:text-gray-200">
                            <span class="header">Skills</span>
                            <div>
                                <span class="">Total: </span>
                                <span class="font-semibold text-pink-600 dark:text-pink-300">{{ total }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-2 xl:grid-cols-3 gap-y-4 gap-x-2">
                            <div v-for="(skillLabel, index) in skillLabels" :key="index" class="flex items-center gap-2 text-xl tracking-wide dark:text-gray-100">
                                <input v-if="checkUser" type="number" v-mask="'##'" min="0" v-model="skills_data[index]"
                                    class="w-16 h-16 p-2 text-center bg-transparent border border-gray-300 rounded-full dark:border-gray-600">
                                <div v-else class="flex items-center justify-center w-16 h-16 p-2 text-center bg-transparent border border-gray-300 rounded-full dark:border-gray-600">
                                    {{ skills_data[index] }}
                                </div>
                                <span>
                                    {{ skillLabel }}
                                    <!-- {{ $t(`skills.${skillLabel}`) }} -->
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom -->
        <div class="fixed left-0 z-40 w-full px-2 bottom-2" v-if="checkUser">
            <div class="flex gap-2 p-4 bg-white bg-opacity-50 border border-gray-300 rounded-lg dark:bg-opacity-10 dark:border-gray-800 backdrop-blur-md">
                <div class="grid w-full grid-cols-6 gap-2 sm:grid-cols-12">
                    <button type="button" class="text-red-600 bg-red-100 generalButton" @click="deleteModalShow = true;">
                        <i class="text-xs fa-solid fa-trash"></i>
                        <span class="hidden sm:block">Sil</span>
                    </button>
                    <button type="button" class="col-span-2 col-start-3 text-amber-600 bg-amber-100 generalButton" @click="openMore = !openMore">
                        <i class="fa-solid fa-note-sticky"></i>
                        <span class="hidden sm:block">Notlar</span>
                    </button>
                    <button type="button" class="col-span-2 col-start-5 text-indigo-600 bg-indigo-100 generalButton" @click="zarModalShow = true;">
                        <i class="text-xs fa-solid fa-dice"></i>
                        <span class="hidden sm:block">Zar</span>
                    </button>
                    <button type="button" class="col-start-2 row-start-2 sm:row-start-1 sm:col-start-8 text-neutral-600 bg-neutral-100 generalButton" @click="copyUrl">
                        <i class="text-xs fa-solid fa-share" v-show="!copied"></i>
                        <i class="text-xs fa-solid fa-check" v-show="copied"></i>
                    </button>
                    <button class="w-full col-span-6 col-start-1 row-start-1 text-green-600 bg-green-100 sm:col-start-9 sm:col-span-4 generalButton" type="submit">
                        <MiniLoader :show="saveLoading" radius="4" />
                        <i class="fa-solid fa-save" v-show="!saveLoading"></i>
                        <span class="hidden sm:block">Kaydet</span>
                    </button>
                </div>
            </div>
        </div>

    </form>

    <!-- Notes -->
    <div class="fixed top-0 left-0 w-full h-full bg-gray-800/30 dark:bg-gray-900/50" v-show="openMore" @click.self="openMore = false">
        <transition name="slide-fade">
            <div class="absolute top-0 right-0 w-4/5 h-full overflow-scroll transition-all duration-300 ease-in bg-white shadow-xl dark:bg-gray-800 lg:w-1/3" v-show="openMore">
                <div class="h-full p-4">
                    <button type="button" class="absolute flex items-center justify-center w-6 h-6 rounded-full text-sky-600 bg-sky-100 right-2 top-2" @click="openMore = false">
                        <i class="text-[11px] fa-solid fa-x"></i>
                    </button>
                    <div class="h-full mt-4">
                        <label for="notes" class="">Notes</label>
                        <TextAreainput id="notes" :auth="checkUser" v-model="character.characterData.notes" class="w-full h-[calc(100%-124px)]" rows="15" />
                    </div>
                    <!-- <div class="pb-40 mt-6">
                        <Roll></Roll>
                    </div> -->
                </div>
            </div>
        </transition>
    </div>

    <!-- Delete Modal -->
    <Modal :show="deleteModalShow">
        <div class="p-6">
            <div class="relative mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Karakteri Sil
                </h2>
                <button class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect" @click="deleteModalShow = false;">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>
            <div class="my-6 dark:text-gray-200">
                "{{ character.characterData.name }}" karakterini silmek istediğinize emin misiniz?
            </div>
            <div class="flex items-center justify-between">

                <button class="px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" @click="deleteModalShow = false;">
                    <span>Vazgeç</span>
                </button>
                <button class="px-4 py-2 rounded bg-red-200 text-red-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" @click="deleteCharacter(character.characterData.character_id)">
                    <span>Sil</span>
                    <MiniLoader :show="deleteLoad" radius="4" />
                </button>
            </div>
        </div>
    </Modal>

    <!-- Zar Modal -->
    <Modal :show="zarModalShow">
        <div class="p-6">
            <div class="relative mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Zar At
                </h2>
                <button class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect" @click="zarModalShow = false;">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>
            <div class="my-6 dark:text-gray-200">
                <Roll type="2"></Roll>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Textinput from '@/Components/TextInput.vue';
import TextAreainput from '@/Components/TextAreaInput.vue';
import TextCounter from '@/Components/TextCounter.vue';
import CharacterImageModal from '@/Includes/CharacterImageModal.vue';
import { computed, ref } from 'vue'
import { router, useForm, usePage } from '@inertiajs/vue3';
import MiniLoader from '@/Components/MiniLoader.vue';
import NProgress from 'nprogress'
import Dropdown from '@/Components/Dropdown.vue';
import nprogress from 'nprogress';
import Modal from '@/Components/Modal.vue';
import Roll from '@/Components/Roll.vue';
import toast from '@/Stores/toast';

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

const page = usePage();
const checkUser = ref(page.props.auth.user && page.props.auth.user.id == props.character.user_id);
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
    // console.log(character.characterData);
}

// const skills = ref(JSON.parse(props.skills.skills));
const skills_data = ref(JSON.parse(props.skills.skills_data));
const skillLabels = ref(props.skillLabels);

const total = computed(() => {
    return skills_data.value.reduce((acc, num) => acc + num, 0);
});
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

// AutoSaves
const autoSaveInfo = setInterval(() => {
    toast.add({
            type: 'warning', message: "Kardeş bayadır kaydete basmadın!"
        });
}, 290000);

const autoSave = setInterval(() => {
    updateCharacter();
}, 600000);


const openMore = ref(false);

const zarModalShow = ref(false);
const deleteModalShow = ref(false);
const deleteForm = useForm({
    id: ''
});
const deleteLoad = ref(false);
const deleteSuccess = ref(false);
function deleteCharacter(id) {
    nprogress.start();
    deleteLoad.value = true;

    deleteForm.id = id;

    deleteForm.post('/character-delete', {
        preserveScroll: true,
        onSuccess: (success) => {
            // console.log(success);
            deleteModalShow.value = false;
            setTimeout(() => {
                router.visit("/dashboard");
            }, 100);
        },
        onError: (error) => {
            // console.log(error);
            let keys = Object.keys(error)
            for (let index = 0; index < keys.length; index++) {
                errors.value.push(error[keys[index]]);
            }
        },
        onFinish: () => {
            deleteLoad.value = false;
            nprogress.done();
        }
    })
}
function getLength(data) {
    if (data == null) {
        return 0;
    }
    return data.length;
}

// Kopyalama
const copied = ref(false);

const copyUrl = async () => {
    try {
        const currentUrl = window.location.href;
        await navigator.clipboard.writeText(currentUrl);
        copied.value = true;
        toast.add({
            type: 'success', message: "Panoya Kopyalandı!"
        });
        setTimeout(() => {
            copied.value = false;
        }, 2000);
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
};
</script>

<style scoped>
label {
    @apply text-gray-700 dark:text-gray-300;
}
</style>