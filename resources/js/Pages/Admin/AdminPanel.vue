<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VerticalNavigation from '@/Components/Navigation/VerticalNavigation.vue';
import LinkNav from '@/Components/Navigation/LinkNav.vue';
import CategoryNav from '@/Components/Navigation/CategoryNav.vue';
import { Head } from '@inertiajs/vue3';
import IconBase from '@/Components/Icons/IconBase.vue';



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
                    <div class="flex flex-row">
                        <VerticalNavigation>
                            <CategoryNav :title="'Мониторинг'"></CategoryNav>
                            <LinkNav :title="'Компании'" :href="route('dashboard')"><IconBase :name="'Buildings'"></IconBase></LinkNav>
                            <LinkNav :title="'Пользователи'" :href="route('dashboard')"><IconBase :name="'Person'"></IconBase></LinkNav>

                            <CategoryNav :title="'Управление'"></CategoryNav>
                            <LinkNav :title="'Компании'" :href="route('dashboard')"><IconBase :name="'BuildingsGear'"></IconBase></LinkNav>
                            <LinkNav :title="'Пользователи'" :href="route('dashboard')" v-if="$page.props.auth.permissions.includes('view-user')">
                                <IconBase :name="'PersonGear'"></IconBase>
                            </LinkNav>
                            <LinkNav :title="'Роли'" :href="route('role.get')" v-if="$page.props.auth.permissions.includes('view-role')"
                                     :active="route().current('role.get')">
                                <IconBase :name="'PersonVcard'"></IconBase>
                            </LinkNav>
                        </VerticalNavigation>
                        <div class="w-full">
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
