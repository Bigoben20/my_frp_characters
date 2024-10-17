<template>

    <Head title="DND Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">DND GPT</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div>
                    <div class="flex flex-col gap-4 pb-4 border-b border-gray-400">
                        <textarea class="generalInput" v-model="message" placeholder="Bir mesaj yaz..."></textarea>
                        <button type="button" @click="sendMessage" class="px-4 py-2 text-indigo-700 bg-indigo-200 rounded hoverEffect">
                            <span>
                                Gönder
                            </span>
                            <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </div>
                    <div v-if="responses.length > 0" class="mt-4">
                        <div class="flex justify-end w-full">
                            <div class="flex flex-col">
                                <div>
                                    Siz:
                                </div>
                                <div class="max-w-4xl px-3 py-2 bg-stone-200 rounded-xl">
                                    {{ willSendMsg }}
                                </div>
                            </div>
                        </div>
                        <div>
                            D&D GPT:
                        </div>
                        <div class="flex flex-col gap-4 ">
                            <template v-for="text in responses" :key="text.index">
                                <div class="max-w-4xl px-3 py-2 bg-indigo-100 rounded-xl">
                                    {{ text.message.content }}
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Base from '@/Pages/Character/Base.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const page = usePage();
// console.log(page.props.auth.user);

const message = ref('')
const willSendMsg = ref('');
const responses = ref([])
const isSuccess = ref(false)

const sendMessage = async () => {
    willSendMsg.value = message.value;
    const res = await axios.post('/send-dnd-gpt', { 
        message: willSendMsg.value,
        creativeness: 0.7
    })
    .then((response) => {
        console.log(response.data);
        
        responses.value = response.data.data;
    }).catch((error) => {
        console.error('API çağrısında hata oluştu:', error);
    }).finally(() => {
    });
}
</script>

<style></style>