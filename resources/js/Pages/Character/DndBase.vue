<template>
    <form @submit.prevent="updateCharacter" class="grid grid-cols-1 gap-8 px-2 pt-6 pb-32 md:px-6 dark:text-gray-100">
        <div class="flex flex-col gap-1 -mb-4 col-span-full">
            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                Tabs
            </span>
            <div class="flex gap-2 overflow-x-auto">
                <button type="button" @click="tabs.forEach(t => t.active = true)"
                    :class="tabs.every(t => t.active == true) ? 'bg-indigo-500 dark:bg-indigo-200 text-white dark:text-indigo-600' : 'bg-gray-200 text-gray-800'"
                    class="px-4 py-1 rounded-full whitespace-nowrap">
                    All
                </button>
                <template v-for="tab in tabs" :key="tab.id">
                    <button type="button" @click="tabs.forEach(t => t.active = t.id == tab.id)"
                        :class="tab.active ? 'bg-indigo-500 dark:bg-indigo-200 text-white dark:text-indigo-600' : 'bg-gray-200 text-gray-800'" class="px-4 py-1 rounded-full whitespace-nowrap">
                        {{ tab.name }}
                    </button>
                </template>
            </div>
        </div>
        <transition-group name="tab-fade">
            <div class="flex flex-col gap-8" v-show="tabs[0].active" :key="tabs[0].id">
                <!-- Character Name -->
                <div class="grid grid-cols-2 p-4 bg-white rounded-lg gap-y-1 gap-x-4 dark:bg-gray-800">
                    <div class="flex flex-col items-start w-full col-span-full">
                        <label for="name" class="ml-1">Name</label>
                        <TextInput maxlength="255" :auth="checkUser" id="name" v-model="character.characterData.name" class="w-full col-span-full" />
                        <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.name)" />
                    </div>
                    <div class="flex flex-col items-start w-full ">
                        <label for="background" class="ml-1">Background</label>
                        <TextInput maxlength="100" :auth="checkUser" id="background" v-model="character.characterData.background" class="w-full col-span-full" />
                        <TextCounter v-if="checkUser" maxlength="100" :value="getLength(character.characterData.background)" />
                    </div>
                    <div class="flex flex-col items-start w-full ">
                        <label for="class" class="ml-1">Class</label>
                        <select :disabled="!checkUser" id="class" v-model="character.characterData.class" class="w-full col-span-full generalInput">
                            <option value="" disabled selected>Select Class</option>
                            <option v-for="dndClass in classes" :key="dndClass.id" :value="dndClass.id">{{ dndClass.name }}</option>
                        </select>
                    </div>
                    <div class="flex flex-col items-start w-full ">
                        <label for="species" class="ml-1">Species</label>
                        <TextInput maxlength="100" :auth="checkUser" id="species" v-model="character.characterData.species" class="w-full col-span-full" />
                        <TextCounter v-if="checkUser" maxlength="100" :value="getLength(character.characterData.species)" />
                    </div>
                    <div class="flex flex-col items-start w-full">
                        <label for="subclass" class="ml-1">Subclass</label>
                        <TextInput maxlength="100" :auth="checkUser" id="subclass" v-model="character.characterData.subclass" class="w-full col-span-full" />
                        <TextCounter v-if="checkUser" maxlength="100" :value="getLength(character.characterData.subclass)" />
                    </div>
                </div>

                <!-- Level, Armor Class, HP, Hit Dice, Death Saves -->
                <div class="grid grid-cols-2 gap-4 md:grid-cols-6">
                    <!-- Level -->
                    <div class="flex flex-col justify-end p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="flex flex-col items-start w-full gap-2">
                            <label for="level" class="ml-1">Level</label>
                            <TextInput maxlength="3" type="tel" v-mask="'###'" :auth="checkUser" id="level" v-model="character.characterData.level" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="xp" class="ml-1">XP</label>
                            <TextInput maxlength="10" type="tel" v-mask="'##########'" :auth="checkUser" id="level" v-model="character.characterData.xp" class="w-full" />
                        </div>
                    </div>

                    <!-- Armor Class -->
                    <div class="flex flex-col justify-end gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="flex flex-col items-start w-full">
                            <label for="ac" class="ml-1">Armor Class</label>
                            <TextInput maxlength="10" :auth="checkUser" id="ac" v-model="character.characterData.ac" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="shield" class="ml-1">Shield</label>
                            <TextInput maxlength="3" :auth="checkUser" id="shield" v-model="character.characterData.shield" class="w-full" />
                        </div>
                    </div>

                    <!-- Hit Points -->
                    <div class="grid grid-cols-2 col-span-2 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="-mb-2 font-semibold tracking-wide text-center col-span-full">
                            <span>Hit Points</span>
                        </div>
                        <div class="flex flex-col items-start w-full col-span-full">
                            <label for="current_hp" class="ml-1">Current HP</label>
                            <TextInput maxlength="10" :auth="checkUser" id="current_hp" v-model="character.characterData.current_hp" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="max_hp" class="ml-1">Max HP</label>
                            <TextInput maxlength="10" :auth="checkUser" id="max_hp" v-model="character.characterData.max_hp" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="temp_hp" class="ml-1">Temp HP</label>
                            <TextInput maxlength="10" :auth="checkUser" id="temp_hp" v-model="character.characterData.temp_hp" class="w-full" />
                        </div>
                    </div>

                    <!-- Hit Dice -->
                    <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="-mb-2 font-semibold tracking-wide text-center col-span-full">
                            <span>Hit Dice</span>
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="spent_hit_dice" class="ml-1">Spent</label>
                            <TextInput maxlength="10" :auth="checkUser" id="spent_hit_dice" v-model="character.characterData.spent_hit_dice" class="w-full" />
                        </div>
                        <div class="flex flex-col items-start w-full">
                            <label for="max_hit_dice" class="ml-1">Max</label>
                            <TextInput maxlength="10" :auth="checkUser" id="max_hit_dice" v-model="character.characterData.max_hit_dice" class="w-full" />
                        </div>
                    </div>

                    <!-- Death Saves -->
                    <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="-mb-2 font-semibold tracking-wide text-center col-span-full">
                            <span>Death Saves</span>
                        </div>
                        <div>
                            <div class="">
                                <span>Successes</span>
                            </div>
                            <div class="flex justify-between w-full gap-4 sm:justify-start">
                                <div v-for="(checkbox, index) in successDeathSaves" :key="index">
                                    <input :disabled="!checkUser" :id="'success-' + (index + 1)" type="checkbox" v-model="checkbox.checked" @change="countChecked" class="hidden peer">
                                    <label :for="'success-' + (index + 1)"
                                        class="inline-flex items-center justify-center w-5 h-5 text-transparent rotate-45 bg-white border border-gray-300 cursor-pointer dark:bg-gray-800 dark:border-gray-700 peer-checked:border-green-600 dark:peer-checked:text-green-300 peer-checked:text-green-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <i class="text-2xl -rotate-45 fa-solid fa-x"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="">
                                <span>Failures</span>
                            </div>
                            <div class="flex justify-between w-full gap-4 sm:justify-start">
                                <div v-for="(checkbox, index) in failDeathSaves" :key="index">
                                    <input :disabled="!checkUser" :id="'fail-' + (index + 1)" type="checkbox" v-model="checkbox.checked" @change="countChecked" class="hidden peer">
                                    <label :for="'fail-' + (index + 1)"
                                        class="inline-flex items-center justify-center w-5 h-5 text-transparent rotate-45 bg-white border border-gray-300 cursor-pointer dark:bg-gray-800 dark:border-gray-700 peer-checked:border-red-600 dark:peer-checked:text-red-300 peer-checked:text-red-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <i class="text-2xl -rotate-45 fa-solid fa-x"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Initiative, Speed, Size, Passive Perception -->
                <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
                    <div class="flex flex-col items-start w-full p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="initiative" class="w-full ml-1 font-semibold tracking-wide text-center">Initiative</label>
                        <TextInput maxlength="5" :auth="checkUser" id="initiative" v-model="character.characterData.initiative" class="w-full" />
                    </div>
                    <div class="flex flex-col items-start w-full p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="speed" class="w-full ml-1 font-semibold tracking-wide text-center">Speed</label>
                        <TextInput maxlength="5" :auth="checkUser" id="speed" v-model="character.characterData.speed" class="w-full" />
                    </div>
                    <div class="flex flex-col items-start w-full p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="size" class="w-full ml-1 font-semibold tracking-wide text-center">Size</label>
                        <TextInput maxlength="10" :auth="checkUser" id="size" v-model="character.characterData.size" class="w-full capitalize" />
                    </div>
                    <div class="flex flex-col items-start w-full p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="passive_perception" class="w-full ml-1 font-semibold tracking-wide text-center">Passive Perception</label>
                        <TextInput maxlength="3" :auth="checkUser" id="passive_perception" v-model="character.characterData.passive_perception" class="w-full" />
                    </div>
                </div>

                <!-- Appearance, Backstory, Alignment, Languages -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="appearance" class="w-full ml-1 font-semibold tracking-wide text-center">Appearance</label>
                        <TextAreaInput row="10" maxlength="1000" :auth="checkUser" id="appearance" v-model="character.characterData.appearance" class="w-full" />
                        <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.appearance)" />
                    </div>
                    <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="backstory" class="w-full ml-1 font-semibold tracking-wide text-center">Backstory</label>
                        <TextAreaInput row="10" maxlength="1000" :auth="checkUser" id="backstory" v-model="character.characterData.backstory" class="w-full" />
                        <TextCounter v-if="checkUser" maxlength="300" :value="getLength(character.characterData.backstory)" />
                    </div>
                    <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="alignment" class="w-full ml-1 font-semibold tracking-wide text-center">Alignment</label>
                        <TextInput maxlength="20" :auth="checkUser" id="alignment" v-model="character.characterData.alignment" class="w-full" />
                    </div>
                    <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <label for="languages" class="w-full ml-1 font-semibold tracking-wide text-center">Languages</label>
                        <TextAreaInput maxlength="255" :auth="checkUser" id="languages" v-model="character.characterData.languages" class="w-full" />
                    </div>
                </div>
            </div>

            <!-- Abilities -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6" v-show="tabs[1].active" :key="tabs[1].id">
                <div class="flex flex-wrap gap-4 col-span-full">
                    <div class="flex flex-col items-center gap-1 p-4 bg-white rounded-lg dark:bg-gray-800 h-fit">
                        <span class="text-sm font-semibold">Proficiency Bonus</span>
                        <TextInput maxlength="3" type="tel" v-mask="'+#'" :auth="checkUser" id="proficiency_bonus" v-model="character.characterData.abilities.proficiency_bonus" class="w-12" />
                    </div>
                    <div class="flex flex-col items-center gap-1 p-4 bg-white rounded-lg dark:bg-gray-800 h-fit">
                        <span class="text-sm font-semibold">Heroic Inspiration</span>
                        <div>
                            <input :disabled="!checkUser" id="heroic_inspiration" type="checkbox" v-model="character.characterData.abilities.heroic_inspiration" class="hidden peer">
                            <label :for="'heroic_inspiration'"
                                class="inline-flex items-center justify-center w-10 h-10 text-transparent rotate-45 bg-white border border-gray-300 rounded-full cursor-pointer dark:border-gray-700 peer-checked:border-green-600 dark:peer-checked:text-green-300 peer-checked:text-green-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900">
                                <i class="text-xl -rotate-45 fa-solid fa-star"></i>
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-1 p-4 bg-white rounded-lg dark:bg-gray-800">
                        <span class="text-sm font-semibold">Equipment Trainng & Proficiencies</span>
                        <div class="flex items-center gap-4">
                            <span for="armor_training" class="text-xs">Armor Training</span>
                            <div v-for="(proficiency, index) in ['light', 'medium', 'heavy', 'shield']" :key="index">
                                <label :for="proficiency">
                                    <input :disabled="!checkUser" :id="proficiency" type="checkbox" v-model="armorTrainings[proficiency]"
                                        class="inline-flex items-center justify-center w-3 h-3 mr-1 text-indigo-500 bg-white border border-gray-300 rounded-[2px] cursor-pointer dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900">
                                    <span class="text-xs capitalize">{{ proficiency }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="weapons_profs" class="text-xs">Weapons</label>
                                <TextAreaInput placeholder="Weapons" maxlength="1000" :auth="checkUser" id="weapons_profs" v-model="proficiencies.weapons.proficiencies"
                                    class="w-full text-sm col-span-full" />
                            </div>
                            <div>
                                <label for="tools_profs" class="text-xs">Tools</label>
                                <TextAreaInput placeholder="Tools" maxlength="1000" :auth="checkUser" id="tools_profs" v-model="proficiencies.tools.proficiencies"
                                    class="w-full text-sm col-span-full" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg dark:bg-gray-800" v-for="(ability, index) in character.abilities" :key="index">
                    <div class="flex flex-col justify-center p-4 text-center border-b border-gray-300 dark:border-gray-700">
                        <span class="text-sm font-semibold">{{ ability.ability_name }}</span>
                        <div class="flex items-center justify-center gap-2 mt-2">
                            <div class="flex items-center justify-center h-10 px-2 border border-gray-300 rounded-full min-w-10 dark:border-gray-700 dark:bg-gray-900">
                                {{ ability.ability_modifier }}
                            </div>
                            <div>
                                <TextInput maxlength="3" type="tel" v-mask="'###'" :auth="checkUser" id="ability_score" v-model="ability.ability_score"
                                    @input="ability.ability_modifier = getModifier(ability.ability_score)" class="w-full" placeholder="Score" />
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 px-4 py-2 border-b dark:border-gray-700">
                        <div>
                            <input :disabled="!checkUser" :id="ability.ability_name + '_savingthrow'" type="checkbox" v-model="ability.saving_throw" class="hidden peer">
                            <label :for="ability.ability_name + '_savingthrow'"
                                class="inline-flex items-center justify-center w-5 h-5 text-transparent rotate-45 bg-white border border-gray-300 rounded-full cursor-pointer dark:bg-gray-800 dark:border-gray-700 peer-checked:border-green-600 dark:peer-checked:text-green-300 peer-checked:text-green-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="text-xl -rotate-45 fa-solid fa-x"></i>
                            </label>
                        </div>
                        <span class="text-xs">Saving Throw</span>
                    </div>
                    <div class="flex flex-col gap-1 px-4 py-2">
                        <div class="flex items-center gap-2" v-for="(sub_ability, index) in ability.sub_abilities" :key="index">
                            <div>
                                <input :disabled="!checkUser" :id="sub_ability.name + '_savingthrow'" type="checkbox" v-model="ability.sub_abilities[index].saving_throw_check" class="hidden peer">
                                <label :for="sub_ability.name + '_savingthrow'"
                                    class="inline-flex items-center justify-center w-4 h-4 text-transparent rotate-45 bg-white border border-gray-300 rounded-full cursor-pointer dark:bg-gray-800 dark:border-gray-700 peer-checked:border-green-600 dark:peer-checked:text-green-300 peer-checked:text-green-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <i class="text-xl -rotate-45 fa-solid fa-x"></i>
                                </label>
                            </div>
                            <input class="w-full text-sm lineInput" maxlength="3" :disabled="!checkUser" id="sub_ability_modifier" v-model="sub_ability.sub_ability_modifier" placeholder="Mod" />
                            <span class="text-[11px] whitespace-nowrap">{{ sub_ability.name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feats -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3" v-show="tabs[2].active" :key="tabs[2].id">
                <div class="flex flex-col items-start gap-1 p-4 bg-white rounded-lg dark:bg-gray-800">
                    <span class="text-sm font-semibold">Feats</span>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-2 py-1">Feat Name</th>
                                <th class="px-2 py-1">Description</th>
                                <th class="px-2 py-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <tr v-for="(feat, index) in character.characterData.features.feats" :key="index">
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <input maxlength="20" v-model="feat.name" placeholder="Feat Name" class="text-sm lineInput" />
                                    </div>
                                </td>
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <textarea row="3" maxlength="255" v-model="feat.description" placeholder="Description" class="text-[11px] lineInput" />
                                    </div>
                                </td>
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <button type="button" @click="removeFeat(index)" class="text-red-600">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" @click="addFeat" class="mt-2 text-green-600">
                        <i class="fa-solid fa-plus"></i> Add Feat
                    </button>
                </div>
                <div class="flex flex-col items-start gap-1 p-4 bg-white rounded-lg dark:bg-gray-800">
                    <span class="text-sm font-semibold">Class Features</span>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-2 py-1">Feature Name</th>
                                <th class="px-2 py-1">Description</th>
                                <th class="px-2 py-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <tr v-for="(feature, index) in character.characterData.features.class_features" :key="index">
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <input maxlength="20" v-model="feature.name" placeholder="Feature Name" class="text-sm lineInput" />
                                    </div>
                                </td>
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <textarea row="3" maxlength="255" v-model="feature.description" placeholder="Description" class="text-[11px] lineInput" />
                                    </div>
                                </td>
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <button type="button" @click="removeClassFeature(index)" class="text-red-600">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" @click="addClassFeature" class="mt-2 text-green-600">
                        <i class="fa-solid fa-plus"></i> Add Feature
                    </button>
                </div>
                <div class="flex flex-col items-start gap-1 p-4 bg-white rounded-lg dark:bg-gray-800">
                    <span class="text-sm font-semibold">Species Traits</span>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-2 py-1">Trait Name</th>
                                <th class="px-2 py-1">Description</th>
                                <th class="px-2 py-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <tr v-for="(trait, index) in character.characterData.features.species_traits" :key="index">
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <input maxlength="20" v-model="trait.name" placeholder="Trait Name" class="text-sm lineInput" />
                                    </div>
                                </td>
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <textarea row="3" maxlength="255" v-model="trait.description" placeholder="Description" class="text-[11px] lineInput" />
                                    </div>
                                </td>
                                <td class="px-2 py-1">
                                    <div class="flex items-end h-[42px]">
                                        <button type="button" @click="removeSpeciesTrait(index)" class="text-red-600">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" @click="addSpeciesTrait" class="mt-2 text-green-600">
                        <i class="fa-solid fa-plus"></i> Add Trait
                    </button>
                </div>
            </div>

            <!-- Equipment -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2" v-show="tabs[3].active" :key="tabs[3].id">
                <DndWeapons v-if="checkUser" @weaponSelected="handleWeaponSelected" class="col-span-full" />

                <DndCharacterWeapons v-if="checkUser" :weapons="character.characterData.weapons" :character-id="character.characterData.id" @weaponRemoved="handleWeaponRemoved"
                    class="col-span-full" />
            </div>

            <!-- Spells -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2" v-show="tabs[4].active" :key="tabs[4].id">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3 col-span-full">
                    <div class="flex flex-col p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div>
                            <label for="spellcasting_ability" class="ml-1">Spellcasting Ability</label>
                            <select :disabled="!checkUser" id="spellcasting_ability" v-model="character.characterData.spellcasting_ability" class="w-full generalInput">
                                <option value="" selected>None</option>
                                <option v-for="ability in abilities" :key="ability.ability_name" :value="ability.ability_name">{{ ability.ability_name }}</option>
                            </select>
                        </div>
                        <hr class="mt-2 border-gray-300 dark:border-gray-700" />
                        <div class="grid grid-cols-3 divide-x divide-gray-300 dark:divide-gray-700">
                            <div class="p-2">
                                {{ spellcastingAbility ? spellcastingAbility.ability_modifier : '+0' }}
                            </div>
                            <div class="col-span-2 p-2">
                                Spellcasting Modifier
                            </div>
                        </div>
                        <hr class="border-gray-300 dark:border-gray-700" />
                        <div class="grid grid-cols-3 divide-x divide-gray-300 dark:divide-gray-700">
                            <div class="p-2">
                                {{ spellcastingAbility ? 8 + parseInt(spellcastingAbility.ability_modifier) + parseInt(character.characterData.abilities.proficiency_bonus ?? "0") : '+0' }}
                            </div>
                            <div class="col-span-2 p-2">
                                Spell Save DC
                            </div>
                        </div>
                        <hr class="border-gray-300 dark:border-gray-700" />
                        <div class="grid grid-cols-3 divide-x divide-gray-300 dark:divide-gray-700">
                            <div class="p-2">
                                +{{ spellcastingAbility ? parseInt(spellcastingAbility.ability_modifier) + parseInt(character.characterData.abilities.proficiency_bonus ?? "0") : '0' }}
                            </div>
                            <div class="col-span-2 p-2">
                                Spell Attack Bonus
                            </div>
                        </div>
                        <hr class="border-gray-300 dark:border-gray-700" />
                    </div>
                    <div class="flex flex-col p-4 bg-white rounded-lg dark:bg-gray-800" v-if="checkUser">
                        <div class="font-semibold tracking-wide text-center">
                            Spell Slots
                        </div>
                        <hr class="border-gray-300 dark:border-gray-700" />
                        <div class="grid grid-cols-3 gap-4 text-xs" v-if="spellSlots.length > 0">
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col px-1 py-2 bg-white rounded-lg dark:bg-gray-800" v-for="(slot, index) in spellSlots.slice(0, 3)" :key="index">
                                    <span class="">Level {{ slot.level }}</span>
                                    <div class="flex items-center">
                                        <input class="mr-2 lineInput" max="4" min="0" type="number" :auth="checkUser" v-model="slot.total" />
                                        <input type="checkbox" @change="slot.expanded += $event.target.checked ? 1 : -1" v-for="i in slot.total" :key="i" :checked="slot.expanded >= i"
                                            class="inline-flex items-center justify-center w-3 h-3 mr-1 text-indigo-500 bg-white border border-gray-300 rounded-[2px] cursor-pointer dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900">
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col px-1 py-2 bg-white rounded-lg dark:bg-gray-800" v-for="(slot, index) in spellSlots.slice(3, 6)" :key="index">
                                    <span class="">Level {{ slot.level }}</span>
                                    <div class="flex items-center">
                                        <input class="mr-2 lineInput" max="4" min="0" type="number" :auth="checkUser" v-model="slot.total" />
                                        <input type="checkbox" @change="slot.expanded += $event.target.checked ? 1 : -1" v-for="i in slot.total" :key="i" :checked="slot.expanded >= i"
                                            class="inline-flex items-center justify-center w-3 h-3 mr-1 text-indigo-500 bg-white border border-gray-300 rounded-[2px] cursor-pointer dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900">
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col px-1 py-2 bg-white rounded-lg dark:bg-gray-800" v-for="(slot, index) in spellSlots.slice(6, 9)" :key="index">
                                    <span class="">Level {{ slot.level }}</span>
                                    <div class="flex items-center">
                                        <input class="mr-2 lineInput" max="4" min="0" type="number" :auth="checkUser" v-model="slot.total" />
                                        <input type="checkbox" @change="slot.expanded += $event.target.checked ? 1 : -1" v-for="i in slot.total" :key="i" :checked="slot.expanded >= i"
                                            class="inline-flex items-center justify-center w-3 h-3 mr-1 text-indigo-500 bg-white border border-gray-300 rounded-[2px] cursor-pointer dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <DndSpells v-if="checkUser" @spellSelected="handleSpellSelected" class="col-span-full" />

                <DndCharacterSpells v-if="checkUser" :spells="character.characterData.spells" :character-id="character.characterData.id" @spellRemoved="handleSpellRemoved" class="col-span-full" />
            </div>

            <!-- Settings -->
             <div class="flex flex-col p-4 bg-white rounded-lg md:col-span-2 dark:bg-gray-800" v-show="tabs[5].active" :key="tabs[5].id">
                <div class="flex flex-col items-start gap-1">
                    <span class="font-semibold">Settings</span>
                    <div class="flex items-center gap-2">
                        <Switch v-model="character.characterData.is_public"/>
                        <span class="text-xs">Public</span>
                    </div>
                </div>
             </div>
        </transition-group>

        <!-- Bottom -->
        <div class="fixed left-0 z-40 w-full px-2 bottom-2" v-if="checkUser">
            <div class="flex gap-2 p-4 bg-white bg-opacity-50 border border-gray-300 rounded-lg dark:bg-opacity-10 dark:border-gray-800 backdrop-blur-md">
                <div class="grid w-full grid-cols-6 gap-2 sm:grid-cols-12">
                    <button type="button" class="text-red-600 bg-red-100 generalButton" @click="deleteModalShow = true;">
                        <i class="text-xs fa-solid fa-trash"></i>
                        <span class="hidden sm:block">Sil</span>
                    </button>
                    <!-- <button type="button" class="col-span-2 col-start-3 text-amber-600 bg-amber-100 generalButton" @click="openMore = !openMore">
                        <i class="fa-solid fa-note-sticky"></i>
                        <span class="hidden sm:block">Notlar</span>
                    </button> -->
                    <button type="button" class="col-span-2 col-start-5 text-indigo-600 bg-indigo-100 generalButton" @click="zarModalShow = true;">
                        <i class="text-xs fa-solid fa-dice"></i>
                        <span class="hidden sm:block">Zar</span>
                    </button>
                    <button type="button" class="col-start-2 row-start-2 sm:row-start-1 sm:col-start-8 text-neutral-600 bg-neutral-100 generalButton" @click="copyUrl">
                        <i class="text-xs fa-solid fa-share" v-show="!copied"></i>
                        <i class="text-xs fa-solid fa-check" v-show="copied"></i>
                    </button>
                    <button class="w-full col-span-6 col-start-1 row-start-1 text-green-600 bg-green-100 sm:col-start-9 sm:col-span-4 generalButton" type="submit">
                        <MiniLoader :show="saveLoading" radius="4" />
                        <i class="fa-solid fa-save" v-show="!saveLoading"></i>
                        <span class="hidden sm:block">Kaydet</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Notes -->
    <div class="fixed top-0 left-0 w-full h-full bg-gray-800/30 dark:bg-gray-900/50" v-show="openMore" @click.self="openMore = false">
        <transition name="slide-fade">
            <div class="absolute top-0 right-0 w-4/5 h-full overflow-scroll transition-all duration-300 ease-in bg-white shadow-xl dark:bg-gray-800 lg:w-1/3" v-show="openMore">
                <div class="h-full p-4">
                    <button type="button" class="absolute flex items-center justify-center w-6 h-6 rounded-full text-sky-600 bg-sky-100 right-2 top-2" @click="openMore = false">
                        <i class="text-[11px] fa-solid fa-x"></i>
                    </button>
                    <div class="h-full mt-4">
                        <label for="notes" class="">Notes</label>
                        <TextAreaInput id="notes" :auth="checkUser" v-model="character.characterData.notes" class="w-full h-[calc(100%-124px)]" rows="15" />
                    </div>
                    <!-- <div class="pb-40 mt-6">
                        <Roll></Roll>
                    </div> -->
                </div>
            </div>
        </transition>
    </div>

    <!-- Delete Modal -->
    <Modal :show="deleteModalShow">
        <div class="">
            <div class="relative px-6 pt-6 mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Karakteri Sil
                </h2>
                <button type="button" class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full top-6 right-6 dark:bg-gray-900 dark:text-white hoverEffect"
                    @click="deleteModalShow = false;">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>
            <div class="px-6 my-6 dark:text-gray-200">
                "{{ character.characterData.name }}" karakterini silmek istediğinize emin misiniz?
            </div>
            <div class="flex items-center justify-between px-6 py-4 bg-gray-100 dark:bg-gray-800">
                <button type="button" class="px-4 py-2 rounded bg-sky-200 text-sky-700 hoverEffect h-[42px] flex gap-1 items-center justify-center" @click="deleteModalShow = false;">
                    <span>Vazgeç</span>
                </button>
                <button type="button" class="px-4 py-2 rounded bg-red-200 text-red-700 hoverEffect h-[42px] flex gap-1 items-center justify-center"
                    @click.once="deleteCharacter(character.characterData.id)">
                    <span>Sil</span>
                    <MiniLoader :show="deleteLoad" radius="4" />
                </button>
            </div>
        </div>
    </Modal>

    <!-- Zar Modal -->
    <Modal :show="zarModalShow">
        <div class="p-6">
            <div class="relative mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Zar At
                </h2>
                <button type="button" class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect"
                    @click="zarModalShow = false;">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>
            <div class="my-6 dark:text-gray-200">
                <Roll type="2"></Roll>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import DndWeapons from '@/Components/DndWeapons.vue';
import DndCharacterWeapons from '@/Components/DndCharacterWeapons.vue';
import DndSpells from '@/Components/DndSpells.vue';
import DndCharacterSpells from '@/Components/DndCharacterSpells.vue';
import MiniLoader from '@/Components/MiniLoader.vue';
import Modal from '@/Components/Modal.vue';
import Roll from '@/Components/Roll.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import TextCounter from '@/Components/TextCounter.vue';
import TextInput from '@/Components/TextInput.vue';
import Switch from '@/Components/Switch.vue';
import Checkbox from '@/Components/Checkbox.vue';

import toast from '@/Stores/toast';
import { router, useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import nProgress from 'nprogress';
import { computed, onMounted, watch } from 'vue';
import { ref } from 'vue';
const props = defineProps({
    character: {
        type: Object,
    }
})
const page = usePage();
const classes = ref(page.props.classes);
console.log(classes.value);

const abilities = ref([]);

const proficiencies = ref({
    armor: {},
    weapons: {},
    tools: {}
});
const armorTrainings = ref({
    light: false,
    medium: false,
    heavy: false,
    shield: false
})
const spellcastingAbility = computed(() => {
    return character.characterData.spellcasting_ability ? abilities.value.find(ability => ability.ability_name == character.characterData.spellcasting_ability) : null;
})
const spellSlots = ref({})
console.log(props.character);
onMounted(() => {
    abilities.value = JSON.parse(props.character.abilities.abilities);
    const parsedProficiencies = JSON.parse(props.character.abilities.proficiencies);
    proficiencies.value.armor = parsedProficiencies.find(proficiency => proficiency.name == 'Armor');
    proficiencies.value.weapons = parsedProficiencies.find(proficiency => proficiency.name == 'Weapons');
    proficiencies.value.tools = parsedProficiencies.find(proficiency => proficiency.name == 'Tools');
    console.log(abilities.value);
    console.log(proficiencies.value);

    armorTrainings.value = {
        light: proficiencies.value.armor.proficiencies.includes('light'),
        medium: proficiencies.value.armor.proficiencies.includes('medium'),
        heavy: proficiencies.value.armor.proficiencies.includes('heavy'),
        shield: proficiencies.value.armor.proficiencies.includes('shield')
    }

    character.characterData.abilities.heroic_inspiration = props.character.abilities.heroic_inspiration == 1 ? true : false;


    if (props.character.success_death_save > 0) {
        for (let index = 0; index < props.character.success_death_save; index++) {
            successDeathSaves.value[index].checked = true;
        }
    }
    if (props.character.fail_death_save > 0) {
        for (let index = 0; index < props.character.fail_death_save; index++) {
            failDeathSaves.value[index].checked = true;
        }
    }

    spellSlots.value = JSON.parse(props.character.spell_slots);
    fetchProperties();
})

const checkUser = computed(() => {
    return page.props.auth.user && page.props.auth.user.id == props.character.user_id;
})

const saveLoading = ref(false);
const copied = ref(false);

const character = useForm({ characterData: props.character, abilities: JSON.parse(props.character.abilities.abilities), proficiencies: JSON.parse(props.character.abilities.proficiencies) });
const updateCharacter = async () => {
    nProgress.start()
    saveLoading.value = true;
    updateArmorTraining();
    character.characterData.spell_slots = JSON.stringify(spellSlots.value);
    // character.skills.skills_data = JSON.stringify(skills_data.value);
    character.post('/dnd/character-update', {
        preserveScroll: true,
        onSuccess: (success) => {
            // console.log(success);
        },
        onError: (error) => {
            // console.log(error);
            let keys = Object.keys(error)
            for (let index = 0; index < keys.length; index++) {
                errors.value.push(error[keys[index]]);
            }
        },
        onFinish: () => {
            saveLoading.value = false;
            nProgress.done()
        }
    });
}

// AutoSaves
const autoSaveInfo = setInterval(() => {
    toast.add({
        type: 'warning', message: "Kardeş bayadır kaydete basmadın! 2 dakika içinde autosave alınacaktır."
    });
}, 300000);

const autoSave = setInterval(() => {
    updateCharacter();
}, 500000);

const tabs = ref([
    { id: 0, name: "Character Info", active: true },
    { id: 1, name: "Abilities", active: false },
    { id: 2, name: "Feats", active: false },
    { id: 3, name: "Equipment", active: false },
    { id: 4, name: "Spells", active: false },
    { id: 5, name: "Settings", active: false }
])
const openMore = ref(false);
const deleteModalShow = ref(false);
const zarModalShow = ref(false);
const deleteLoad = ref(false);
const zarLoad = ref(false);
const errors = ref([]);


const successDeathSaves = ref([
    { checked: false },
    { checked: false },
    { checked: false }
]);
const failDeathSaves = ref([
    { checked: false },
    { checked: false },
    { checked: false }
]);
function countChecked() {
    // Herhangi bir değişiklikte seçili checkbox sayısını hesaplar
    character.characterData.success_death_save = successDeathSaves.value.filter(checkbox => checkbox.checked).length;
    character.characterData.fail_death_save = failDeathSaves.value.filter(checkbox => checkbox.checked).length;
    // console.log(character.characterData);
}

function getModifier(score) {
    switch (true) {
        case (score == 3):
            return "-4";
        case (score >= 4 && score <= 5):
            return "-3";
        case (score >= 6 && score <= 7):
            return "-2";
        case (score >= 8 && score <= 9):
            return "-1";
        case (score >= 10 && score <= 11):
            return "0";
        case (score >= 12 && score <= 13):
            return "+1";
        case (score >= 14 && score <= 15):
            return "+2";
        case (score >= 16 && score <= 17):
            return "+3";
        case (score >= 18 && score <= 19):
            return "+4";
        case (score >= 20 && score <= 21):
            return "+5";
        case (score >= 22 && score <= 23):
            return "+6";
        case (score >= 24 && score <= 25):
            return "+7";
        case (score >= 26 && score <= 27):
            return "+8";
        case (score >= 28 && score <= 29):
            return "+9";
        case (score >= 30):
            return "+10";
        default:
            return "+0";
    }
}

function updateArmorTraining() {
    // Herhangi bir değişiklikte seçili checkbox sayısını hesaplar
    proficiencies.value.armor.proficiencies = Object.keys(armorTrainings.value)
        .filter(key => armorTrainings.value[key])
        .join(', ');
    character.proficiencies = JSON.stringify(Object.values(proficiencies.value));
}

function getLength(data) {
    if (data == null) {
        return "0";
    }
    return data.length.toString();
}
const copyUrl = async () => {
    try {
        const currentUrl = window.location.href;
        await navigator.clipboard.writeText(currentUrl);
        copied.value = true;
        toast.add({
            type: 'success', message: "Panoya Kopyalandı!"
        });
        setTimeout(() => {
            copied.value = false;
        }, 2000);
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
};

// Delete
const deleteForm = useForm({
    id: ''
});
function deleteCharacter(id) {
    nProgress.start();
    deleteLoad.value = true;

    deleteForm.id = id;

    deleteForm.post('/dnd/character-delete', {
        preserveScroll: true,
        onSuccess: (success) => {
            // console.log(success);
            deleteModalShow.value = false;
            setTimeout(() => {
                router.visit("/dashboard");
            }, 100);
        },
        onError: (error) => {
            // console.log(error);
            let keys = Object.keys(error)
            for (let index = 0; index < keys.length; index++) {
                errors.value.push(error[keys[index]]);
            }
        },
        onFinish: () => {
            deleteLoad.value = false;
            nProgress.done();
        }
    })
}

const featIdCounter = ref(1);
const classFeatureIdCounter = ref(1);
const speciesTraitIdCounter = ref(1);

const addFeat = () => {
    character.characterData.features.feats.push({ id: featIdCounter.value++, name: "", description: "" });
};

const removeFeat = (index) => {
    character.characterData.features.feats.splice(index, 1);
};

const addClassFeature = () => {
    character.characterData.features.class_features.push({ id: classFeatureIdCounter.value++, name: "", description: "" });
};

const removeClassFeature = (index) => {
    character.characterData.features.class_features.splice(index, 1);
};

const addSpeciesTrait = () => {
    character.characterData.features.species_traits.push({ id: speciesTraitIdCounter.value++, name: "", description: "" });
};

const removeSpeciesTrait = (index) => {
    character.characterData.features.species_traits.splice(index, 1);
};

const handleWeaponSelected = async (weapon) => {
    try {
        await axios.post('/dnd/character-weapon-add', {
            character_id: character.characterData.id,
            weapon_id: weapon.id
        });
        toast.add({ type: 'success', message: 'Weapon added successfully' });
        character.characterData.weapons.push(weapon);
    } catch (error) {
        toast.add({ type: 'error', message: 'Failed to add weapon' });
    }
};

const handleWeaponRemoved = (weaponId) => {
    character.characterData.weapons = character.characterData.weapons.filter(weapon => weapon.id !== weaponId);
};

const handleSpellSelected = async (spell) => {
    try {
        await axios.post('/dnd/character-spell-add', {
            character_id: character.characterData.id,
            spell_id: spell.id
        });
        toast.add({ type: 'success', message: 'Spell added successfully' });
        character.characterData.spells.push(spell);
    } catch (error) {
        toast.add({ type: 'error', message: 'Failed to add spell' });
    }
};

const handleSpellRemoved = (spellId) => {
    character.characterData.spells = character.characterData.spells.filter(spell => spell.id !== spellId);
};

const properties = ref([]);

const fetchProperties = async () => {
    try {
        const response = await axios.get('/dnd/weapon-properties');
        properties.value = response.data;
    } catch (error) {
        toast.add({ type: 'error', message: 'Failed to fetch properties' });
    }
};
</script>

<style>
.lineInput {
    @apply bg-transparent p-0 border-t-transparent border-x-transparent border-b-gray-300 focus:outline-none focus:ring-0 focus:border-x-transparent focus:border-t-transparent focus:border-b-indigo-500 leading-none;
}
</style>