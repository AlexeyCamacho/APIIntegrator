<script setup>
import IconBase from '@/Components/Icons/IconBase.vue';

const props = defineProps({
    tooltip: {
        type: String,
        default: ''
    },
});

const tooltip_ = {
    text: props.tooltip,
    theme: {
        placement: 'top',
    },
};
</script>

<template>
    <button class="hover:border-success-600 hover:border-2 hover:bg-gray-50 text-gray-800
    font-semibold py-2 px-4 border border-gray-400 rounded" type="button" v-tooltip="tooltip_">
        <div class="flex flex-row gap-x-1">
            <IconBase :name="'Checklg'" :size="4"></IconBase>
            <slot></slot>
        </div>
    </button>
</template>


