<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({companies: Array })
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Главная</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="(item, key) in companies" class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-4">
                    <div class="p-6 text-gray-900">{{ item.name }}</div>
                    {{item}}
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
