import { computed, onScopeDispose, ref } from 'vue';

export const DICE_TYPES = [2, 4, 6, 8, 10, 12, 20, 100];
export const MAX_POOL_SIZE = 12;
export const MAX_MODIFIER = 99;
const HISTORY_LIMIT = 30;

const ROLL_CYCLE_MS = 70;
const SETTLE_BASE_MS = 600;
const SETTLE_STAGGER_MS = 140;

let dieUid = 0;

function randomFace(sides) {
    return Math.floor(Math.random() * sides) + 1;
}

/**
 * Zar atma mekaniğinin tüm durumu ve mantığı. UI'dan bağımsızdır;
 * DiceRoller.vue dışında da (ör. programatik atışlar için) kullanılabilir.
 */
export function useDiceRoller() {
    // [{ id, sides, value, settled }]
    const pool = ref([]);
    const modifier = ref(0);
    const isRolling = ref(false);
    const hasResult = ref(false);
    const history = ref([]);

    let cycleInterval = null;
    let pendingTimeouts = [];

    // { [sides]: adet } — seçici rozetleri ve formül için
    const poolCounts = computed(() => {
        const counts = {};
        for (const die of pool.value) {
            counts[die.sides] = (counts[die.sides] ?? 0) + 1;
        }
        return counts;
    });

    // Ör: "2d6 + 1d20 + 3"
    const formula = computed(() => {
        const dice = DICE_TYPES.filter((sides) => poolCounts.value[sides])
            .map((sides) => `${poolCounts.value[sides]}d${sides}`)
            .join(' + ');
        if (!dice) return '';
        if (modifier.value === 0) return dice;
        return `${dice} ${modifier.value > 0 ? '+' : '-'} ${Math.abs(modifier.value)}`;
    });

    const total = computed(() =>
        pool.value.reduce((sum, die) => sum + (die.value ?? 0), 0) + modifier.value
    );

    const isPoolFull = computed(() => pool.value.length >= MAX_POOL_SIZE);

    function addDie(sides) {
        if (isRolling.value || isPoolFull.value || !DICE_TYPES.includes(sides)) return;
        pool.value.push({ id: ++dieUid, sides, value: null, settled: false });
        pool.value.sort((a, b) => a.sides - b.sides);
        hasResult.value = false;
    }

    function removeDie(sides) {
        if (isRolling.value) return;
        for (let i = pool.value.length - 1; i >= 0; i--) {
            if (pool.value[i].sides === sides) {
                pool.value.splice(i, 1);
                hasResult.value = false;
                return;
            }
        }
    }

    function clearPool() {
        if (isRolling.value) return;
        pool.value = [];
        hasResult.value = false;
    }

    function setModifier(value) {
        const numeric = Math.trunc(Number(value) || 0);
        modifier.value = Math.min(MAX_MODIFIER, Math.max(-MAX_MODIFIER, numeric));
    }

    function nudgeModifier(delta) {
        setModifier(modifier.value + delta);
    }

    function stopTimers() {
        if (cycleInterval) {
            clearInterval(cycleInterval);
            cycleInterval = null;
        }
        pendingTimeouts.forEach(clearTimeout);
        pendingTimeouts = [];
    }

    /**
     * Havuzdaki zarları atar. Animasyon süresince değerler döner,
     * zarlar sırayla durur; hepsi durunca sonuç objesiyle resolve olur.
     */
    function roll() {
        if (isRolling.value || pool.value.length === 0) return Promise.resolve(null);

        isRolling.value = true;
        hasResult.value = false;
        pool.value.forEach((die) => { die.settled = false; });

        cycleInterval = setInterval(() => {
            for (const die of pool.value) {
                if (!die.settled) die.value = randomFace(die.sides);
            }
        }, ROLL_CYCLE_MS);

        return new Promise((resolve) => {
            pool.value.forEach((die, index) => {
                const settleAt = SETTLE_BASE_MS + index * SETTLE_STAGGER_MS + Math.random() * 80;
                pendingTimeouts.push(setTimeout(() => {
                    die.value = randomFace(die.sides);
                    die.settled = true;
                }, settleAt));
            });

            const finishAt = SETTLE_BASE_MS + pool.value.length * SETTLE_STAGGER_MS + 200;
            pendingTimeouts.push(setTimeout(() => {
                stopTimers();
                isRolling.value = false;
                hasResult.value = true;

                const result = {
                    formula: formula.value,
                    rolls: pool.value.map((die) => ({ sides: die.sides, value: die.value })),
                    modifier: modifier.value,
                    total: total.value,
                };
                history.value.unshift(result);
                if (history.value.length > HISTORY_LIMIT) history.value.pop();
                resolve(result);
            }, finishAt));
        });
    }

    onScopeDispose(stopTimers);

    return {
        pool,
        poolCounts,
        modifier,
        isRolling,
        hasResult,
        history,
        formula,
        total,
        isPoolFull,
        addDie,
        removeDie,
        clearPool,
        setModifier,
        nudgeModifier,
        roll,
    };
}
