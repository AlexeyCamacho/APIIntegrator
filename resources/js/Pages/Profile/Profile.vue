<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    companies: Object,
})


</script>


<template>
    <Head title="Профиль" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Профиль</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex flex-row gap-4">
                        <div class="flex flex-col basis-1/4 gap-4">
                            <div class="bg-slate-200 rounded p-2 shadow drop-shadow">
                                <img
                                    src="https://sun9-56.userapi.com/impg/sJB2W2dkGHiBhdYtLGwKuxi73t90-IZhjc4B3w/C_5On-8L24Q.jpg?size=1200x1600&quality=95&sign=9959112d5d3d4d2ccc2a1aa2622bea7a&type=album"
                                    class="w-full aspect-square object-cover rounded shadow-lg mx-auto"
                                    alt="Avatar" />
                                <div class="my-2">
                                    <div class="text-xl">{{ props.user.name }}</div>
                                    <div class="text-sm">{{ props.user.email }}</div>
                                </div>
                            </div>
                            <div class="bg-slate-200 rounded p-2 shadow drop-shadow">
                                <div class="my-2">
                                    <div>Статус:</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col grow gap-4">
                            <div class="bg-slate-200 rounded p-2 shadow drop-shadow">
                                <div class="text-xl">Компании</div>
                                <div v-for="(item, key) in props.companies" class="my-3 flex flex-row justify-between
                                    border-2 border-blue-400 border-t-blue-700 border-l-blue-700 p-2 rounded-lg ">
                                    <div>{{ item.name }}</div>
                                </div>
                            </div>
                            <div class="bg-slate-200 rounded p-2 shadow drop-shadow">Устройства</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

