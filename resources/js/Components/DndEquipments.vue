<template>
  <div class="flex flex-col gap-6 p-6 bg-white rounded-lg dark:bg-gray-800">
    <!-- Search Section -->
    <div class="flex flex-col gap-4">
      <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
          <i class="fa-solid fa-box mr-2 text-blue-600"></i>Equipment
        </h3>
      </div>
      
      <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <i class="fa-solid fa-search text-gray-400"></i>
        </div>
        <TextInput 
          v-model="searchQuery" 
          placeholder="Search equipment by name or type..." 
          @input="searchEquipment" 
          class="w-full pl-10 pr-4 py-3 text-sm border-2 border-gray-200 rounded-lg focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:border-blue-400" />
        
        <!-- Search Results Dropdown -->
        <div v-if="searchQuery && filteredEquipment.length" 
             class="absolute z-20 w-full mt-1 bg-white border-2 border-gray-200 rounded-lg shadow-xl dark:bg-gray-700 dark:border-gray-600 max-h-64 overflow-y-auto">
          <div v-for="item in filteredEquipment.slice(0, 8)" :key="item.id" 
               @click="selectEquipment(item)" 
               class="flex items-center justify-between p-3 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-600 border-b border-gray-100 dark:border-gray-600 last:border-b-0">
            <div class="flex-1">
              <div class="font-medium text-gray-900 dark:text-gray-100">{{ item.name }}</div>
              <div class="text-sm text-blue-600 dark:text-blue-400">{{ item.type }}</div>
              <div v-if="item.notes" class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ item.notes }}</div>
            </div>
            <i class="fa-solid fa-plus text-blue-600 dark:text-blue-400"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Create Equipment Section -->
    <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
      <button type="button" 
              @click="collapseOpen = !collapseOpen"
              class="flex items-center gap-2 text-lg font-semibold text-gray-900 hover:text-blue-600 dark:text-gray-100 dark:hover:text-blue-400 transition-colors">
        <i class="fa-solid fa-wrench"></i>
        Create Custom Equipment
        <i class="transition-all duration-200 ease-out fa-solid fa-chevron-down" :class="{'rotate-180': collapseOpen}"></i>
      </button>
      
      <div v-if="collapseOpen" class="mt-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
        <form @submit.prevent="addEquipment" class="space-y-6">
          <!-- Basic Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Equipment Name</label>
              <TextInput v-model="newEquipment.name" placeholder="Enter equipment name..." required 
                        class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
              <select v-model="newEquipment.type" required 
                      class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled>Select equipment type</option>
                <option value="Armor">🛡️ Armor</option>
                <option value="Shield">🔰 Shield</option>
                <option value="Adventuring Gear">🎒 Adventuring Gear</option>
                <option value="Tools">🔨 Tools</option>
                <option value="Musical Instrument">🎵 Musical Instrument</option>
                <option value="Artisan's Tools">⚒️ Artisan's Tools</option>
                <option value="Gaming Set">🎲 Gaming Set</option>
                <option value="Kit">📦 Kit</option>
                <option value="Mount">🐎 Mount</option>
                <option value="Vehicle">🚢 Vehicle</option>
                <option value="Trade Goods">💰 Trade Goods</option>
                <option value="Consumable">🧪 Consumable</option>
                <option value="Magic Item">✨ Magic Item</option>
                <option value="Other">📋 Other</option>
              </select>
            </div>
          </div>
          
          <!-- Notes -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes & Description</label>
            <TextAreaInput rows="4" maxlength="255" v-model="newEquipment.notes" 
                          placeholder="Describe this equipment, its properties, or any special rules..." 
                          class="w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-600 dark:border-gray-500" />
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ newEquipment.notes?.length || 0 }}/255 characters</div>
          </div>
          
          <!-- Submit Button -->
          <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 transition-colors">
              <i class="fa-solid fa-plus mr-2"></i>Create Equipment
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits, onMounted } from 'vue';
import axios from 'axios';
import toast from '@/Stores/toast';
import TextInput from '@/Components/TextInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';

const emit = defineEmits(['equipmentSelected']);

const newEquipment = ref({
  name: '',
  type: '',
  notes: ''
});

const equipment = ref([]);
const searchQuery = ref('');
const filteredEquipment = ref([]);
const collapseOpen = ref(false);

const fetchEquipment = async () => {
  try {
    const response = await axios.get('/dnd/equipment');
    equipment.value = response.data;
    filteredEquipment.value = equipment.value;
  } catch (error) {
    toast.add({ type: 'error', message: 'Failed to fetch equipment' });
  }
};

const addEquipment = async () => {
  try {
    const response = await axios.post('/dnd/equipment', newEquipment.value);
    toast.add({ type: 'success', message: 'Equipment added successfully' });
    
    // Reset form
    newEquipment.value = {
      name: '',
      type: '',
      notes: ''
    };
    
    // Refresh equipment list
    fetchEquipment();
    collapseOpen.value = false;
  } catch (error) {
    toast.add({ type: 'error', message: 'Failed to add equipment' });
  }
};

const searchEquipment = () => {
  if (!searchQuery.value.trim()) {
    filteredEquipment.value = [];
    return;
  }
  
  filteredEquipment.value = equipment.value.filter(item =>
    item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    item.type.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
};

const selectEquipment = (selectedEquipment) => {
  searchQuery.value = selectedEquipment.name;
  filteredEquipment.value = [];
  emit('equipmentSelected', selectedEquipment);
};

onMounted(() => {
  fetchEquipment();
});
</script>

<style scoped>
/* Add your styles here if needed */
</style>