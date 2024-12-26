<template>
    <form @submit.prevent="updateCharacter" class="grid grid-cols-1 gap-4 px-2 pt-6 pb-32 md:px-6 md:grid-cols-2 dark:text-gray-100">
        <div class="flex flex-col gap-1 col-span-full">
            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                Tabs
            </span>
            <div class="flex gap-2 overflow-x-auto">
                <template v-for="tab in tabs" :key="tab.id">
                    <button type="button" @click="tabs.forEach(t => t.active = t.id == tab.id)" :class="tab.active ? 'bg-indigo-500 dark:bg-indigo-200 text-white dark:text-indigo-600' : 'bg-gray-200 text-gray-800' " class="px-4 py-1 rounded-full whitespace-nowrap">
                        {{ tab.name }}
                    </button>
                </template>
            </div>
        </div>
        <transition-group name="tab-fade">
            <div class="flex flex-col gap-8 col-span-full" v-show="tabs[0].active" :key="tabs[0].id">
                <!-- Character Name -->
                <div class="grid grid-cols-2 p-4 bg-white rounded-lg gap-y-1 gap-x-4 dark:bg-gray-800">
                    <div class="grid items-start w-full grid-cols-2 col-span-full">
                        <TextInput maxlength="255" :auth="checkUser" id="name" v-model="character.characterData.name" class="w-full col-span-full" />
                        <label for="name" class="ml-1">Name</label>
                        <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.name)" />
                    </div>
                    <div class="grid items-start w-full grid-cols-2">
                        <TextInput maxlength="100" :auth="checkUser" id="background" v-model="character.characterData.background" class="w-full col-span-full" />
                        <label for="background" class="ml-1">Background</label>
                        <TextCounter v-if="checkUser" maxlength="100" :value="getLength(character.characterData.background)" />
                    </div>
                    <div class="grid items-start w-full grid-cols-2">
                        <TextInput maxlength="100" :auth="checkUser" id="class" v-model="character.characterData.class" class="w-full col-span-full" />
                        <label for="class" class="ml-1">Class</label>
                        <TextCounter v-if="checkUser" maxlength="100" :value="getLength(character.characterData.class)" />
                    </div>
                    <div class="grid items-start w-full grid-cols-2">
                        <TextInput maxlength="100" :auth="checkUser" id="species" v-model="character.characterData.species" class="w-full col-span-full" />
                        <label for="species" class="ml-1">Species</label>
                        <TextCounter v-if="checkUser" maxlength="100" :value="getLength(character.characterData.species)" />
                    </div>
                    <div class="grid items-start w-full grid-cols-2">
                        <TextInput maxlength="100" :auth="checkUser" id="subclass" v-model="character.characterData.subclass" class="w-full col-span-full" />
                        <label for="subclass" class="ml-1">Subclass</label>
                        <TextCounter v-if="checkUser" maxlength="100" :value="getLength(character.characterData.subclass)" />
                    </div>
                </div>

                <!-- Level, Armor Class, HP, Hit Dice, Death Saves -->
                <div class="grid grid-cols-2 gap-4 md:grid-cols-6">
                    <!-- Level -->
                    <div class="flex flex-col justify-end p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="flex flex-col items-start w-full gap-2">
                            <label for="level" class="ml-1">Level</label>
                            <TextInput maxlength="3" type="tel" v-mask="'###'" :auth="checkUser" id="level" v-model="character.characterData.level" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="xp" class="ml-1">XP</label>
                            <TextInput maxlength="10" type="tel" v-mask="'##########'" :auth="checkUser" id="level" v-model="character.characterData.xp" class="w-full" />
                        </div>
                    </div>

                    <!-- Armor Class -->
                    <div class="flex flex-col justify-end gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="flex flex-col items-start w-full">
                            <label for="ac" class="ml-1">Armor Class</label>
                            <TextInput maxlength="10" :auth="checkUser" id="ac" v-model="character.characterData.ac" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="shield" class="ml-1">Shield</label>
                            <TextInput maxlength="3" :auth="checkUser" id="shield" v-model="character.characterData.shield" class="w-full" />
                        </div>
                    </div>

                    <!-- Hit Points -->
                    <div class="grid grid-cols-2 col-span-2 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="-mb-2 font-semibold tracking-wide text-center col-span-full">
                            <span>Hit Points</span>
                        </div>
                        <div class="flex flex-col items-start w-full col-span-full">
                            <label for="current_hp" class="ml-1">Current HP</label>
                            <TextInput maxlength="10" :auth="checkUser" id="current_hp" v-model="character.characterData.current_hp" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="max_hp" class="ml-1">Max HP</label>
                            <TextInput maxlength="10" :auth="checkUser" id="max_hp" v-model="character.characterData.max_hp" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="temp_hp" class="ml-1">Temp HP</label>
                            <TextInput maxlength="10" :auth="checkUser" id="temp_hp" v-model="character.characterData.temp_hp" class="w-full" />
                        </div>
                    </div>

                    <!-- Hit Dice -->
                    <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="-mb-2 font-semibold tracking-wide text-center col-span-full">
                            <span>Hit Dice</span>
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="spent_hit_dice" class="ml-1">Spent</label>
                            <TextInput maxlength="10" :auth="checkUser" id="spent_hit_dice" v-model="character.characterData.spent_hit_dice" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="max_hit_dice" class="ml-1">Max</label>
                            <TextInput maxlength="10" :auth="checkUser" id="max_hit_dice" v-model="character.characterData.max_hit_dice" class="w-full" />
                        </div>
                    </div>

                    <!-- Death Saves -->
                    <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="-mb-2 font-semibold tracking-wide text-center col-span-full">
                            <span>Death Saves</span>
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="success_death_save" class="ml-1">Success</label>
                            <TextInput type="tel" v-mask="'#'" maxlength="1" :auth="checkUser" id="success_death_save" v-model="character.characterData.success_death_save" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="fail_death_save" class="ml-1">Fail</label>
                            <TextInput type="tel" v-mask="'#'" maxlength="1" :auth="checkUser" id="fail_death_save" v-model="character.characterData.fail_death_save" class="w-full" />
                        </div>
                    </div>
                </div>

                <!-- Initiative, Speed, Size, Passive Perception -->
                 <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
                    <div class="flex flex-col items-start w-full p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="initiative" class="w-full ml-1 font-semibold tracking-wide text-center">Initiative</label>
                        <TextInput maxlength="5" :auth="checkUser" id="initiative" v-model="character.characterData.initiative" class="w-full" />
                    </div>
                    <div class="flex flex-col items-start w-full p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="speed" class="w-full ml-1 font-semibold tracking-wide text-center">Speed</label>
                        <TextInput maxlength="5" :auth="checkUser" id="speed" v-model="character.characterData.speed" class="w-full" />
                    </div>
                    <div class="flex flex-col items-start w-full p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="size" class="w-full ml-1 font-semibold tracking-wide text-center">Size</label>
                        <TextInput maxlength="10" :auth="checkUser" id="size" v-model="character.characterData.size" class="w-full capitalize" />
                    </div>
                    <div class="flex flex-col items-start w-full p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="passive_perception" class="w-full ml-1 font-semibold tracking-wide text-center">Passive Perception</label>
                        <TextInput maxlength="3" :auth="checkUser" id="passive_perception" v-model="character.characterData.passive_perception" class="w-full" />
                    </div>
                 </div>

                 <!-- Appearance, Backstory, Alignment, Languages -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                            <label for="appearance" class="w-full ml-1 font-semibold tracking-wide text-center">Appearance</label>
                            <TextAreaInput row="10" maxlength="1000" :auth="checkUser" id="appearance" v-model="character.characterData.appearance" class="w-full" />
                            <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.appearance)" />
                        </div>
                        <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                            <label for="backstory" class="w-full ml-1 font-semibold tracking-wide text-center">Backstory</label>
                            <TextAreaInput row="10" maxlength="1000" :auth="checkUser" id="backstory" v-model="character.characterData.backstory" class="w-full" />
                            <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.backstory)" />
                        </div>
                        <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                            <label for="alignment" class="w-full ml-1 font-semibold tracking-wide text-center">Alignment</label>
                            <TextInput maxlength="20" :auth="checkUser" id="alignment" v-model="character.characterData.alignment" class="w-full" />
                        </div>
                        <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                            <label for="languages" class="w-full ml-1 font-semibold tracking-wide text-center">Languages</label>
                            <TextAreaInput maxlength="255" :auth="checkUser" id="languages" v-model="character.characterData.languages" class="w-full" />
                        </div>
                    </div>
            </div>

            <!-- Abilities -->
            <div class="flex flex-col gap-8 col-span-full" v-show="tabs[1].active" :key="tabs[1].id">
            </div>
            
        </transition-group>

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
                        <TextAreaInput id="notes" :auth="checkUser" v-model="character.characterData.notes" class="w-full h-[calc(100%-124px)]" rows="15" />
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
        <div class="">
            <div class="relative px-6 pt-6 mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Karakteri Sil
                </h2>
                <button type="button" class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full top-6 right-6 dark:bg-gray-900 dark:text-white hoverEffect" @click="deleteModalShow = false;">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>
            <div class="px-6 my-6 dark:text-gray-200">
                "{{ character.characterData.name }}" karakterini silmek istediğinize emin misiniz?
            </div>
            <div class="flex items-center justify-between px-6 py-4 bg-gray-100 dark:bg-gray-800">
                <button type="button" class="px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" @click="deleteModalShow = false;">
                    <span>Vazgeç</span>
                </button>
                <button type="button" class="px-4 py-2 rounded bg-red-200 text-red-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" @click.once="deleteCharacter(character.characterData.id)">
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
                <button type="button" class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect" @click="zarModalShow = false;">
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
import MiniLoader from '@/Components/MiniLoader.vue';
import Modal from '@/Components/Modal.vue';
import Roll from '@/Components/Roll.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import TextCounter from '@/Components/TextCounter.vue';
import TextInput from '@/Components/TextInput.vue';
import toast from '@/Stores/toast';
import { router, useForm, usePage } from '@inertiajs/vue3';
import nProgress from 'nprogress';
import { computed, onMounted } from 'vue';
import { ref } from 'vue';

