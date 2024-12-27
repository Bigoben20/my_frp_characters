<template>
  <div class="flex flex-col p-4 bg-white rounded-lg dark:bg-gray-800">
      <div class="flex flex-col items-start">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Search Weapons</h3>
          <div class="relative w-full md:w-1/2">
            <TextInput v-model="searchQuery" placeholder="Search by name" @input="searchWeapons" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
            <ul v-if="searchQuery && filteredWeapons.length" class="absolute z-10 w-full mt-1 bg-white border rounded shadow-lg dark:bg-gray-700 dark:border-gray-600">
              <li v-for="weapon in filteredWeapons" :key="weapon.id" @click="selectWeapon(weapon)" class="px-4 py-2 overflow-hidden cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 text-ellipsis">
                {{ weapon.name }}, {{ weapon.atk_bonus }}/{{ weapon.dc }}, {{ weapon.damage_and_type }}
              </li>
            </ul>
          </div>
      </div>
      <div class="mt-4">
        <button type="button" class="text-lg font-semibold text-gray-900 hover:text-indigo-500 dark:text-gray-100" @click="collapseOpen = !collapseOpen">Create Weapon <i class="transition-all duration-100 ease-out fa-solid fa-chevron-down" :class="{'rotate-180':collapseOpen}"></i></button>
        <form @submit.prevent="addWeapon" class="grid grid-cols-2 gap-4 md:grid-cols-5" v-if="collapseOpen">
          <TextInput v-model="newWeapon.name" placeholder="Weapon Name" required class="w-full col-span-2 p-2 border rounded md:col-span-1 dark:bg-gray-700 dark:border-gray-600" />
          <TextInput v-model="newWeapon.atk_bonus" placeholder="Attack Bonus" required class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
          <TextInput v-model="newWeapon.dc" placeholder="DC" required class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600" />
          <TextInput v-model="newWeapon.damage_and_type" placeholder="Damage and Type" required class="w-full col-span-2 p-2 border rounded md:col-span-1 dark:bg-gray-700 dark:border-gray-600" />
          <button type="submit" class="col-span-2 px-4 py-2 text-white bg-indigo-500 rounded md:col-span-1 hover:bg-indigo-600">Create Weapon</button>
        </form>
    </div>


    <!-- <ul class="mt-4">
      <li v-for="weapon in weapons" :key="weapon.id" class="flex items-center justify-between p-2 border-b dark:border-gray-600">
        <span>{{ weapon.name }} - {{ weapon.damage_and_type }}</span>
        <button @click="deleteWeapon(weapon.id)" class="px-2 py-1 text-red-600 bg-red-100 rounded hover:bg-red-200">Delete</button>
      </li>
    </ul> -->
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';
import axios from 'axios';
import toast from '@/Stores/toast';
import TextInput from '@/Components/TextInput.vue';

const emit = defineEmits(['weaponSelected']);

const collapseOpen = ref(false);
const newWeapon = ref({
  name: '',
  atk_bonus: '',
  dc: '',
  damage_and_type: ''
});

const weapons = ref([]);
const searchQuery = ref('');
const filteredWeapons = ref([]);

const fetchWeapons = async () => {
  try {
    const response = await axios.get('/dnd/weapons');
    weapons.value = response.data;
    filteredWeapons.value = weapons.value;
  } catch (error) {
    toast.add({ type: 'error', message: 'Failed to fetch weapons' });
  }
};

const addWeapon = async () => {
  try {
    await axios.post('/dnd/weapons', newWeapon.value);
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

fetchWeapons();
</script>

<style scoped>
/* Add your styles here */
</style>