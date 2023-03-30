<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import EditButton from '@/Components/Buttons/EditButton.vue';
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
import {computed} from "vue";
import { usePage } from '@inertiajs/vue3'

defineProps({companies: Array })

function canEdit(permissons) {
    return permissons.includes('edit-company');

}


</script>

<template>
    <Head title="Главная" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Главная</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="(item, key) in companies" class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-4">
                    <div class="p-6 text-gray-900 flex flex-row justify-between">
                        <div>
                            {{ item.name }}
                        </div>
                        <div class="flex flex-row">
                            <div v-if="$page.props.auth.permissions.includes('edit-company-admin') || canEdit(item.permissions)">
                                <EditButton @click="gotoEditRole(item.id)"></EditButton>
                            </div>
                            <div v-if="$page.props.auth.permissions.includes('delete-company-admin')">
                                <DeleteButton @click="confirmRoleDeletion(item.id, item.name)"></DeleteButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
