<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VerticalNavigation from '@/Components/Navigation/VerticalNavigation.vue';
import LinkNav from '@/Components/Navigation/LinkNav.vue';
import CategoryNav from '@/Components/Navigation/CategoryNav.vue';
import { Head } from '@inertiajs/vue3';
import IconBuildings from '@/Components/Icons/IconBuildings.vue';
</script>

<template>
    <Head title="AdminPanel" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Админ-панель</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <VerticalNavigation>
                        <CategoryNav :title="'Мониторинг'"></CategoryNav>
                        <LinkNav :title="'Компании'" :href="route('dashboard')"><IconBuildings></IconBuildings></LinkNav>
                    </VerticalNavigation>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
