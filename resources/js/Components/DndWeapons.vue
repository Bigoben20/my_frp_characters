<template>
  <div class="flex flex-col p-4 bg-white rounded-lg dark:bg-gray-800">
    <div class="flex flex-col items-start">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Search Weapons</h3>
      <div class="relative w-full md:w-1/2">
        <TextInput v-model="searchQuery" placeholder="Search by name" @input="searchWeapons" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
        <ul v-if="searchQuery && filteredWeapons.length" class="absolute z-10 w-full mt-1 bg-white border rounded shadow-lg dark:bg-gray-700 dark:border-gray-600">
          <li v-for="weapon in filteredWeapons" :key="weapon.id" @click="selectWeapon(weapon)" class="px-4 py-2 overflow-hidden cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 text-ellipsis">
            {{ weapon.name }}, {{ weapon.damage_and_type }}
          </li>
        </ul>
      </div>
    </div>
    <div class="mt-4">
      <button type="button" class="text-lg font-semibold text-gray-900 hover:text-indigo-500 dark:text-gray-100" @click="collapseOpen = !collapseOpen">Create Weapon <i class="transition-all duration-100 ease-out fa-solid fa-chevron-down" :class="{'rotate-180':collapseOpen}"></i></button>
      <form @submit.prevent="addWeapon" class="grid items-start grid-cols-2 gap-4 md:grid-cols-5" v-if="collapseOpen">
        <TextInput v-model="newWeapon.name" placeholder="Weapon Name" required class="w-full col-span-2 p-2 border rounded md:col-span-1 dark:bg-gray-700 dark:border-gray-600" />
        <TextInput v-model="newWeapon.damage_and_type" placeholder="Damage and Type" required class="w-full col-span-2 p-2 border rounded md:col-span-1 dark:bg-gray-700 dark:border-gray-600" />
        <TextInput v-model="newWeapon.weight" placeholder="Weight" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
        <TextInput v-model="newWeapon.cost" placeholder="Cost" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
        <TextAreaInput maxlength="255" v-model="newWeapon.notes" placeholder="Notes" class="w-full col-span-2 p-2 border rounded md:col-span-1 dark:bg-gray-700 dark:border-gray-600" />
        
        <div class="col-span-full">
          <h4 class="font-semibold text-gray-900 text-md dark:text-gray-100">Properties</h4>
          <div class="grid w-full grid-cols-2 gap-2 md:w-1/2">
            <div v-for="property in nonMasteryProperties" :key="property.id">
              <label>
                <input type="checkbox" v-model="newWeapon.properties" :value="property.id" />
                {{ property.name }}
              </label>
            </div>
          </div>
        </div>
        
        <div class="col-span-full">
          <h4 class="font-semibold text-gray-900 text-md dark:text-gray-100">Mastery</h4>
          <div class="grid w-full grid-cols-2 gap-2 md:w-1/2">
            <div v-for="property in masteryProperties" :key="property.id">
              <label>
                <input type="radio" v-model="newWeapon.mastery" :value="property.id" />
                {{ property.name }}
              </label>
            </div>
          </div>
        </div>
        
        <button type="submit" class="col-span-2 px-4 py-2 text-white bg-indigo-500 rounded md:col-span-1 hover:bg-indigo-600">Create Weapon</button>
      </form>
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