<template>
    <div class="flex flex-col items-center">
        <div class="flex w-full max-w-2xl gap-1 mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">
            <span>Roll</span>
            <div v-if="diceResults.length > 0" class="text-blue-600 dark:text-blue-400">
                
                ({{ (diceResults[4] > 0 ? '+':'') + diceResults[4] }})
            </div>
        </div>
        <div class="grid grid-cols-[auto_auto] sm:grid-cols-[auto_100px] gap-4 max-w-2xl">
            <div class="grid grid-cols-2 gap-2 sm:gap-6 hover:cursor-pointer" @click="rollFate">
                <template v-for="(result, index) in diceResults.slice(0,4)" :key="index">
                    <div class="overflow-hidden rounded-2xl">
                        <img :src="diceImg(result)" alt="" class="w-full">
                    </div>
                </template>
            </div>
            <div>
                <div class="w-full text-gray-900 border-b border-gray-300 dark:text-gray-100 dark:border-gray-600">History</div>
                <div class="flex flex-col text-purple-600 dark:text-purple-500">
                    <div v-for="(history,index) in resultHistory" :key="index">
                        {{ history }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import plusDice from '@/assets/dices/positive.png'
import minusDice from '@/assets/dices/negative.png'
import neutralDice from '@/assets/dices/neutral.png'

const diceResults = ref([-1, 1, 0, 0, 0]);
const resultHistory = ref([]);

function rollFate() {
    let interval = setInterval(() => {
        diceResults.value = [];

        for (let i = 0; i < 4; i++) {
            // Roll a fate dice
            const roll = Math.floor(Math.random() * 3) - 1;
            diceResults.value.push(roll);
        }
        
        diceResults.value.push(0);
        for (let index = 0; index < 4; index++) {
            diceResults.value[4] = diceResults.value[4] + diceResults.value[index];
        }
    }, 50);

    setTimeout(() => {
        clearInterval(interval);
        resultHistory.value.length > 0 ? resultHistory.value.unshift(diceResults.value[4]) : resultHistory.value.push(diceResults.value[4]) ;
    }, 1000);

}
function diceImg(result) {
    switch (result) {
        case -1:
            return minusDice;
            break;
        case 1:
            return plusDice;
            break;
    
        default:
            return neutralDice;
            break;
    }
}

</script>

<style></style>