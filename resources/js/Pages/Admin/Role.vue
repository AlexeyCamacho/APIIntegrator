<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SaveButton from '@/Components/Buttons/SaveButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import {computed, ref} from "vue";

const props = defineProps({ permissions: Array, categories: Object, actions: Object })

const nameInput = ref(null);
const slugInput = ref(null);

const form = useForm({
    name: null,
    slug: null,
    global: false,
    globalPermissions: [],
    localPermissions: [],
});

const categoriesPermissions = computed(() => {
    let categoryPermissions = {};
    for (let key in props.categories) {
        categoryPermissions[key] = {global: 0, permissions: []};
    }

    props.permissions.forEach(function(element, key){
        let action = element.slug.split(/-(.*)/s)[0];
        let essence = element.slug.split(/-(.*)/s)[1];

        categoryPermissions[essence].permissions.push({
            name: action,
            id: element.id
        });

        categoryPermissions[essence].global = element.global;
    });

    return categoryPermissions;
});

const updateRole = () => {
    form.post(route('role.store'), {
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
};
</script>


<template>
    <AdminPanel>
        <h2 class="p-4 text-lg">Создание/Обновление роли</h2>
        <div class="p-4">
            <form @submit.prevent="updateRole">
                <div class="grid md:grid-cols-3 grid-cols-1 gap-3">
                    <div class="p-2 shadow bg-slate-100 border-t-4 border-red-500 rounded">
                        <div class="mt-2 mb-4">
                            <InputLabel for="name" value="Название" />
                            <TextInput
                                id="name"
                                ref="nameInput"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="name"
                            />
                            <p class="text-xs text-gray-600">
                                Пример: Администратор
                            </p>

                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>
                        <div class="mt-2 mb-4">
                            <InputLabel for="slug" value="Наименование" />

                            <TextInput
                                id="slug"
                                ref="slugInput"
                                v-model="form.slug"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="slug"
                            />

                            <p class="text-xs text-gray-600">
                                Пример: admin
                            </p>

                            <InputError :message="form.errors.slug" class="mt-2" />

                        </div>
                        <div>
                            <Checkbox :checked="form.global"
                                      :value="form.global"
                                      id="global"
                                      v-model="form.global"
                                      class="mr-2"></Checkbox>
                            <InputLabel for="global" :value="'Глобальная роль'" />
                        </div>
                    </div>
                    <template v-for="(item, key) in categoriesPermissions" >
                        <Transition>
                        <div v-if="item.global == form.global" class="p-2 shadow bg-slate-100 border-t-4 border-cyan-500 rounded">
                            <div class="font-medium">{{ props.categories[key] }}</div>
                            <div v-for="(item1, key1) in item.permissions">
                                <Checkbox :checked="form.globalPermissions"
                                          :value="item1.id"
                                          :id="item1.name + '-' + key"
                                          v-model="form.globalPermissions"
                                          class="mr-2"
                                          v-if="item.global">
                                </Checkbox>

                                <Checkbox :checked="form.localPermissions"
                                          :value="item1.id"
                                          :id="item1.name + '-' + key"
                                          v-model="form.localPermissions"
                                          class="mr-2"
                                          v-if="!item.global">

                                </Checkbox>
                                <InputLabel :for="item1.name + '-' + key" :value="props.actions[item1.name]" />
                            </div>
                        </div>
                        </Transition>
                    </template>
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

<style scoped>

.v-enter-active
{
    transition: opacity .5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

</style>




