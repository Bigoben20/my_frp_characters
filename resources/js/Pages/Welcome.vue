<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ditto from '@/assets/icons/ditto.png';
import Logo from '@/Components/ApplicationLogo.vue';
import postIt from '@/assets/icons/post-it.png';
import DiceRoller from '@/Components/Dice/DiceRoller.vue';
import Galeri from '@/Components/Galeri.vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    allCharacters: {
        type: Object,
    },
    allDndCharacters: {
        type: Object,
    },
    dndClasses: {
        type: Object,
    },
});

function goToChar(id, system) {
    let url = "";
    switch (system) {
        case 'fate':
            url = "/character-detail/" + id
            break;
        case 'd&d':
            url = "/dnd/character-detail/" + id
            break;

        default:
            url = '/'
            break;
    }
    window.location.href = url;
}

function getClassName(classId) {
    return props.dndClasses.find(classItem => classItem.id == classId).name;
}
</script>

<template>

    <Head title="Welcome" />

    <div class="relative min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900">
        <div class="flex items-center justify-between">
            <div class="z-20 w-1/2 p-6 font-semibold dark:text-gray-400 sm:fixed sm:top-0 sm:left-0 sm:w-fit">
                My Frp Characters
            </div>
            <div v-if="canLogin" class="z-20 w-1/2 p-6 sm:fixed sm:top-0 sm:right-0 text-end sm:w-fit">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Dashboard
                </Link>

                <template v-else>
                    <Link :href="route('login')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Log in
                    </Link>

                    <Link v-if="canRegister" :href="route('register')"
                        class="font-semibold text-gray-600 ms-4 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">
                    Register
                    </Link>
                </template>
            </div>
        </div>

        <div class="p-6 mx-auto max-w-7xl lg:p-8 sm:mt-[72px]">
            <div class="flex items-center justify-center">
                <div class="w-full sm:w-1/2">
                    <!-- <Logo class="w-40 h-40" /> -->
                    <DiceRoller />
                </div>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:gap-8">
                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500">
                        <div>
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 dark:bg-indigo-400/20">
                                <img :src="ditto" alt="" class="w-10 h-10 dark:invert">
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Karakterinizi Yaratın</h2>

                            <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                                Web sitemizde, kendinize özgü karakterler oluşturabilir ve düzenleyebilirsiniz. Adım adım karakterinizi yaratın, özelliklerini belirleyin ve hikayesini oluşturun.
                                Dilerseniz
                                daha sonra karakterinizde değişiklikler yapabilir veya detaylarını düzenleyebilirsiniz.
                            </p>
                        </div>

                        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center w-6 h-6 mx-6 shrink-0 stroke-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg> -->
                    </div>

                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500">
                        <div>
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 dark:bg-indigo-400/20">
                                <img :src="postIt" alt="" class="w-10 h-10 dark:invert">
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Notlarınızı Saklayın</h2>

                            <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                                Sitemizde karakterlerinizle ilgili notlar alabilir ve saklayabilirsiniz. Karakterlerinizi geliştirmek veya hikayelerini detaylandırmak için not alma özelliği sayesinde
                                fikirlerinizi not edebilirsiniz. Bu notlar istediğiniz zaman erişilebilir durumda olacak, böylece karakterlerinizin gelişimini takip etmek daha kolay olacak.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <Galeri/> -->
            <!-- Other DnD Characters -->
            <div class="mt-8">
                <div class="space-y-2 max-w-7xl">
                    <div class="p-4 overflow-hidden bg-white rounded-lg shadow-sm sm:p-6 dark:bg-gray-800">
                        <div class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Other D&D Characters <span class="text-blue-600 dark:text-blue-400">({{ allDndCharacters.total
                                }})</span>
                        </div>
                        <div class="w-full">
                            <table class="w-full text-left table-fixed">
                                <thead class="dark:text-gray-300">
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="px-3 py-1.5 rounded-l w-10">ID</th>
                                        <th class="px-3 py-1.5">Name</th>
                                        <th class="px-3 py-1.5">Level</th>
                                        <th class="px-3 py-1.5">Class</th>
                                    </tr>
                                </thead>
                                <tbody class="dark:text-gray-100">
                                    <tr v-for="character in allDndCharacters.data" :key="character.id" @click="goToChar(character.id, 'd&d')"
                                        class="hover:cursor-pointer hover:bg-gray-100/50 dark:hover:bg-gray-700/20">
                                        <td class="px-3 py-1.5">{{ character.id }}</td>
                                        <td class="px-3 py-1.5 whitespace-nowrap overflow-hidden text-ellipsis">{{ character.name }}</td>
                                        <td class="px-3 py-1.5">
                                            {{ character.level ?? '1' }}
                                        </td>
                                        <td class="px-3 py-1.5">
                                            {{ character.class ? getClassName(character.class) : 'Unknown' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <Pagination :links="allDndCharacters.links" />
                            </div>
                        </div>
                    </div>


                    <div class="p-4 overflow-hidden bg-white rounded-lg shadow-sm sm:p-6 dark:bg-gray-800">
                        <div class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Other Fate Characters <span class="text-blue-600 dark:text-blue-400">({{ allCharacters.total }})</span>
                        </div>
                        <div class="w-full">
                            <table class="w-full text-left table-fixed">
                                <thead class="dark:text-gray-300">
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="px-3 py-1.5 rounded-l w-10">ID</th>
                                        <th class="px-3 py-1.5">User</th>
                                        <th class="px-3 py-1.5">Name</th>
                                        <th class="px-3 py-1.5 rounded-r">High Concept</th>
                                    </tr>
                                </thead>
                                <tbody class="dark:text-gray-100">
                                    <tr v-for="character in allCharacters.data" :key="character.id" @click="goToChar(character.id, 'fate')"
                                        class="hover:cursor-pointer hover:bg-gray-100/50 dark:hover:bg-gray-700/20">
                                        <td class="px-3 py-1.5">{{ character.id }}</td>
                                        <td class="px-3 py-1.5 whitespace-nowrap">{{ character.user.name }}</td>
                                        <td class="px-3 py-1.5 whitespace-nowrap overflow-hidden text-ellipsis">{{ character.name }}</td>
                                        <td class="px-3 py-1.5">
                                            <div class="overflow-hidden text-ellipsis whitespace-nowrap">
                                                {{ character.high_concept }}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <Pagination :links="allCharacters.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center px-6 mt-16 sm:items-center sm:justify-between">
                <div class="text-sm text-center text-gray-500 dark:text-gray-400 sm:text-start">
                    <div class="flex items-center gap-4">
                        <a href="https://github.com/bigoben20"
                            class="inline-flex items-center gap-2 group hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">
                            <i class="fas fa-copyright"></i> <span>2024 Bigoben20</span>
                        </a>
                    </div>
                </div>


                <div class="text-sm text-center text-gray-500 ms-4 dark:text-gray-400 sm:text-end sm:ms-0">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
