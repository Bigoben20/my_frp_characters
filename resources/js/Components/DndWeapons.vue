<template>
  <div class="flex flex-col gap-6 p-6 bg-white rounded-lg dark:bg-gray-800">
    <!-- Search Section -->
    <div class="flex flex-col gap-4">
      <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
          <i class="fa-solid fa-sword mr-2 text-orange-600"></i>Weapons
        </h3>
      </div>
      
      <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <i class="fa-solid fa-search text-gray-400"></i>
        </div>
        <TextInput 
          v-model="searchQuery" 
          placeholder="Search weapons by name or damage type..." 
          @input="searchWeapons" 
          class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-200 rounded-lg focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:border-orange-400" />
        
        <!-- Search Results Dropdown -->
        <div v-if="searchQuery && filteredWeapons.length" 
             class="absolute z-20 w-full mt-1 bg-white border-2 border-gray-200 rounded-lg shadow-xl dark:bg-gray-700 dark:border-gray-600 max-h-64 overflow-y-auto">
          <div v-for="weapon in filteredWeapons.slice(0, 8)" :key="weapon.id" 
               @click="selectWeapon(weapon)" 
               class="flex items-center justify-between p-3 cursor-pointer hover:bg-orange-50 dark:hover:bg-gray-600 border-b border-gray-100 dark:border-gray-600 last:border-b-0">
            <div class="flex-1">
              <div class="font-medium text-gray-900 dark:text-gray-100">{{ weapon.name }}</div>
              <div class="text-sm text-orange-600 dark:text-orange-400">{{ weapon.damage_and_type }}</div>
              <div class="text-xs text-gray-500 dark:text-gray-400">{{ weapon.cost }} • {{ weapon.weight }}</div>
            </div>
            <i class="fa-solid fa-plus text-orange-600 dark:text-orange-400"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Create Weapon Section -->
    <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
      <button type="button" 
              @click="collapseOpen = !collapseOpen"
              class="flex items-center gap-2 text-lg font-semibold text-gray-900 hover:text-orange-600 dark:text-gray-100 dark:hover:text-orange-400 transition-colors">
        <i class="fa-solid fa-hammer"></i>
        Create Custom Weapon
        <i class="transition-all duration-200 ease-out fa-solid fa-chevron-down" :class="{'rotate-180': collapseOpen}"></i>
      </button>
      
      <div v-if="collapseOpen" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
        <form @submit.prevent="addWeapon" class="space-y-6">
          <!-- Basic Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Weapon Name</label>
              <TextInput v-model="newWeapon.name" placeholder="Enter weapon name..." required 
                        class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Damage & Type</label>
              <TextInput v-model="newWeapon.damage_and_type" placeholder="e.g., 1d8 slashing" required 
                        class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Weight</label>
              <TextInput v-model="newWeapon.weight" placeholder="e.g., 3 lb." 
                        class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cost</label>
              <TextInput v-model="newWeapon.cost" placeholder="e.g., 15 gp" 
                        class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" />
            </div>
          </div>
          
          <!-- Notes -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
            <TextAreaInput rows="3" maxlength="255" v-model="newWeapon.notes" 
                          placeholder="Any special notes about this weapon..." 
                          class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" />
          </div>
          
          <!-- Properties -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Properties</label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
              <div v-for="property in nonMasteryProperties" :key="property.id" class="flex items-center">
                <input type="checkbox" v-model="newWeapon.properties" :value="property.id" 
                       :id="'prop-' + property.id"
                       class="mr-2 rounded border-gray-300 text-orange-600 focus:ring-orange-500" />
                <label :for="'prop-' + property.id" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                  {{ property.name }}
                </label>
              </div>
            </div>
          </div>
          
          <!-- Mastery -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Mastery (Select One)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
              <div v-for="property in masteryProperties" :key="property.id" class="flex items-center">
                <input type="radio" v-model="newWeapon.mastery" :value="property.id" 
                       :id="'mastery-' + property.id"
                       class="mr-2 border-gray-300 text-purple-600 focus:ring-purple-500" />
                <label :for="'mastery-' + property.id" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                  {{ property.name }}
                </label>
              </div>
            </div>
          </div>
          
          <!-- Submit Button -->
          <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-3 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-200 dark:focus:ring-orange-800 transition-colors">
              <i class="fa-solid fa-plus mr-2"></i>Create Weapon
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits, onMounted, computed } from 'vue';
import axios from 'axios';
import toast from '@/Stores/toast';
import TextInput from '@/Components/TextInput.vue';
import TextAreaInput from './TextAreaInput.vue';

const emit = defineEmits(['weaponSelected']);

const newWeapon = ref({
  name: '',
  damage_and_type: '',
  notes: '',
  weight: '',
  cost: '',
  properties: [],
  mastery: null
});

const weapons = ref([]);
const properties = ref([]);
const searchQuery = ref('');
const filteredWeapons = ref([]);
const collapseOpen = ref(false);

const fetchWeapons = async () => {
  try {
    const response = await axios.get('/dnd/weapons');
    weapons.value = response.data;
    filteredWeapons.value = weapons.value;
  } catch (error) {
    toast.add({ type: 'error', message: 'Failed to fetch weapons' });
  }
};

const fetchProperties = async () => {
  try {
    const response = await axios.get('/dnd/weapon-properties');
    properties.value = response.data;
  } catch (error) {
    toast.add({ type: 'error', message: 'Failed to fetch properties' });
  }
};

const addWeapon = async () => {
  try {
    let data = { ...newWeapon.value };
    data.properties = JSON.stringify(data.properties);
    await axios.post('/dnd/weapons', data);
    toast.add({ type: 'success', message: 'Weapon added successfully' });
    fetchWeapons();
  } catch (error) {
    toast.add({ type: 'error', message: 'Failed to add weapon' });
  }
};

const deleteWeapon = async (id) => {
  try {
    await axios.delete(`/dnd/weapons/${id}`);
    toast.add({ type: 'success', message: 'Weapon deleted successfully' });
    fetchWeapons();
  } catch (error) {
    toast.add({ type: 'error', message: 'Failed to delete weapon' });
  }
};

const nonMasteryProperties = computed(() => properties.value.filter(property => !property.mastery));
const masteryProperties = computed(() => properties.value.filter(property => property.mastery));

const searchWeapons = () => {
  filteredWeapons.value = weapons.value.filter(weapon =>
    weapon.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
};

const selectWeapon = (weapon) => {
  searchQuery.value = weapon.name;
  filteredWeapons.value = [];
  emit('weaponSelected', weapon);
};

onMounted(() => {
  fetchWeapons();
  fetchProperties();
});
</script>

<style scoped>
/* Add your styles here */
</style>