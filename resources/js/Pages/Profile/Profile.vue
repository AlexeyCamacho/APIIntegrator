<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {computed} from "vue";

const props = defineProps({
    user: Object,
    companies: Object,
})

const regDate = computed(() => {
    var d = new Date(props.user.created_at);
    return d.getDate() + '.' + d.getMonth() + '.' + d.getFullYear();
});

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
                    <div class="flex flex-row border-green-300 border-t-2 bg-gray-200">
                        <div class="basis-1/4">1</div>
                        <div>1</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

