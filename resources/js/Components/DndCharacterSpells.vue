<template>
    <div class="p-6 bg-white rounded-lg dark:bg-gray-800 col-span-full">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-purple-100 rounded-lg dark:bg-purple-900/30">
                    <i class="text-xl text-purple-600 fa-solid fa-magic dark:text-purple-400"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Spellbook</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ spells.length }} spell{{ spells.length !== 1 ? 's' : '' }} known
                    </p>
                </div>
            </div>
        </div>

        <!-- Spells by Level -->
        <div v-if="spells.length > 0" class="space-y-6">
            <div v-for="(levelSpells, level) in groupedSpells" :key="level" class="space-y-3">
                <!-- Level Header -->
                <div class="flex items-center gap-3 pb-2 border-b border-purple-200 dark:border-purple-700">
                    <div class="flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-purple-600 rounded-full">
                        {{ level === '0' ? 'C' : level }}
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ level === '0' ? 'Cantrips' : `Level ${level} Spells` }}
                    </h4>
                    <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full dark:text-purple-300 dark:bg-purple-900/50">
                        {{ levelSpells.length }} spell{{ levelSpells.length !== 1 ? 's' : '' }}
                    </span>
                </div>

                <!-- Spell Cards Grid -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="spell in levelSpells"
                        :key="spell.id"
                        @click="showDetails(spell)"
                        class="p-4 transition-all duration-200 bg-white border border-gray-200 rounded-lg shadow-sm hover:cursor-pointer dark:bg-gray-700 dark:border-gray-600 hover:shadow-md hover:border-purple-300 dark:hover:border-purple-500 group"
                    >
                        <!-- Spell Header -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900 transition-colors dark:text-gray-100 group-hover:text-purple-600 dark:group-hover:text-purple-400">
                                    {{ spell.name }}
                                </h5>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ getSchoolEmoji(spell.school) }} {{ spell.school }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 ml-2">
                                <button
                                    @click="showDetails(spell)"
                                    class="flex items-center justify-center w-8 h-8 text-blue-600 transition-all duration-200 rounded-full  md:hidden hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/30"
                                    title="View Details"
                                >
                                    <i class="text-sm fa-solid fa-info"></i>
                                </button>
                                <button
                                    v-if="checkUser"
                                    @click="removeSpell(spell.id)"
                                    class="flex items-center justify-center w-8 h-8 text-red-600 transition-all duration-200 rounded-full hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/30"
                                    title="Remove Spell"
                                >
                                    <i class="text-sm fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Spell Quick Info -->
                        <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <i class="text-purple-500 fa-solid fa-clock"></i>
                                <span>{{ spell.casting_time }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="text-purple-500 fa-solid fa-crosshairs"></i>
                                <span>{{ spell.range }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="text-purple-500 fa-solid fa-hourglass"></i>
                                <span>{{ spell.duration }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="text-purple-500 fa-solid fa-hand"></i>
                                <span>{{ spell.components }}</span>
                            </div>
                        </div>

                        <!-- Spell Properties -->
                        <div v-if="spell.concentration || spell.ritual" class="flex gap-2 mt-3">
                            <span
                                v-if="spell.concentration"
                                class="px-2 py-1 text-xs font-medium text-orange-700 bg-orange-100 rounded-full dark:text-orange-300 dark:bg-orange-900/50"
                            >
                                <i class="mr-1 fa-solid fa-brain"></i>Concentration
                            </span>
                            <span
                                v-if="spell.ritual"
                                class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:text-green-300 dark:bg-green-900/50"
                            >
                                <i class="mr-1 fa-solid fa-circle"></i>Ritual
                            </span>
                        </div>

                        <!-- Spell Description Preview -->
                        <div class="mt-3">
                            <a class="text-sm text-red-700 dark:text-red-300 hover:underline line-clamp-2"
                             v-if="spell.description.includes('http')" :href="spell.description" target="_blank">
                                Details<i class="ml-1 fa-solid fa-arrow-up-right-from-square"></i> 
                            </a>
                            <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2"
                             v-else>
                                {{ spell.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="py-12 text-center">
            <div class="p-4 mx-auto mb-4 bg-purple-100 rounded-full w-fit dark:bg-purple-900/30">
                <i class="text-3xl text-purple-600 fa-solid fa-magic dark:text-purple-400"></i>
            </div>
            <h4 class="mb-2 text-lg font-semibold text-gray-900 dark:text-gray-100">No Spells Known</h4>
            <p class="text-gray-600 dark:text-gray-400">Your character hasn't learned any spells yet.</p>
        </div>

        <!-- Enhanced Details Modal -->
        <Modal :show="detailsModalShow" @close="detailsModalShow = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 rounded-lg dark:bg-purple-900/30">
                            <i class="text-lg text-purple-600 fa-solid fa-magic dark:text-purple-400"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                {{ selectedSpell.name }}
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ getSchoolEmoji(selectedSpell.school) }} {{ selectedSpell.school }} • 
                                {{ selectedSpell.level == 0 ? 'Cantrip' : `Level ${selectedSpell.level}` }}
                            </p>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="flex items-center justify-center w-10 h-10 text-gray-400 transition-all duration-200 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600"
                        @click="detailsModalShow = false"
                    >
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                <div class="space-y-6 overflow-y-auto max-h-[calc(70vh-120px)]">
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 md:grid-cols-4">
                        <div class="text-center">
                            <div class="text-xs font-medium text-gray-600 dark:text-gray-400">Casting Time</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ selectedSpell.casting_time }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs font-medium text-gray-600 dark:text-gray-400">Range</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ selectedSpell.range }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs font-medium text-gray-600 dark:text-gray-400">Duration</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ selectedSpell.duration }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs font-medium text-gray-600 dark:text-gray-400">Components</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ selectedSpell.components }}</div>
                        </div>
                    </div>

                    <!-- Properties -->
                    <div v-if="selectedSpell.concentration || selectedSpell.ritual" class="flex gap-3">
                        <span
                            v-if="selectedSpell.concentration"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-orange-700 bg-orange-100 rounded-lg dark:text-orange-300 dark:bg-orange-900/50"
                        >
                            <i class="fa-solid fa-brain"></i>
                            Requires Concentration
                        </span>
                        <span
                            v-if="selectedSpell.ritual"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-green-700 bg-green-100 rounded-lg dark:text-green-300 dark:bg-green-900/50"
                        >
                            <i class="fa-solid fa-circle"></i>
                            Ritual
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Description</h3>
                            <a class="text-sm leading-relaxed text-red-600 dark:text-red-400" v-if="selectedSpell.description.includes('http')" :href="selectedSpell.description" target="_blank">Details <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                            <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400" v-else>{{ selectedSpell.description }}</p>
                        </div>

                        <div v-if="selectedSpell.higher_levels" class="pt-3 border-t border-gray-200 dark:border-gray-600">
                            <h3 class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">At Higher Levels</h3>
                            <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">{{ selectedSpell.higher_levels }}</p>
                        </div>
                    </div>

                    <!-- Classes -->
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-600">
                        <h3 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Available to Classes</h3>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="classId in JSON.parse(selectedSpell.classes)"
                                :key="classId"
                                class="px-3 py-1 text-sm font-medium text-purple-700 bg-purple-100 rounded-full dark:text-purple-300 dark:bg-purple-900/50"
                            >
                                {{ getClassName(classId) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import { ref, defineEmits, computed } from 'vue';
import axios from 'axios';
import toast from '@/Stores/toast';
import Modal from './Modal.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    spells: Array,
    characterId: Number,
    checkUser: Boolean
});

const page = usePage();
const emit = defineEmits(['spellRemoved']);

const classes = ref(page.props.classes);
const detailsModalShow = ref(false);
const selectedSpell = ref({});

// Helper function to get school emoji
const getSchoolEmoji = (school) => {
    const schoolEmojis = {
        'Abjuration': '🛡️',
        'Conjuration': '🌀',
        'Divination': '👁️',
        'Enchantment': '💫',
        'Evocation': '⚡',
        'Illusion': '🎭',
        'Necromancy': '💀',
        'Transmutation': '🔄'
    };
    return schoolEmojis[school] || '✨';
};

// Group spells by level and sort them
const groupedSpells = computed(() => {
    if (!props.spells) return {};
    
    const sorted = [...props.spells].sort((a, b) => {
        // First sort by level
        if (a.level !== b.level) {
            return a.level - b.level;
        }
        // Then sort by name
        return a.name.localeCompare(b.name);
    });
    
    const grouped = {};
    sorted.forEach(spell => {
        const level = spell.level.toString();
        if (!grouped[level]) {
            grouped[level] = [];
        }
        grouped[level].push(spell);
    });
    
    return grouped;
});

// Computed property for sorted spells (for backward compatibility)
const spells = computed(() => {
    return props.spells
        ? [...props.spells].sort((a, b) => a.level - b.level || a.name.localeCompare(b.name))
        : [];
});

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
    return classes.value.find(classItem => classItem.id == classId)?.name || 'Unknown';
}
</script>

<style scoped>
/* Line clamp utility for description preview */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Enhanced hover animations */
.group:hover .group-hover\:text-purple-600 {
    color: rgb(147 51 234);
}

.dark .group:hover .dark\:group-hover\:text-purple-400 {
    color: rgb(196 181 253);
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(147, 51, 234, 0.5);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(147, 51, 234, 0.7);
}
</style>