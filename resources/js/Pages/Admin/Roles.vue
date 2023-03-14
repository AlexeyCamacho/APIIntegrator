<script setup>
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import CreateButton from '@/Components/Buttons/CreateButton.vue';
import EditButton from '@/Components/Buttons/EditButton.vue';
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';

defineProps({ roles: Array })

</script>

<template>
    <AdminPanel>
        <div class="flex flex-row justify-between">
            <h2 class="p-4 text-lg">Управление ролями</h2>
            <div class="px-4 self-center">
                <CreateButton :href="route('role.create')">Добавить</CreateButton>
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
                        <div>
                            <EditButton></EditButton>
                        </div>
                        <div>
                            <DeleteButton></DeleteButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminPanel>
</template>