const props = defineProps({
    character: {
        type: Object,
    }
})
const page = usePage();
const abilities = ref([]);
const proficiencies = ref([]);
console.log(props.character);
onMounted(() => {
    abilities.value = JSON.parse(props.character.abilities.abilities);
    proficiencies.value = JSON.parse(props.character.abilities.proficiencies);
})

const checkUser = computed(() => {
    return page.props.auth.user && page.props.auth.user.id == props.character.user_id;
})

const saveLoading = ref(false);
const copied = ref(false);

const character = useForm({ characterData: props.character });
const updateCharacter = async () => {
    nProgress.start()
    saveLoading.value = true;
    // character.skills.skills_data = JSON.stringify(skills_data.value);
    character.post('/dnd/character-update', {
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
            nProgress.done()
        }
    });
}

const tabs = ref([
    { id: 0, name:"Character Info", active: true },
    { id: 1, name:"Abilities", active: false },
    { id: 2, name:"Feats", active: false },
    { id: 3, name:"Equipment", active: false },
    { id: 4, name:"Spells", active: false },
    { id: 5, name:"Notes", active: false },
    { id: 6, name:"Settings", active: false }
])
const openMore = ref(false);
const deleteModalShow = ref(false);
const zarModalShow = ref(false);
const deleteLoad = ref(false);
const zarLoad = ref(false);
const errors = ref([]);


function getLength(data) {
    if (data == null) {
        return "0";
    }
    return data.length.toString();
}
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

// Delete
const deleteForm = useForm({
    id: ''
});
function deleteCharacter(id) {
    nProgress.start();
    deleteLoad.value = true;

    deleteForm.id = id;

    deleteForm.post('/dnd/character-delete', {
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
            nProgress.done();
        }
    })
}
</script>

<style></style>