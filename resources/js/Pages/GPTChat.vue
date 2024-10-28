<template>

    <Head title="DND Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">DND GPT</h2>
        </template>
        <div class="py-4 sm:py-12">
            <div class="mx-auto max-w-7xl">
                <div class="p-4 sm:rounded-lg md:p-8 dark:bg-gray-800">
                    <div class="mb-4 header">
                        Sohbet Başlat
                    </div>
                    <div>
                        <div class="flex flex-col gap-3 pb-4">
                            <div class="p-2 text-xs text-red-500 rounded bg-red-500/50" v-if="hataMesaji.length > 0">
                                {{ hataMesaji }}
                            </div>
                            <div class="flex flex-col items-stretch">
                                <textarea class="generalInput" maxlength="300" v-model="message" placeholder="Sorun nedir?" :disabled="conversation.length >= 20"></textarea>
                                <TextCounter maxlength="300" :value="message.length" />
                            </div>
                            <button v-if="conversation.length < 20" type="button" @click="sendMessage" class="flex items-center justify-center gap-1 px-4 py-2 text-indigo-700 bg-indigo-200 rounded hoverEffect"
                                :disabled="messageLoading">
                                <span>
                                    Gönder
                                </span>
                                <i class="fa-regular fa-paper-plane" v-show="!messageLoading"></i>
                                <MiniLoader :show="messageLoading" radius="4" />
                            </button>
                            <div class="space-x dark:text-gray-400">
                                <span>
                                    Kalan Hakkınız:
                                </span>
                                <span class="font-semibold text-amber-600">{{ 10 - conversation.length / 2 }}</span>
                                <span class="text-semibold"> / 10</span>
                            </div>
                        </div>
                        <div v-if="conversation.length > 0" class="px-2 border-t border-gray-400">
                            <template v-for="(text, index) in conversation" :key="index">
                                <div class="flex justify-end w-full" v-if="text.role == 'user'">
                                    <div class="flex flex-col items-end">
                                        <div class="dark:text-gray-300">
                                            Siz:
                                        </div>
                                        <div class="max-w-4xl px-3 py-2 bg-stone-200 dark:bg-opacity-85 rounded-[0.75rem_0.75rem_0px_0.75rem]">
                                            {{ text.content }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col mt-4" v-else-if="text.role == 'assistant'">
                                    <div class="dark:text-gray-300">
                                        D&D GPT:
                                    </div>
                                    <div class="max-w-4xl px-3 py-2 bg-indigo-100 dark:bg-indigo-200/90 rounded-[0.75rem_0.75rem_0.75rem_0px]">
                                        {{ text.content }}
                                    </div>
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
import MiniLoader from '@/Components/MiniLoader.vue';
import TextCounter from '@/Components/TextCounter.vue';

const page = usePage();
// console.log(page.props.auth.user);

const message = ref('')
const willSendMsg = ref('');

const conversation = ref([]);
const creativeness = ref(0.7);

const messageLoading = ref(false)
const hataMesaji = ref('');

const sendMessage = async () => {
    conversation.value.push({ role: 'user', content: message.value })
    
    hataMesaji.value = '';
    message.value = '';
    messageLoading.value = true;

    const res = await axios.post('/send-dnd-gpt', {
        message: conversation.value,
        creativeness: creativeness.value
    })
        .then((response) => {
            console.log(response.data);
            const respData = response.data;
            if (!respData.success) {
                hataMesaji.value = respData.data.error.message;
            }
            conversation.value.push(response.data.data.choices[0].message);
        }).catch((error) => {
            console.error('API çağrısında hata oluştu:', error);
        }).finally(() => {
            messageLoading.value = false;
        });
}
</script>

<style></style>