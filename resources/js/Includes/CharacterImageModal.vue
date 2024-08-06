<template>
    <button type="button" @click="show = !show" class="px-1 rounded bg-gray-800/80">
        <i class="text-orange-400 fa-solid fa-image"></i>
    </button>

    <!-- Modal -->
    <Modal :show="show">
        <div class="p-6">
            <div class="relative mb-2">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Karakter Resmi
                </h2>
                <button class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-white hoverEffect" @click="show = false;">
                    <i class="text-sm fa-solid fa-x"></i>
                </button>
            </div>
            <div class="flex justify-start gap-2 my-6 dark:text-gray-200" v-if="auth">
                <Textinput :auth="auth" maxlength="300" id="image" v-model="image.imgUrl" class="w-full" placeholder="Url giriniz."/>
                <button class="px-4 py-2 text-green-600 bg-green-200 rounded-md" @click="saveImg">
                    <i class="fa-solid fa-save"></i>
                </button>
            </div>
            <div class="flex justify-center w-full p-6 bg-gray-100 rounded-md dark:bg-gray-700">
                <img :src="image.imgUrl" class="object-cover h-[60vh] rounded-md shadow-md">
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import Textinput from '@/Components/TextInput.vue';
import { onUpdated, ref } from 'vue';
import NProgress from 'nprogress'
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    character: {
        type: Object
    },
    auth: {
        type: Boolean,
        default: true
    }
});
const show = ref(false);
const image = useForm({ id: props.character.id ,imgUrl: props.character.img_url });
const img = ref("");
const errors = ref([]);

function saveImg() {
    NProgress.start();
    image.post('/character-img-update', {
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
            NProgress.done()
        }
    });
}
</script>

<style></style>