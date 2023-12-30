<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Your Characters</div>
                    <div class="mb-2">
                        <button type="button" class="px-4 py-2 rounded bg-sky-100 text-sky-700 hoverEffect" @click="createModalShow = true">
                            Create
                        </button>
                        <button type="button" class="px-4 py-2 ml-4 rounded bg-sky-100 text-sky-700 hoverEffect" @click="toast.add({type:'warning',message:'test'})">
                            + add toast
                        </button>

                    </div>
                    <div>
                        <table class="w-full text-left table-auto">
                            <thead class="dark:text-gray-300">
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-3 py-1.5 rounded-l">ID</th>
                                    <th class="px-3 py-1.5">Name</th>
                                    <th class="px-3 py-1.5">High Concept</th>
                                    <th class="px-3 py-1.5 rounded-r">
                                        <span>Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="dark:text-gray-100">
                                <tr v-for="character in characters" :key="character.id">
                                    <td class="px-3 py-1.5">{{ character.id }}</td>
                                    <td class="px-3 py-1.5">{{ character.name }}</td>
                                    <td class="px-3 py-1.5">{{ character.high_concept }}</td>
                                    <td class="px-3 py-1.5 w-[168px]">
                                        <div class="flex items-center gap-2 w-fit">
                                            <button type="button" class="px-4 py-2 rounded bg-sky-100 text-sky-700 hoverEffect">
                                                Details
                                            </button>
                                            <button type="button" class="px-4 py-2 rounded bg-rose-100 text-rose-700 hoverEffect" @click="deleteCharacter(character.id)">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="createModalShow">
        <div class="p-6">
            <div class="relative mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Create Character
                </h2>
                <button class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full hoverEffect" @click="resetCreate">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>

            <div v-if="errors.length > 0" class="flex w-full gap-1">
                <div v-for="(error, index) in errors" :key="index" class="px-3 py-1 text-red-500 border border-red-300 rounded bg-red-50 full">
                    {{ error }}
                </div>
            </div>
            <form @submit.prevent="submitForm" class="grid justify-between grid-cols-1 gap-5 mt-4 md:grid-cols-3 md:items-end">
                <div class="flex flex-col">
                    <label for="name">İsim:</label>
                    <TextInput id="name" v-model="form.name" />
                </div>
                <div class="flex flex-col">
                    <label for="high_concept">High Concept:</label>
                    <TextInput id="high_concept" v-model="form.high_concept" />
                </div>
                <button class="px-4 py-2 rounded bg-indigo-100 text-indigo-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" type="submit" :disabled="submitLoad || successMessage">
                    <span>Kaydet</span>
                    <MiniLoader :show="submitLoad" radius="4" />
                    <i class="text-green-500 fa-solid fa-check-circle" v-if="successMessage"></i>
                </button>
            </form>
        </div>
    </Modal>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import MiniLoader from '@/Components/MiniLoader.vue';
import toast from '@/Stores/toast';

defineProps({
    characters: {
        type: Object,
    },
})

const page = usePage();

const createModalShow = ref(false);
const successMessage = ref(false);
const errors = ref([]);
const submitLoad = ref(false);

const form = useForm({
    name: '',
    high_concept: '',
});
const submitForm = async () => {
    submitLoad.value = true;
    errors.value = [];
    form.post('/character-create', {
        preserveScroll: true,
        onSuccess: (success) => {
            // console.log(success);
            successMessage.value = true;
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
        }
    })
};


const deleteForm = useForm({
    id: ''
});
const deleteLoad = ref(false);
const deleteSuccess = ref(false);
function deleteCharacter(id) {
    deleteLoad.value = true;

    deleteForm.id = id;

    deleteForm.post('/character-delete', {
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
            deleteLoad.value = false;
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

</script>