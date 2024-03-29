<script setup>
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import CreateButton from '@/Components/Buttons/CreateButton.vue';
import EditButton from '@/Components/Buttons/EditButton.vue';
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {nextTick, ref} from "vue";
import { Link } from '@inertiajs/vue3';
import {useForm} from "@inertiajs/vue3";

defineProps({users: Array })
const confirmingUserDeletion = ref(false);
let userName = ref('');

const confirmUserDeletion = (id, name) => {
    confirmingUserDeletion.value = true;
    form.id = id;
    userName = name;
};

const gotoEditUser = (id) => {
    window.location.href = route('user.edit', id);
}

const form = useForm({
    id: null,
});

const deleteUser = () => {
    form.delete(route('user.destroy', form.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            setTimeout(() => { form.clearErrors(); }, 2000);
        },
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};

</script>

<template>
    <AdminPanel>
        <div class="flex flex-row justify-between">
            <h2 class="p-4 text-lg">Управление пользователями</h2>
            <div class="px-4 self-center" v-if="$page.props.auth.permissions.includes('create-user')">
                <CreateButton :href="route('user.create')">Добавить пользователя</CreateButton>
            </div>
        </div>
        <div class="px-4">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="border-b font-medium dark:border-neutral-500">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Имя</th>
                                    <th scope="col" class="px-6 py-4">Роль</th>
                                    <th scope="col" class="px-6 py-4">Последняя активность</th>
                                    <th scope="col" class="px-6 py-4">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, key) in $props.users"
                                    class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex align-items-center">
                                            <img
                                                src="https://mdbootstrap.com/img/new/avatars/8.jpg"
                                                alt=""
                                                style="width: 45px; height: 45px"
                                                class="rounded-3xl"
                                            />
                                            <div class="ml-3">
                                                <p class="font-bold mb-1">
                                                    <Link :href="route('user.show', item.id)"
                                                        :class="'underline decoration-transparent transition duration-300 ease-in-out hover:decoration-inherit hover:text-lg'"
                                                        v-if="$page.props.auth.permissions.includes('view-user')">
                                                        {{item.name}}
                                                    </Link>
                                                    <span v-else>{{item.name}}</span>
                                                </p>
                                                <p class="text-gray-500 mb-0">{{item.email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div>{{ item.roles[0].name }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">Будет позже</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex flex-row gap-2">
                                            <div v-if="$page.props.auth.permissions.includes('edit-user')">
                                                <EditButton @click="gotoEditUser(item.id)"></EditButton>
                                            </div>
                                            <div v-if="$page.props.auth.permissions.includes('delete-user')">
                                                <DeleteButton @click="confirmUserDeletion(item.id, item.name)"></DeleteButton>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Вы уверены, что хотите удалить пользователя {{ userName }}?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    При удалении пользователя все его компании будут сохранены.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Отмена </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Удалить пользователя
                    </DangerButton>
                </div>
                <div class="flex justify-end mt-2">
                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                        <p v-if="form.hasErrors" class="text-sm text-red-700 self-center">Ошибка при удалении.</p>
                    </Transition>
                </div>
            </div>
        </Modal>
    </AdminPanel>
</template>
