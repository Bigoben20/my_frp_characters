<template>
    <div class="flex flex-col p-4 bg-white rounded-lg dark:bg-gray-800">
      <div class="flex flex-col items-start">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Search Spells</h3>
        <div class="relative w-full md:w-1/2">
          <TextInput v-model="searchQuery" placeholder="Search by name" @input="searchSpells" class="w-full" />
          <ul v-if="searchQuery && filteredSpells.length" class="absolute z-10 w-full mt-1 bg-white border rounded shadow-lg dark:bg-gray-700 dark:border-gray-600">
            <li v-for="spell in filteredSpells" :key="spell.id" @click="selectSpell(spell)" class="px-4 py-2 overflow-hidden cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 text-ellipsis">
              {{ spell.name }}, {{ spell.level == 0 ? 'Cantrip' : 'Level '+spell.level }}
            </li>
          </ul>
        </div>
      </div>
      <div class="mt-4">
        <button type="button" class="text-lg font-semibold text-gray-900 hover:text-indigo-500 dark:text-gray-100" @click="collapseOpen = !collapseOpen">Create Spell <i class="transition-all duration-100 ease-out fa-solid fa-chevron-down" :class="{'rotate-180':collapseOpen}"></i></button>
        <form @submit.prevent="addSpell" class="grid grid-cols-2 gap-4 md:grid-cols-5" v-if="collapseOpen">
          <TextInput v-model="newSpell.name" placeholder="Spell Name" required class="w-full col-span-2" />
          <TextInput v-model="newSpell.level" type="number" min="0" placeholder="Level" required class="w-full" />
          <TextInput v-model="newSpell.school" placeholder="School" required class="w-full" />
          <TextInput v-model="newSpell.casting_time" placeholder="Casting Time" required class="w-full" />
          <TextInput v-model="newSpell.range" placeholder="Range" required class="w-full" />
          <TextInput v-model="newSpell.duration" placeholder="Duration" required class="w-full" />
          <TextInput v-model="newSpell.components" placeholder="Components" required class="w-full" />
          <TextAreaInput v-model="newSpell.description" placeholder="Description" required class="w-full col-span-2" />
          <TextAreaInput v-model="newSpell.higher_levels" placeholder="Higher Levels" class="w-full col-span-2" />
          <div class="flex gap-4 col-span-full">
            <div class="flex items-center col-span-2 md:col-span-1">
              <label class="mr-1">Concentration</label>
              <input type="checkbox" v-model="newSpell.concentration" class="w-4 h-4" />
            </div>
            <div class="flex items-center col-span-2 md:col-span-1">
              <label class="mr-1">Ritual</label>
              <input type="checkbox" v-model="newSpell.ritual" class="w-4 h-4" />
            </div>
          </div>
          <div class="flex flex-col col-span-full">
            <div class="">Classes</div>
            <div class="flex flex-wrap text-xs gap-x-6 gap-y-2">
              <div v-for="dndClass in classes" :key="dndClass.id" class="flex items-center col-span-2 md:col-span-1">
                <label class="mr-1" :for="dndClass.name">{{ dndClass.name }}</label>
                <input type="checkbox" class="w-3 h-3 generalInput" v-model="selectedClasses" :value="dndClass.id" :id="dndClass.name"/>
              </div>
            </div>
          </div>
          <button type="submit" class="col-span-2 px-4 py-2 text-white bg-indigo-500 rounded md:col-span-1 hover:bg-indigo-600">Create Spell</button>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, defineEmits, onMounted, watch } from 'vue';
  import axios from 'axios';
  import toast from '@/Stores/toast';
  import TextInput from '@/Components/TextInput.vue';
  import TextAreaInput from '@/Components/TextAreaInput.vue';
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
  watch(selectedClasses, () => {
    console.log(selectedClasses.value);
    
    newSpell.value.classes = JSON.stringify(selectedClasses.value);
  });
  const fetchSpells = async () => {
    try {
      const response = await axios.get('/dnd/spells');
      spells.value = response.data;
      filteredSpells.value = spells.value;
    } catch (error) {
      toast.add({ type: 'error', message: 'Failed to fetch spells' });
    }
  };
  
  const addSpell = async () => {
    try {
      await axios.post('/dnd/spells', newSpell.value);
      toast.add({ type: 'success', message: 'Spell added successfully' });
      fetchSpells();
    } catch (error) {
      toast.add({ type: 'error', message: 'Failed to add spell' });
    }
  };
  
  const searchSpells = () => {
    filteredSpells.value = spells.value.filter(spell =>
      spell.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  };
  
  const selectSpell = (spell) => {
    searchQuery.value = spell.name;
    filteredSpells.value = [];
    emit('spellSelected', spell);
  };
  
  onMounted(() => {
    fetchSpells();
  });
  </script>
  
  <style scoped>
  /* Add your styles here */
  </style>