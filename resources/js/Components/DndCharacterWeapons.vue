<template>
    <div class="p-4 bg-white rounded-lg dark:bg-gray-800 col-span-full">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Character Weapons</h3>
      <div class="overflow-x-auto whitespace-nowrap">
        <table class="w-full mt-4 text-sm text-left table-auto">
          <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
              <th class="px-2 py-1">Weapon Name</th>
              <th class="px-2 py-1">Damage and Type</th>
              <th class="px-2 py-1">Weight</th>
              <th class="px-2 py-1">Cost</th>
              <th class="px-2 py-1">Properties</th>
              <th class="px-2 py-1">Mastery</th>
              <th class="px-2 py-1">Notes</th>
              <th class="px-2 py-1">Remove</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="weapon in weapons" :key="weapon.id">
              <td class="px-2 py-1">{{ weapon.name }}</td>
              <td class="px-2 py-1">{{ weapon.damage_and_type }}</td>
              <td class="px-2 py-1">{{ weapon.weight }}</td>
              <td class="px-2 py-1">{{ weapon.cost }}</td>
              <td class="px-2 py-1 overflow-hidden text-ellipsis">
                <span v-for="propertyId in JSON.parse(weapon.properties)" :key="propertyId">
                  {{ getPropertyById(propertyId).name }},
                </span>
              </td>
              <td class="px-2 py-1">{{ getPropertyById(weapon.mastery)?.name || '' }}</td>
              <td class="px-2 py-1">{{ weapon.notes }}</td>
              <td class="px-2 py-1">
                <button type="button" @click="removeWeapon(weapon.id)" class="w-6 h-6 text-red-600 rounded-full hover:bg-red-100">
                  <i class="text-xs fa-solid fa-x"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineEmits, onMounted } from 'vue';
  import axios from 'axios';
  import toast from '@/Stores/toast';
  
  const props = defineProps({
    weapons: Array,
    characterId: Number
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
      await axios.post('/dnd/character/weapon/delete', {
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