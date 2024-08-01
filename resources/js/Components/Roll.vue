<template>
    <div v-show="props.type == '1'" class="flex flex-col items-center">
        <div class="flex w-full max-w-2xl gap-1 mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">
            <span>Roll</span>
            <div v-if="diceResults.length > 0" class="text-blue-600 dark:text-blue-400">

                ({{ (diceResults[4] > 0 ? '+' : '') + diceResults[4] }})
            </div>
        </div>
        <div class="grid grid-cols-[auto_auto] sm:grid-cols-[auto_100px] gap-4 max-w-2xl">
            <div class="grid grid-cols-2 gap-2 sm:gap-6 hover:cursor-pointer" @click="rollFate"  ref="dynamicHeightElement">
                <template v-for="(result, index) in diceResults.slice(0, 4)" :key="index">
                    <div class="overflow-hidden rounded-2xl">
                        <img :src="diceImg(result)" alt="" class="w-full invert dark:invert-0 hue-rotate-[160deg] grayscale-[0.4] dark:grayscale-0 dark:hue-rotate-[340deg] dark:brightness-125">
                    </div>
                </template>
            </div>
            <div class="overflow-y-scroll max-h-[70vw] md:max-h-[30vw] ">
                <div class="w-full text-gray-900 border-b border-gray-300 dark:text-gray-100 dark:border-gray-600">History</div>
                <div class="flex flex-col text-purple-600 dark:text-purple-500">
                    <div v-for="(history, index) in resultHistory" :key="index">
                        {{ history }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-show="props.type == '2'" class="flex flex-col items-center">
        <div class="flex w-full max-w-2xl gap-1 mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">
            <span>Roll</span>
            <div v-if="diceResults.length > 0" class="text-blue-600 dark:text-blue-400">

                ({{ (diceResults[4] > 0 ? '+' : '') + diceResults[4] }})
            </div>
        </div>
        <div class="flex flex-col w-full gap-4">
            <div class="grid grid-cols-4 gap-2 sm:gap-6 hover:cursor-pointer" @click="rollFate"  ref="dynamicHeightElement">
                <template v-for="(result, index) in diceResults.slice(0, 4)" :key="index">
                    <div class="overflow-hidden rounded-2xl">
                        <img :src="diceImg(result)" alt="" class="w-full invert dark:invert-0 hue-rotate-[160deg] grayscale-[0.4] dark:grayscale-0 dark:hue-rotate-[340deg] dark:brightness-125">
                    </div>
                </template>
            </div>
            <div class="flex flex-col max-w-xl pb-4 overflow-x-scroll">
                <div class="w-full text-gray-900 border-b border-gray-300 dark:text-gray-100 dark:border-gray-600">History</div>
                <div class="flex gap-4 px-2 text-purple-600 dark:text-purple-500">
                    <div v-for="(history, index) in resultHistory" :key="index">
                        {{ history }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue';
import plusDice from '@/assets/dices/positive.png'
import minusDice from '@/assets/dices/negative.png'
import neutralDice from '@/assets/dices/neutral.png'

const props = defineProps({
    type: {
        type: String,
        default: "1"
    }
})

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
        resultHistory.value.length > 0 ? resultHistory.value.unshift(diceResults.value[4]) : resultHistory.value.push(diceResults.value[4]);
    }, 300);

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

// Elemanı referans almak için bir ref oluşturun
const dynamicHeightElement = ref(null);

// Elemanın yüksekliğini saklamak için bir reaktif değişken oluşturun
const elementHeight = ref(0);

// Bileşen monte edildiğinde elemanın yüksekliğini hesaplayın
// ResizeObserver kullanarak elemanın yüksekliğini izleyin
onMounted(() => {
    elementHeight.value = dynamicHeightElement.value.offsetHeight;
});

watch(dynamicHeightElement, (newHeight) => {
    elementHeight.value = newHeight.offsetHeight;
//   console.log('Element yüksekliği değişti:', newHeight.offsetHeight);
});

</script>

<style></style>