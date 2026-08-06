<template>
    <div class="p-4 bg-white rounded-lg dark:bg-gray-800 col-span-full">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Character Equipment</h3>
      
      <div v-if="equipment && equipment.length > 0">
        <!-- Equipment by Category -->
        <div v-for="(categoryItems, category) in groupedEquipment" :key="category" class="mb-6">
          <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3 border-b border-gray-300 dark:border-gray-600 pb-1">
            {{ category }} ({{ categoryItems.length }})
          </h4>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <div v-for="item in categoryItems" :key="item.id" 
                 class="p-3 border border-gray-200 rounded-lg dark:border-gray-600 dark:bg-gray-700 hover:shadow-md transition-shadow">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <h5 class="font-medium text-gray-900 dark:text-gray-100">{{ item.name }}</h5>
                  <p class="text-sm text-gray-600 dark:text-gray-400">{{ item.type }}</p>
                  <p v-if="item.notes" class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ item.notes }}</p>
                </div>
                <button v-if="checkUser" type="button" 
                        @click="removeEquipment(item.id)" 
                        class="ml-2 p-1 text-red-600 hover:text-red-800 hover:bg-red-100 rounded transition-colors dark:hover:bg-red-900 dark:hover:text-red-400"
                        title="Remove equipment">
                  <i class="text-xs fa-solid fa-x"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400">
        <i class="fa-solid fa-box-open text-3xl mb-2 opacity-50"></i>
        <p class="text-sm">No equipment added yet</p>
        <p class="text-xs mt-1">Use the search above to add equipment to your character</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineEmits, computed } from 'vue';
  import axios from 'axios';
  import toast from '@/Stores/toast';
  
  const props = defineProps({
    equipment: Array,
    characterId: Number,
    checkUser: Boolean
  });
  
  const emit = defineEmits(['equipmentRemoved']);
  
  // Group equipment by type/category
  const groupedEquipment = computed(() => {
    if (!props.equipment || props.equipment.length === 0) return {};
    
    return props.equipment.reduce((groups, item) => {
      const category = item.type || 'Other';
      if (!groups[category]) {
        groups[category] = [];
      }
      groups[category].push(item);
      return groups;
    }, {});
  });
  
  const removeEquipment = async (equipmentId) => {
    try {
      await axios.post('/dnd/character-equipment-delete', {
        character_id: props.characterId,
        equipment_id: equipmentId
      });
      toast.add({ type: 'success', message: 'Equipment removed successfully' });
      emit('equipmentRemoved', equipmentId);
    } catch (error) {
      toast.add({ type: 'error', message: 'Failed to remove equipment' });
    }
  };
  </script>
  
  <style scoped>
  /* Add your styles here if needed */
  </style>