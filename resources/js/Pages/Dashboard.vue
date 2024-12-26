<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Dashboard</h2>
        </template>
        <div class="pt-12 space-y-6">
            <div class="-mb-4">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex flex-col gap-2">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Filters
                        </span>
                        <div class="flex gap-2">
                            <button v-for="(filter,index) in filters" :key="index" class="px-4 py-2.5 leading-none text-indigo-700 rounded-full hoverEffect" :class=" system == filter.toLowerCase()? 'bg-indigo-200':'bg-stone-100'" @click="system = filter.toLowerCase()">
                                {{ filter }}
                            </button>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect" @click="createModalShow = true">
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- My Fate Characters -->
            <div v-show="system == 'all' || system == 'fate'" class="">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="p-4 overflow-hidden bg-white shadow-sm sm:p-6 dark:bg-gray-800 sm:rounded-lg">
                        <div class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">My Fate Characters <span class="text-blue-600 dark:text-blue-400">({{ characters.total }})</span></div>
                        <div class="w-full">
                            <table class="w-full text-left table-fixed">
                                <thead class="dark:text-gray-300">
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="px-3 py-1.5 rounded-l w-10">ID</th>
                                        <th class="px-3 py-1.5">Name</th>
                                        <th class="px-3 py-1.5 rounded-r">High Concept</th>
                                        <!-- <th class="px-3 py-1.5 rounded-r">
                                            <span>Actions</span>
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody class="dark:text-gray-100">
                                    <tr v-for="character in characters.data" :key="character.id" @click="goToChar(character.id,'fate')" class="hover:cursor-pointer hover:bg-gray-100/50 dark:hover:bg-gray-700/20">
                                        <td class="px-3 py-1.5">{{ character.id }}</td>
                                        <td class="px-3 py-1.5 whitespace-nowrap overflow-hidden text-ellipsis">{{ character.name }}</td>
                                        <td class="px-3 py-1.5">
                                            <div class="overflow-hidden text-ellipsis whitespace-nowrap">
                                                {{ character.high_concept }}
                                            </div>
                                        </td>
                                        <!-- <td class="px-3 py-1.5 w-[168px]">
                                            <div class="flex items-center gap-2 w-fit">
                                                <Link :href="route('character.details',[id=character.id])" type="button" class="px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect">
                                                    Detaylar
                                                </Link>
                                                <button type="button" class="px-4 py-2 rounded bg-rose-200 text-rose-700 hoverEffect" @click="selectedCharacter = character; deleteModalShow = true;">
                                                    Sil
                                                </button>
                                            </div>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <Pagination :links="allCharacters.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- My DND Character -->
            <div v-show="system == 'all' || system == 'd&d'" class="">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="p-4 overflow-hidden bg-white shadow-sm sm:p-6 dark:bg-gray-800 sm:rounded-lg">
                        <div class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">My D&D Characters <span class="text-blue-600 dark:text-blue-400">({{ characters.total }})</span></div>
                        
                        <div class="w-full">
                            <table class="w-full text-left table-fixed">
                                <thead class="dark:text-gray-300">
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="px-3 py-1.5 rounded-l w-10">ID</th>
                                        <th class="px-3 py-1.5">Name</th>
                                        <th class="px-3 py-1.5">Class</th>
                                    </tr>
                                </thead>
                                <tbody class="dark:text-gray-100">
                                    <tr v-for="character in dndCharacters.data" :key="character.id" @click="goToChar(character.id,'d&d')" class="hover:cursor-pointer hover:bg-gray-100/50 dark:hover:bg-gray-700/20">
                                        <td class="px-3 py-1.5">{{ character.id }}</td>
                                        <td class="px-3 py-1.5 whitespace-nowrap overflow-hidden text-ellipsis">{{ character.name }}</td>
                                        <td class="px-3 py-1.5">
                                            {{ character.class?? 'Unknown' }}
                                        </td>
                                        <!-- <td class="px-3 py-1.5 w-[168px]">
                                            <div class="flex items-center gap-2 w-fit">
                                                <Link :href="route('character.details',[id=character.id])" type="button" class="px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect">
                                                    Detaylar
                                                </Link>
                                                <button type="button" class="px-4 py-2 rounded bg-rose-200 text-rose-700 hoverEffect" @click="selectedCharacter = character; deleteModalShow = true;">
                                                    Sil
                                                </button>
                                            </div>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <Pagination :links="allCharacters.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-12 pb-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-4 bg-white shadow-sm sm:p-6 dark:bg-gray-800 sm:rounded-lg">
                    <Roll></Roll>
                </div>
            </div>
        </div>

        <!-- Other Characters -->
        <div class="pb-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-4 overflow-hidden bg-white shadow-sm sm:p-6 dark:bg-gray-800 sm:rounded-lg">
                    <div class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Other Characters <span class="text-blue-600 dark:text-blue-400">({{ allCharacters.total }})</span></div>
                    <div class="w-full">
                        <table class="w-full text-left table-fixed">
                            <thead class="dark:text-gray-300">
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-3 py-1.5 rounded-l w-10">ID</th>
                                    <th class="px-3 py-1.5">User</th>
                                    <th class="px-3 py-1.5">Name</th>
                                    <th class="px-3 py-1.5 rounded-r">High Concept</th>
                                </tr>
                            </thead>
                            <tbody class="dark:text-gray-100">
                                <tr v-for="character in allCharacters.data" :key="character.id" @click="goToChar(character.id)" class="hover:cursor-pointer hover:bg-gray-100/50 dark:hover:bg-gray-700/20">
                                    <td class="px-3 py-1.5">{{ character.id }}</td>
                                    <td class="px-3 py-1.5 whitespace-nowrap">{{ character.user.name }}</td>
                                    <td class="px-3 py-1.5 whitespace-nowrap overflow-hidden text-ellipsis">{{ character.name }}</td>
                                    <td class="px-3 py-1.5">
                                        <div class="overflow-hidden text-ellipsis whitespace-nowrap">
                                            {{ character.high_concept }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <Pagination :links="allCharacters.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Create Modal -->
    <Modal :show="createModalShow">
        <div class="p-6">
            <div class="relative mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Create Character
                </h2>
                <button class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect" @click="resetCreate">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>

            <div v-if="errors.length > 0" class="flex w-full gap-1">
                <div v-for="(error, index) in errors" :key="index" class="px-3 py-1 text-red-500 border border-red-300 rounded bg-red-50 full">
                    {{ error }}
                </div>
            </div>
            
            <div class="flex flex-col">
                <label for="system" class="dark:text-gray-200">System</label>
                <SelectInput id="system" v-model="system">
                    <option value="all" disabled>Choose</option>
                    <option value="fate">Fate</option>
                    <option value="d&d">D&D</option>
                </SelectInput>
                
            </div>

            <form v-if="system == 'fate'" @submit.prevent="submitForm" class="grid justify-between grid-cols-1 mt-4 md:items-end">
                <div class="flex flex-col">
                    <label for="name" class="dark:text-gray-200">Name:</label>
                    <TextInput maxlength="100" id="name" v-model="form.name" />
                    <TextCounter maxlength="100" :value="form.name.length.toString()"/>
                </div>
                <div class="flex flex-col">
                    <label for="high_concept" class="dark:text-gray-200">High Concept:</label>
                    <TextAreainput maxlength="300" rows="2" id="high_concept" v-model="form.high_concept" />
                    <TextCounter maxlength="300" :value="form.high_concept.length.toString()"/>
                </div>
                <button class="px-4 py-2 rounded bg-indigo-200 text-indigo-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" type="submit" :disabled="submitLoad || successMessage">
                    <span>Create</span>
                    <MiniLoader :show="submitLoad" radius="4" />
                    <i class="text-green-500 fa-solid fa-check-circle" v-if="successMessage"></i>
                </button>
            </form>
            
            <form v-else-if="system == 'd&d'" @submit.prevent="submitDndForm" class="grid justify-between grid-cols-1 gap-5 mt-4 md:items-end">
                <div class="flex flex-col">
                    <label for="name" class="dark:text-gray-200">Name:</label>
                    <TextInput maxlength="100" id="name" v-model="formDnd.name" />
                    <TextCounter maxlength="100" :value="formDnd.name.length.toString()"/>
                </div>
                <button class="px-4 py-2 rounded bg-indigo-200 text-indigo-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" type="submit" :disabled="submitLoad || successMessage">
                    <span>Create</span>
                    <MiniLoader :show="submitLoad" radius="4" />
                    <i class="text-green-500 fa-solid fa-check-circle" v-if="successMessage"></i>
                </button>
            </form>
        </div>
    </Modal>

    <!-- Delete Modal -->
    <Modal :show="deleteModalShow">
        <div class="p-6">
            <div class="relative mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Karakteri Sil
                </h2>
                <button class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect" @click="selectedCharacter = null; deleteModalShow = false;">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>
            <div class="my-6 dark:text-gray-200">
                "{{ selectedCharacter.name }}" karakterini silmek istediğinize emin misiniz?
            </div>
            <div class="flex items-center justify-between">
                
                <button class="px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" @click="selectedCharacter = null; deleteModalShow = false;">
                    <span>Vazgeç</span>
                </button>
                <button class="px-4 py-2 rounded bg-red-200 text-red-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" @click="deleteCharacter(selectedCharacter.id)">
                    <span>Sil</span>
                    <MiniLoader :show="deleteLoad" radius="4" />
                </button>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import toast from '@/Stores/toast';
import nprogress from 'nprogress';

import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextCounter from '@/Components/TextCounter.vue';
import MiniLoader from '@/Components/MiniLoader.vue';
import TextAreainput from '@/Components/TextAreaInput.vue';
import Roll from '@/Components/Roll.vue'
import Pagination from '@/Components/Pagination.vue'


const props = defineProps({
    characters: {
        type: Object,
    },
    dndCharacters: {
        type: Object,
    },
    allCharacters: {
        type: Object,
    },
})
// console.log(props.characters);
const page = usePage();

const system = ref('all');
const filters = ref([
    "All","Fate","D&D"
])

const selectedCharacter = ref(null);
const createModalShow = ref(false);
const deleteModalShow = ref(false);
const successMessage = ref(false);
const errors = ref([]);
const submitLoad = ref(false);

const form = useForm({
    name: '',
    high_concept: '',
});
const formDnd = useForm({
    name: '',
});
const submitForm = async () => {
    nprogress.start();
    submitLoad.value = true;
    errors.value = [];
    form.post('/character-create', {
        preserveScroll: true,
        onSuccess: (success) => {
            // console.log(success);
            resetCreate();
        },
        onError: (error) => {
            // console.log(error);
            let keys = Object.keys(error)
            for (let index = 0; index < keys.length; index++) {
                errors.value.push(error[keys[index]]);
            }
        },
        onFinish: () => {
            submitLoad.value = false;
            nprogress.done();
        }
    })
};
const submitDndForm = async () => {
    nprogress.start();
    submitLoad.value = true;
    errors.value = [];
    formDnd.post('dnd/character-create', {
        preserveScroll: true,
        onSuccess: (success) => {
            // console.log(success);
            resetCreate();
        },
        onError: (error) => {
            // console.log(error);
            let keys = Object.keys(error)
            for (let index = 0; index < keys.length; index++) {
                errors.value.push(error[keys[index]]);
            }
        },
        onFinish: () => {
            submitLoad.value = false;
            nprogress.done();
        }
    })
};


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

function resetCreate() {
    form.reset();
    submitLoad.value = false;
    errors.value = [];
    successMessage.value = false;
    createModalShow.value = false;
}

function goToChar(id,system) {
    let url = "";
    switch (system) {
        case 'fate':
            url = "/character-detail/"+id
        break;
        case 'd&d':
            url = "/dnd/character-detail/"+id
        break;
        
        default:
            url = '/'
            break;
        }
        window.location.href= url;
}
</script>