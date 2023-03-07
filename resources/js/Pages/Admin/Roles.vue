<script setup>
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import EditButton from '@/Components/Buttons/EditButton.vue';
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';

defineProps({ roles: Array })

</script>

<template>
    <AdminPanel>
        <div class="p-4">
            <h3>Управление ролями</h3>
        </div>
        <div class="p-4">
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
