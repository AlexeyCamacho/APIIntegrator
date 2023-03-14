<script setup>
import IconBase from '@/Components/Icons/IconBase.vue';
</script>

<template>
    <button class="hover:border-warning-500 hover:border-2 hover:bg-gray-50 text-gray-800
    font-semibold py-2 px-4 border border-gray-400 rounded" v-tooltip="'Редактировать'">
        <div class="flex flex-row gap-x-1">
            <IconBase :name="'Edit'" :size="4"></IconBase>
            <slot></slot>
        </div>
    </button>
</template>


