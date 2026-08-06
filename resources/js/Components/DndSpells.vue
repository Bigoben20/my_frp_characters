<template>
    <div class="p-6 bg-white rounded-lg dark:bg-gray-800 col-span-full">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-purple-100 rounded-lg dark:bg-purple-900/30">
                    <i class="text-xl text-purple-600 fa-solid fa-magic dark:text-purple-400"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Spells Database</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Search and manage magical spells</p>
                </div>
            </div>
            <button 
                @click="collapseOpen = !collapseOpen"
                class="flex items-center gap-2 px-4 py-2 text-white transition-all duration-200 bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-800"
            >
                <i class="fa-solid" :class="collapseOpen ? 'fa-minus' : 'fa-plus'"></i>
                <span>{{ collapseOpen ? 'Hide Form' : 'Add Spell' }}</span>
            </button>
        </div>

        <!-- Enhanced Search Section -->
        <div class="mb-6">
            <div class="relative">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search spells by name, school, or description..."
                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    @input="searchSpells"
                />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="text-gray-400 fa-solid fa-search"></i>
                </div>
                
                <!-- Search Results Dropdown -->
                <div v-if="searchQuery && filteredSpells.length" class="absolute z-10 w-full mt-1 overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-xl dark:bg-gray-800 dark:border-gray-600 max-h-80">
                    <div class="p-2">
                        <div class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400">
                            Found {{ filteredSpells.length }} spell{{ filteredSpells.length !== 1 ? 's' : '' }}
                        </div>
                        <div 
                            v-for="spell in filteredSpells" 
                            :key="spell.id" 
                            @click="selectSpell(spell)" 
                            class="flex items-center justify-between p-3 transition-all duration-150 border border-transparent rounded-lg cursor-pointer hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-200 dark:hover:border-purple-700"
                        >
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ spell.name }}</span>
                                    <span class="px-2 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-full dark:text-purple-300 dark:bg-purple-900/50">
                                        {{ spell.level == 0 ? 'Cantrip' : `Level ${spell.level}` }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3 mt-1 text-xs text-gray-600 dark:text-gray-400">
                                    <span>{{ getSchoolEmoji(spell.school) }} {{ spell.school }}</span>
                                    <span>{{ spell.casting_time }}</span>
                                    <span>{{ spell.range }}</span>
                                </div>
                            </div>
                            <i class="text-purple-400 fa-solid fa-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modern Creation Form -->
        <div v-if="collapseOpen" class="p-6 border border-purple-200 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl dark:border-purple-700">
            <form @submit.prevent="addSpell" class="space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="mr-2 text-purple-500 fa-solid fa-magic"></i>Spell Name
                        </label>
                        <input
                            v-model="newSpell.name"
                            type="text"
                            placeholder="Enter spell name..."
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        />
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="mr-2 text-purple-500 fa-solid fa-layer-group"></i>Level
                        </label>
                        <select
                            v-model="newSpell.level"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                            <option value="0">Cantrip (0)</option>
                            <option v-for="level in 9" :key="level" :value="level">Level {{ level }}</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="mr-2 text-purple-500 fa-solid fa-graduation-cap"></i>School
                        </label>
                        <select
                            v-model="newSpell.school"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                            <option value="">Select School</option>
                            <option value="Abjuration">🛡️ Abjuration</option>
                            <option value="Conjuration">🌀 Conjuration</option>
                            <option value="Divination">👁️ Divination</option>
                            <option value="Enchantment">💫 Enchantment</option>
                            <option value="Evocation">⚡ Evocation</option>
                            <option value="Illusion">🎭 Illusion</option>
                            <option value="Necromancy">💀 Necromancy</option>
                            <option value="Transmutation">🔄 Transmutation</option>
                        </select>
                    </div>
                </div>

                <!-- Spell Details -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="mr-2 text-purple-500 fa-solid fa-clock"></i>Casting Time
                        </label>
                        <input
                            v-model="newSpell.casting_time"
                            type="text"
                            placeholder="e.g., 1 action"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        />
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="mr-2 text-purple-500 fa-solid fa-crosshairs"></i>Range
                        </label>
                        <input
                            v-model="newSpell.range"
                            type="text"
                            placeholder="e.g., 60 feet"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        />
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="mr-2 text-purple-500 fa-solid fa-hourglass"></i>Duration
                        </label>
                        <input
                            v-model="newSpell.duration"
                            type="text"
                            placeholder="e.g., Instantaneous"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        />
                    </div>
                </div>

                <!-- Components -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="mr-2 text-purple-500 fa-solid fa-hand"></i>Components
                    </label>
                    <input
                        v-model="newSpell.components"
                        type="text"
                        placeholder="e.g., V, S, M (a pinch of sulfur)"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    />
                </div>

                <!-- Description -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="mr-2 text-purple-500 fa-solid fa-file-text"></i>Description
                        </label>
                        <textarea
                            v-model="newSpell.description"
                            placeholder="Describe the spell's effects..."
                            required
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        ></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="mr-2 text-purple-500 fa-solid fa-arrow-up"></i>At Higher Levels
                        </label>
                        <textarea
                            v-model="newSpell.higher_levels"
                            placeholder="When cast using a spell slot of 2nd level or higher..."
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        ></textarea>
                    </div>
                </div>

                <!-- Special Properties -->
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        <input
                            type="checkbox"
                            v-model="newSpell.concentration"
                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 focus:ring-2"
                        />
                        <i class="text-purple-500 fa-solid fa-brain"></i>
                        <span>Requires Concentration</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        <input
                            type="checkbox"
                            v-model="newSpell.ritual"
                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 focus:ring-2"
                        />
                        <i class="text-purple-500 fa-solid fa-circle"></i>
                        <span>Ritual</span>
                    </label>
                </div>

                <!-- Classes -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="mr-2 text-purple-500 fa-solid fa-users"></i>Available to Classes
                    </label>
                    <div class="grid grid-cols-2 gap-3 p-4 bg-white border border-gray-200 rounded-lg dark:bg-gray-800/50 dark:border-gray-700 md:grid-cols-4">
                        <label
                            v-for="dndClass in classes"
                            :key="dndClass.id"
                            class="flex items-center gap-2 text-sm font-medium text-gray-700 transition-colors cursor-pointer dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400"
                        >
                            <input
                                type="checkbox"
                                v-model="selectedClasses"
                                :value="dndClass.id"
                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 focus:ring-2"
                            />
                            <span>{{ dndClass.name }}</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button
                        type="submit"
                        class="flex items-center gap-2 px-6 py-3 font-medium text-white transition-all duration-200 bg-purple-600 rounded-lg hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-800"
                    >
                        <i class="fa-solid fa-plus"></i>
                        <span>Create Spell</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
  
<script setup>
import { ref, defineEmits, onMounted, watch } from 'vue';
import axios from 'axios';
import toast from '@/Stores/toast';
import { usePage } from '@inertiajs/vue3';

const emit = defineEmits(['spellSelected']);
const page = usePage();

const classes = ref(page.props.classes);
const spells = ref([]);
const searchQuery = ref('');
const filteredSpells = ref([]);
const collapseOpen = ref(false);

const newSpell = ref({
  name: '',
  level: '',
  school: '',
  casting_time: '',
  range: '',
  duration: '',
  components: '',
  concentration: false,
  ritual: false,
  classes: '',
  description: '',
  higher_levels: '',
  img_url: ''
});

const selectedClasses = ref([]);

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

watch(selectedClasses, () => {
  newSpell.value.classes = JSON.stringify(selectedClasses.value);
});

const fetchSpells = async () => {
  try {
    const response = await axios.get('/dnd/spells');
    spells.value = response.data.data || []; // Paginated data içerisinden actual data array'ini al
    filteredSpells.value = spells.value;
  } catch (error) {
    console.error('Fetch spells error:', error);
    toast.add({ type: 'error', message: 'Failed to fetch spells' });
  }
};

const addSpell = async () => {
  try {
    await axios.post('/dnd/spells', newSpell.value);
    toast.add({ type: 'success', message: 'Spell added successfully' });
    
    // Reset form
    newSpell.value = {
      name: '',
      level: '',
      school: '',
      casting_time: '',
      range: '',
      duration: '',
      components: '',
      concentration: false,
      ritual: false,
      classes: '',
      description: '',
      higher_levels: '',
      img_url: ''
    };
    selectedClasses.value = [];
    collapseOpen.value = false;
    
    fetchSpells();
  } catch (error) {
    toast.add({ type: 'error', message: 'Failed to add spell' });
  }
};

const searchSpells = () => {
  if (!Array.isArray(spells.value)) {
    console.warn('Spells is not an array:', spells.value);
    filteredSpells.value = [];
    return;
  }
  
  filteredSpells.value = spells.value.filter(spell =>
    spell.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    spell.school.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
};

const selectSpell = (spell) => {
  searchQuery.value = '';
  filteredSpells.value = [];
  emit('spellSelected', spell);
};

onMounted(() => {
  fetchSpells();
});
</script>

<style scoped>
/* Modern animations and transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Custom scrollbar for search results */
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