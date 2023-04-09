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
import {computed, ref, onMounted, onBeforeMount, reactive} from "vue";

const props = defineProps({
    globalRoles: Array,
    localRoles: Array,
    companies: Array,

    user: Object,
    userCompanies: Array,
    userRole: null,
})

const loginInput = ref(null);
const emailInput = ref(null);

const companyInput = ref(null);
const roleCompanyInput = ref(null);

const globalRolesOptions = [];
const localRolesOptions = [];
const selectCompany = reactive([]);


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
        form.login = props.user.name;
        form.email = props.user.email;
        form.role = props.userRole;
    }

    if (props.userCompanies) {
        props.userCompanies.forEach(function(item, index, array) {
            form.companies.push({
                company: item.id,
                role: item.role.id,
                companyName: item.name,
                roleName: item.role.name,
            });
            selectCompany.splice(selectCompany.findIndex(x => x.value == item.id), 1);
        });
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

const addCompanySave = () => {
    if (!addCompany.company) {
        addCompany.reset('company');
        companyInput.value.focus();
    }
    if (!addCompany.role) {
        addCompany.reset('role');
        roleCompanyInput.value.focus();
    }

    if (addCompany.company && addCompany.role) {
        form.companies.push({
            company: addCompany.company,
            role: addCompany.role,
            companyName: props.companies.find(x => x.id == addCompany.company).name,
            roleName: props.localRoles.find(x => x.id == addCompany.role).name,
        });

        selectCompany.splice(selectCompany.findIndex(x => x.value == addCompany.company), 1);
        addCompany.reset();
    }
};

const addCompanyDelete = (companyId, companyName) => {
    form.companies.splice(form.companies.findIndex(x => x.company == companyId), 1);

    selectCompany.push({
        value: Number(companyId),
        name: companyName,
    });
    addCompany.reset();

};

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
                            <InputLabel for="login" value="Логин" />
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
                            <InputLabel for="email" value="Email" />

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
                            <InputLabel for="role" value="Роль на сайте:" />

                            <Select :options="globalRolesOptions" v-model="form.role" id="role"></Select>

                            <InputError :message="form.errors.role" class="mt-2" />

                        </div>
                    </div>
                    <div class="basis-2/3 p-2 shadow bg-slate-100 border-t-4 border-cyan-500 rounded">
                        <span>Компании</span>
                        <div class="flex flex-col gap-2 divide-y divide-blue-600 my-3">
                            <div v-for="(item, key) in form.companies" class="flex flex-row gap-1 justify-between">
                                <div class="flex flex-row gap-2">
                                    <div>{{ item.companyName }}</div>
                                    <div>-</div>
                                    <div>{{ item.roleName }}</div>
                                </div>
                                <div>
                                    <button type="button" class="hover:text-red-700 hover:underline underline-offset-2"
                                    @click="addCompanyDelete(item.company, item.companyName)">Удалить</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex md:flex-row flex-col justify-between my-2 gap-1" v-show="addCompany.show">
                            <div class="flex flex-row gap-3 basis-3/4">
                                <div>
                                    <InputLabel for="company" value="Компания:" />
                                    <Select :options="selectCompany" v-model="addCompany.company" id="company" ref="companyInput"></Select>
                                </div>
                                <div>
                                    <InputLabel for="companyRole" value="Роль в компании:" />
                                    <Select :options="localRolesOptions" v-model="addCompany.role" id="companyRole" ref="roleCompanyInput"></Select>
                                </div>
                            </div>
                            <div class="flex flex-row gap-2">
                                <div class="self-end">
                                    <SimpleSaveButton @click="addCompanySave"></SimpleSaveButton>
                                </div>
                                <div class="self-end">
                                    <DeleteButton @click="addCompany.reset()"></DeleteButton>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row justify-end">
                            <div>
                                <CreateButton @click="addCompany.show = !addCompany.show" v-show="!addCompany.show && selectCompany.length">Добавить</CreateButton>
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





