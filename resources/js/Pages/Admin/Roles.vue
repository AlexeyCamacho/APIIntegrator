<script setup>
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import CreateButton from '@/Components/Buttons/CreateButton.vue';
import EditButton from '@/Components/Buttons/EditButton.vue';
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import {nextTick, ref} from "vue";
import {useForm} from "@inertiajs/vue3";

defineProps({ roles: Array })
const confirmingRoleDeletion = ref(false);
let roleName = ref('');

const confirmRoleDeletion = (id, name) => {
    confirmingRoleDeletion.value = true;
    form.id = id;
    roleName = name;
};

const gotoEditRole = (id) => {
    window.location.href = route('role.edit', id);
}

const form = useForm({
    id: null,
});

const deleteRole = () => {
    form.delete(route('role.destroy', form.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            setTimeout(() => { form.clearErrors(); }, 2000);
        },
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingRoleDeletion.value = false;
    form.reset();
};

</script>

<template>
    <AdminPanel>
        <div class="flex flex-row justify-between">
            <h2 class="p-4 text-lg">Управление ролями</h2>
            <div class="px-4 self-center" v-if="$page.props.auth.permissions.includes('create-role')">
                <CreateButton :href="route('role.create')">Добавить роль</CreateButton>
            </div>
        </div>
        <div class="px-4">
            <div v-for="(item, key) in $props.roles" class="my-1">
                <div class="flex flex-row justify-between hover:bg-gray-200 p-2 rounded-md">
                    <div>
                        <div>{{ item.name }}</div>
                        <div class="text-xs">{{ item.slug }}</div>
                    </div>
                    <div class="mx-3 flex flex-row gap-2">
                        <div v-if="$page.props.auth.permissions.includes('edit-role')">
                            <EditButton @click="gotoEditRole(item.id)"></EditButton>
                        </div>
                        <div v-if="$page.props.auth.permissions.includes('delete-role')">
                            <DeleteButton @click="confirmRoleDeletion(item.id, item.name)" :tooltip="'Удалить'"></DeleteButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="confirmingRoleDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Вы уверены, что хотите удалить роль {{ roleName }}?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Как только роль будет удалена, она будет отвязана от всех пользвателей, имеющих данную роль.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Отмена </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteRole"
                    >
                        Удалить аккаунт
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
