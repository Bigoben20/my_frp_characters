<template>
    <div class="p-4 bg-white rounded-lg dark:bg-gray-800 col-span-full">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Character Spells</h3>
        <div class="overflow-x-auto whitespace-nowrap">
            <table class="w-full mt-4 text-sm text-left table-auto">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-2 py-1">Spell Name</th>
                        <th class="px-2 py-1">Level</th>
                        <th class="px-2 py-1">School</th>
                        <th class="px-2 py-1">Casting Time</th>
                        <th class="px-2 py-1">Range</th>
                        <th class="px-2 py-1">Duration</th>
                        <th class="px-2 py-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="spell in spells" :key="spell.id">
                        <td class="px-2 py-1">{{ spell.name }}</td>
                        <td class="px-2 py-1">{{ spell.level }}</td>
                        <td class="px-2 py-1">{{ spell.school }}</td>
                        <td class="px-2 py-1">{{ spell.casting_time }}</td>
                        <td class="px-2 py-1">{{ spell.range }}</td>
                        <td class="px-2 py-1">{{ spell.duration }}</td>
                        <td class="px-2 py-1">
                            <div class="flex items-center gap-2">
                                <button type="button" @click="showDetails(spell)" class="w-6 h-6 text-blue-600 rounded-full hover:bg-blue-100">
                                    <i class="text-xs fa-solid fa-info"></i>
                                </button>
                                <button type="button" @click="removeSpell(spell.id)" class="w-6 h-6 text-red-600 rounded-full hover:bg-red-100">
                                    <i class="text-xs fa-solid fa-x"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Modal :show="detailsModalShow" @close="detailsModalShow = false">
            <div class="p-6">
                <div class="relative mb-2">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Spell Details
                    </h2>
                    <button type="button" class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect"
                        @click="detailsModalShow = false;">
                        <i class="text-sm fa-solid fa-x"></i>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-4 py-6 overflow-y-auto max-h-[calc(60vh-24px)] dark:text-gray-200">
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Name:</strong>
                        <span>{{ selectedSpell.name }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Level:</strong>
                        <span>{{ selectedSpell.level }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">School:</strong>
                        <span>{{ selectedSpell.school }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Casting Time:</strong>
                        <span>{{ selectedSpell.casting_time }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Range:</strong>
                        <span>{{ selectedSpell.range }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Duration:</strong>
                        <span>{{ selectedSpell.duration }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Components:</strong>
                        <span>{{ selectedSpell.components }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Concentration:</strong>
                        <span>{{ selectedSpell.concentration ? 'Yes' : 'No' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Ritual:</strong>
                        <span>{{ selectedSpell.ritual ? 'Yes' : 'No' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Classes:</strong>
                        <span class="text-xs" v-for="classId in JSON.parse(selectedSpell.classes)" :key="classId">{{ getClassName(classId) }}</span>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Description:</strong>
                        <span>{{ selectedSpell.description }}</span>
                    </div>
                    <div class="flex flex-col col-span-2" v-if="selectedSpell.higher_levels">
                        <strong class="text-sm text-gray-700 dark:text-gray-300">Higher Levels:</strong>
                        <span>{{ selectedSpell.higher_levels }}</span>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';
import axios from 'axios';
import toast from '@/Stores/toast';
import Modal from './Modal.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    spells: Array,
    characterId: Number
});
const page = usePage();
const emit = defineEmits(['spellRemoved']);

const classes = ref(page.props.classes);
const detailsModalShow = ref(false);
const selectedSpell = ref({});

const showDetails = (spell) => {
    selectedSpell.value = spell;
    detailsModalShow.value = true;
};

const removeSpell = async (spellId) => {
    try {
        await axios.post('/dnd/character-spell-delete', {
            character_id: props.characterId,
            spell_id: spellId
        });
        toast.add({ type: 'success', message: 'Spell removed successfully' });
        emit('spellRemoved', spellId);
    } catch (error) {
        toast.add({ type: 'error', message: 'Failed to remove spell' });
    }
};

function getClassName(classId) {
    return classes.value.find(classItem => classItem.id == classId).name;
}
</script>

<style scoped>
/* Add your styles here */
</style>