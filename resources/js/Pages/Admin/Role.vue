<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminPanel from '@/Pages/Admin/AdminPanel.vue';

const form = reactive({
    name: null,
    slug: null,
    permissions: [],
})

function submit() {
    router.post('admin/role/', form)
}
</script>


<template>
    <AdminPanel>
        <h2 class="p-4 text-lg">Создание/Обновление роли</h2>
        <div class="p-4">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Название</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input type="text" name="name" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Администратор">
                        </div>
                    </div>
                </div>
    <!--            <label for="first_name">First name:</label>-->
    <!--            <input id="first_name" v-model="form.first_name" />-->
    <!--            <label for="last_name">Last name:</label>-->
    <!--            <input id="last_name" v-model="form.last_name" />-->
    <!--            <label for="email">Email:</label>-->
    <!--            <input id="email" v-model="form.email" />-->
    <!--            <button type="submit">Submit</button>-->
            </form>
        </div>
    </AdminPanel>
</template>



