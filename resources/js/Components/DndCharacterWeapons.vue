<template>
    <div class="p-4 bg-white rounded-lg dark:bg-gray-800 col-span-full">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Character Weapons</h3>
      
      <div v-if="weapons && weapons.length > 0">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="weapon in weapons" :key="weapon.id" 
               class="p-4 border border-gray-200 rounded-lg dark:border-gray-600 dark:bg-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
              <div class="flex-1">
                <h5 class="font-semibold text-gray-900 dark:text-gray-100 text-lg">{{ weapon.name }}</h5>
                <p class="text-sm text-orange-600 dark:text-orange-400 font-medium">{{ weapon.damage_and_type }}</p>
              </div>
              <button v-if="checkUser" type="button" 
                      @click="removeWeapon(weapon.id)" 
                      class="ml-2 p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition-colors dark:hover:bg-red-900 dark:hover:text-red-400"
                      title="Remove weapon">
                <i class="text-sm fa-solid fa-trash"></i>
              </button>
            </div>
            
            <div class="space-y-2">
              <div v-if="weapon.weight || weapon.cost" class="flex justify-between text-sm">
                <span v-if="weapon.weight" class="text-gray-600 dark:text-gray-400">
                  <i class="fa-solid fa-weight-hanging mr-1"></i>{{ weapon.weight }}
                </span>
                <span v-if="weapon.cost" class="text-green-600 dark:text-green-400">
                  <i class="fa-solid fa-coins mr-1"></i>{{ weapon.cost }}
                </span>
              </div>
              
              <div v-if="weapon.properties && JSON.parse(weapon.properties).length > 0" class="text-sm">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Properties:</span>
                <div class="flex flex-wrap gap-1 mt-1">
                  <span v-for="propertyId in JSON.parse(weapon.properties)" :key="propertyId"
                        class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-200">
                    {{ getPropertyById(propertyId).name }}
                  </span>
                </div>
              </div>
              
              <div v-if="weapon.mastery && getPropertyById(weapon.mastery)?.name" class="text-sm">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Mastery:</span>
                <span class="ml-2 px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full dark:bg-purple-900 dark:text-purple-200">
                  {{ getPropertyById(weapon.mastery)?.name }}
                </span>
              </div>
              
              <div v-if="weapon.notes" class="text-sm">
                <span class="text-gray-700 dark:text-gray-300 font-medium">Notes:</span>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ weapon.notes }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400">
        <i class="fa-solid fa-sword text-3xl mb-2 opacity-50"></i>
        <p class="text-sm">No weapons added yet</p>
        <p class="text-xs mt-1">Use the search above to add weapons to your character</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineEmits, onMounted } from 'vue';
  import axios from 'axios';
  import toast from '@/Stores/toast';
  
  const props = defineProps({
    weapons: Array,
    characterId: Number,
    checkUser: Boolean
  });
  
  const emit = defineEmits(['weaponRemoved']);
  
  const properties = ref([]);
  
  const fetchProperties = async () => {
    try {
      const response = await axios.get('/dnd/weapon-properties');
      properties.value = response.data;
    } catch (error) {
      toast.add({ type: 'error', message: 'Failed to fetch properties' });
    }
  };
  
  const getPropertyById = (id) => {
    return properties.value.find(property => property.id === id) || {};
  };
  
  const removeWeapon = async (weaponId) => {
    try {
      await axios.post('/dnd/character-weapon-delete', {
        character_id: props.characterId,
        weapon_id: weaponId
      });
      toast.add({ type: 'success', message: 'Weapon removed successfully' });
      emit('weaponRemoved', weaponId);
    } catch (error) {
      toast.add({ type: 'error', message: 'Failed to remove weapon' });
    }
  };
  
  onMounted(() => {
    fetchProperties();
  });
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>