<template>
    <div class="flex flex-col w-full gap-4">
        <!-- Zar seçici -->
        <div class="grid grid-cols-4 gap-2 sm:grid-cols-8">
            <div v-for="sides in diceTypes" :key="sides" class="relative">
                <button
                    type="button"
                    class="w-full p-1.5 rounded-lg border border-gray-200 dark:border-gray-700 hoverEffect disabled:opacity-40 disabled:cursor-not-allowed"
                    :disabled="isRolling || isPoolFull"
                    :title="`d${sides} ekle`"
                    @click="addDie(sides)"
                >
                    <DiceFace :sides="sides" :label="`d${sides}`" />
                </button>
                <template v-if="poolCounts[sides]">
                    <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center min-w-[20px] h-5 px-1 text-xs font-semibold text-white bg-indigo-500 rounded-full pointer-events-none">
                        {{ poolCounts[sides] }}
                    </span>
                    <button
                        type="button"
                        class="absolute -bottom-1.5 -right-1.5 flex items-center justify-center w-5 h-5 text-xs text-red-700 bg-red-200 rounded-full hoverEffect disabled:opacity-40"
                        :disabled="isRolling"
                        :title="`d${sides} çıkar`"
                        @click="removeDie(sides)"
                    >
                        <i class="text-[9px] fa-solid fa-minus"></i>
                    </button>
                </template>
            </div>
        </div>

        <!-- Zar tepsisi -->
        <div class="flex items-center justify-center min-h-[92px] p-3 border border-dashed border-gray-300 rounded-lg dark:border-gray-600">
            <TransitionGroup v-if="pool.length" name="dice-tray" tag="div" class="flex flex-wrap items-center justify-center gap-2">
                <div v-for="(die, index) in pool" :key="die.id" class="w-12 sm:w-14">
                    <DiceFace
                        :sides="die.sides"
                        :value="die.value"
                        :rolling="isRolling && !die.settled"
                        :settled="die.settled"
                        :reverse="index % 2 === 1"
                    />
                </div>
            </TransitionGroup>
            <p v-else class="text-sm text-gray-400 dark:text-gray-500">
                Zar eklemek için yukarıdaki zarlara dokun
            </p>
        </div>

        <!-- Kontroller -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-1" title="Ekleme / çıkarma (modifier)">
                <button
                    type="button"
                    class="flex items-center justify-center w-9 h-9 text-gray-700 bg-gray-100 rounded dark:bg-gray-900 dark:text-gray-300 hoverEffect disabled:opacity-40"
                    :disabled="isRolling"
                    @click="nudgeModifier(-1)"
                >
                    <i class="text-xs fa-solid fa-minus"></i>
                </button>
                <input
                    type="text"
                    inputmode="numeric"
                    class="generalInput w-16 h-9 px-1 text-center"
                    :value="modifierDisplay"
                    :disabled="isRolling"
                    aria-label="Modifier"
                    @change="onModifierInput"
                />
                <button
                    type="button"
                    class="flex items-center justify-center w-9 h-9 text-gray-700 bg-gray-100 rounded dark:bg-gray-900 dark:text-gray-300 hoverEffect disabled:opacity-40"
                    :disabled="isRolling"
                    @click="nudgeModifier(1)"
                >
                    <i class="text-xs fa-solid fa-plus"></i>
                </button>
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="button"
                    class="px-3 py-2 rounded bg-gray-100 text-gray-500 dark:bg-gray-900 dark:text-gray-400 hoverEffect disabled:opacity-40"
                    :disabled="isRolling || !pool.length"
                    title="Tepsiyi temizle"
                    @click="clearPool"
                >
                    <i class="fa-solid fa-trash"></i>
                </button>
                <button
                    type="button"
                    class="flex items-center gap-2 px-5 py-2 font-semibold text-white bg-indigo-500 rounded hoverEffectOpacity disabled:opacity-40 disabled:cursor-not-allowed"
                    :disabled="isRolling || !pool.length"
                    @click="onRoll"
                >
                    <i class="fa-solid fa-dice-d20" :class="{ 'animate-rolld20': isRolling }"></i>
                    <span>Zar At</span>
                </button>
            </div>
        </div>

        <!-- Sonuç -->
        <Transition name="dice-result">
            <div v-if="hasResult" class="flex flex-col items-center py-2">
                <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ lastResult?.total }}</div>
                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ lastResult?.formula }}</div>
            </div>
        </Transition>

        <!-- Geçmiş -->
        <div v-if="showHistory && history.length" class="text-sm">
            <div class="pb-1 text-gray-900 border-b border-gray-300 dark:text-gray-100 dark:border-gray-600">
                Geçmiş
            </div>
            <div class="flex flex-col max-h-40 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                <div v-for="(entry, index) in history" :key="index" class="flex items-center justify-between py-1">
                    <span class="text-gray-500 truncate dark:text-gray-400" :title="breakdown(entry)">{{ entry.formula }}</span>
                    <span class="ml-2 font-semibold text-purple-600 dark:text-purple-500">{{ entry.total }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import DiceFace from '@/Components/Dice/DiceFace.vue';
import { DICE_TYPES, useDiceRoller } from '@/Composables/useDiceRoller';

const props = defineProps({
    // Gösterilecek zar tipleri; ör. :dice="[6, 20]" ile daraltılabilir
    dice: { type: Array, default: () => [...DICE_TYPES] },
    showHistory: { type: Boolean, default: true },
});

const emit = defineEmits(['rolled']);

const {
    pool,
    poolCounts,
    modifier,
    isRolling,
    hasResult,
    history,
    isPoolFull,
    addDie,
    removeDie,
    clearPool,
    setModifier,
    nudgeModifier,
    roll,
} = useDiceRoller();

const diceTypes = computed(() => props.dice.filter((sides) => DICE_TYPES.includes(sides)));

const lastResult = ref(null);

const modifierDisplay = computed(() =>
    modifier.value > 0 ? `+${modifier.value}` : `${modifier.value}`
);

function onModifierInput(event) {
    setModifier(event.target.value.replace(/[^\d-]/g, ''));
    // Aynı değere temizlenen girişlerde de görüneni tazele
    event.target.value = modifierDisplay.value;
}

// Geçmiş satırının title'ında zar zar döküm: "d6: 3, d20: 15"
function breakdown(entry) {
    return entry.rolls.map((die) => `d${die.sides}: ${die.value}`).join(', ');
}

async function onRoll() {
    const result = await roll();
    if (!result) return;
    lastResult.value = result;
    emit('rolled', result);
}

// Programatik kullanım için (ör. parent'tan hazır atış tetiklemek)
defineExpose({ addDie, removeDie, clearPool, setModifier, roll });
</script>

<style scoped>
.dice-tray-enter-active,
.dice-tray-leave-active {
    transition: all 0.15s ease;
}
.dice-tray-enter-from,
.dice-tray-leave-to {
    opacity: 0;
    transform: scale(0.5);
}

.dice-result-enter-active {
    transition: all 0.25s ease-out;
}
.dice-result-enter-from {
    opacity: 0;
    transform: translateY(8px) scale(0.9);
}
</style>
