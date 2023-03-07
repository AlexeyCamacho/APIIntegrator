<script setup>
import EditButton from '@/Components/Buttons/EditButton.vue';

defineProps(['name', 'slug', 'global']);

</script>

<template>
    <div class="flex flex-row justify-between hover:bg-gray-50 p-2">
        <div>
            <div>{{ $props.name }}</div>
            <div class="text-xs">{{ $props.slug }}</div>
        </div>
        <div class="mx-3">
            <EditButton>Редактировать</EditButton>
        </div>
    </div>
</template>
