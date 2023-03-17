<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SaveButton from '@/Components/Buttons/SaveButton.vue';
import { computed } from "vue";

const props = defineProps({ permissions: Array, categories: Object })

const form = useForm({
    name: null,
    slug: null,
    permissions: [],
});

const categoriesPermissions = computed(() => {
    let categoryPermissions = {};
    for (let key in props.categories) {
        categoryPermissions[key] = [];
    }

    props.permissions.forEach(function(element, key){
        let action = element.slug.split(/-(.*)/s)[0];
        let essence = element.slug.split(/-(.*)/s)[1];

        categoryPermissions[essence].push(action);
    });
});

const updateRole = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
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
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <div class="relative mt-2 rounded-md shadow-sm mb-4">
                            <InputLabel for="name" value="Название" />
                            <TextInput
                                id="name"
                                ref="currentPasswordInput"
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
                                ref="currentPasswordInput"
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
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <SaveButton :disabled="form.processing">Сохранить</SaveButton>

                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Сохранено.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </AdminPanel>
</template>



