<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import CreateButton from '@/Components/Buttons/CreateButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SaveButton from '@/Components/Buttons/SaveButton.vue';
import Select from "@/Components/Select.vue";
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
import SimpleSaveButton from '@/Components/Buttons/SimpleSaveButton.vue';
import {computed, ref, onMounted, onBeforeMount} from "vue";

const props = defineProps({
    globalRoles: Array,
    localRoles: Array,
    companies: Array,
    user: Object,
    userCompanies: Array,
})

const loginInput = ref(null);
const emailInput = ref(null);
const globalRolesOptions = [];
const localRolesOptions = [];
const selectCompany = [];


onBeforeMount(() => {
    props.globalRoles.forEach(function(item, index, array) {
        globalRolesOptions.push({
            value: item.id,
            name: item.name,
        });
    });

    props.localRoles.forEach(function(item, index, array) {
        localRolesOptions.push({
            value: item.id,
            name: item.name,
        });
    });

    props.companies.forEach(function(item, index, array) {
        selectCompany.push({
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
    role: 3,
    companies: []
});

const addCompany = useForm({
    company: null,
    role: null,
    show: false
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
                <div class="flex flex-col gap-3 md:flex-row">
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

                            <Select :options="globalRolesOptions" v-model="form.role"></Select>

                            <InputError :message="form.errors.role" class="mt-2" />

                        </div>
                    </div>
                    <div class="basis-2/3 p-2 shadow bg-slate-100 border-t-4 border-cyan-500 rounded">
                        <span>Компании</span>
                        <div class="flex flex-row justify-between my-2" v-show="addCompany.show">
                            <div class="flex flex-row gap-3 basis-3/4">
                                <div>
                                    <Select :options="selectCompany" v-model="addCompany.company"></Select>
                                </div>
                                <div>
                                    <Select :options="localRolesOptions" v-model="addCompany.role"></Select>
                                </div>
                            </div>
                            <div class="flex flex-row gap-2">
                                <div class="self-center">
                                    <SimpleSaveButton></SimpleSaveButton>
                                </div>
                                <div class="self-center">
                                    <DeleteButton @click="addCompany.show = !addCompany.show"></DeleteButton>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row justify-end">
                            <div>
                                <CreateButton @click="addCompany.show = !addCompany.show" v-show="!addCompany.show">Добавить</CreateButton>
                            </div>
                        </div>
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





