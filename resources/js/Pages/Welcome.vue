<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ditto from '@/assets/icons/ditto.png';
import Logo from '@/Components/ApplicationLogo.vue';
import postIt from '@/assets/icons/post-it.png';
import Roll from '@/Components/Roll.vue';

defineProps({
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
});
</script>

<template>

    <Head title="Welcome" />

    <div class="relative min-h-screen bg-gray-100 bg-center sm:flex sm:justify-center sm:items-center bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900">
        <div class="flex justify-between w-full p-6 sm:fixed sm:top-0 sm:right-0 text-end">
            <div class="font-semibold dark:text-gray-400">
                My Frp Characters
            </div>
            <div v-if="canLogin">
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

        <div class="p-6 mx-auto max-w-7xl lg:p-8">
            <div class="flex items-center justify-center">
                <div class="sm:w-1/2">
                    <!-- <Logo class="w-40 h-40" /> -->
                    <Roll></Roll>
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
