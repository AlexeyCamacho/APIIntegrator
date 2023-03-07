<script setup>
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';
import Role from '@/Components/Role.vue';

defineProps({ roles: Array })

</script>

<template>
    <AdminPanel>
        <div class="p-4">
            <h3>Управление ролями</h3>
        </div>
        <div class="p-4">
            <div v-for="(item, key) in $props.roles" class="my-1">
                <Role :name="item.name" :slug="item.slug" :global="item.global"></Role>
            </div>
        </div>
    </AdminPanel>
</template>
