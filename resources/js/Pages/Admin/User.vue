<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SaveButton from '@/Components/Buttons/SaveButton.vue';
import Select from "@/Components/Select.vue";
import {computed, ref, onMounted, onBeforeMount} from "vue";

const props = defineProps({
    roles: Array,
    user: Object,
})

const loginInput = ref(null);
const emailInput = ref(null);
const rolesOptions = [];

onBeforeMount(() => {
    props.roles.forEach(function(item, index, array) {
        rolesOptions.push({
            value: item.id,
            name: item.name,
        });
    });
})

onMounted(() => {
    if (props.user) {
        form.login = props.user.login;
        form.email = props.user.email;
        form.role = props.user.role;
    }
})

const form = useForm({
    login: null,
    email: null,
    role: 3
});

const header = computed(() => {
    return props.user ? 'Обновление' : 'Создание'
});

const updateUser = () => {
    if (!props.user) {
        form.post(route('user.store'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: () => {
                if (form.errors.email) {
                    form.reset('email');
                    emailInput.value.focus();
                }
                if (form.errors.login) {
                    form.reset('login');
                    loginInput.value.focus();
                }
            },
        });

    } else {
        form.put(route('user.update', props.user.id), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: () => {
                if (form.errors.slug) {
                    form.reset('slug');
                    slugInput.value.focus();
                }
                if (form.errors.name) {
                    form.reset('name');
                    nameInput.value.focus();
                }
            },
        });
    }
};
</script>


<template>
    <AdminPanel>
        <h2 class="p-4 text-lg">{{ header }} пользователя.
            <p class="mt-1 text-sm text-gray-600">
                Пароль будет отправлен пользователю на электронную почту.
            </p>
        </h2>
        <div class="p-4">
            <form @submit.prevent="updateUser">
                <div class="flex flex-row gap-3">
                    <div class="p-2 shadow bg-slate-100 border-t-4 border-red-500 rounded basis-1/3">
                        <div class="mt-2 mb-4">
                            <InputLabel for="name" value="Логин" />
                            <TextInput
                                id="login"
                                ref="loginInput"
                                v-model="form.login"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="login"
                            />

                            <InputError :message="form.errors.login" class="mt-2" />
                        </div>
                        <div class="mt-2 mb-4">
                            <InputLabel for="slug" value="Email" />

                            <TextInput
                                id="email"
                                ref="emailInput"
                                v-model="form.email"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="email"
                            />

                            <InputError :message="form.errors.email" class="mt-2" />

                        </div>
                        <div class="mt-2 mb-4">
                            <InputLabel for="slug" value="Роль на сайте:" />

                            <Select :options="rolesOptions" v-model="form.role"></Select>

                            <InputError :message="form.errors.role" class="mt-2" />

                        </div>
                    </div>
                    <div class="basis-2/3 p-2 shadow bg-slate-100 border-t-4 border-cyan-500 rounded">
                        Компании
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-4">
                    <SaveButton :disabled="form.processing">Сохранить</SaveButton>

                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Сохранено.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </AdminPanel>
</template>





