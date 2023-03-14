<script setup>
import IconBase from '@/Components/Icons/IconBase.vue';

const props = defineProps(['href']);
</script>

<template>
    <a class="hover:border-sky-500 hover:border-2 hover:bg-gray-50 text-gray-800
    font-semibold py-2 px-4 border border-gray-400 rounded" type="button" :href="href"
    v-tooltip="{
        text: 'Добавить',
        theme: {
            placement: 'bottom',
        },
    }">
        <div class="flex flex-row gap-x-1">
            <IconBase :name="'Create'" :size="4"></IconBase>
            <slot></slot>
        </div>
    </a>
</template>


