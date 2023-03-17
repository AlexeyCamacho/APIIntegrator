<script setup>
import IconBase from '@/Components/Icons/IconBase.vue';

const props = defineProps({
    href: {
        type: String,
    },
    tooltip: {
        type: String,
        default: ''
    },
});

const tooltip_ = {
    text: props.tooltip,
    theme: {
        placement: 'bottom',
    },
};
</script>

<template>
    <a class="inline-flex items-center px-4 py-2 bg-gray-800
     rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700
     focus:bg-gray-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
     focus:ring-offset-2 transition ease-in-out duration-150" type="button" :href="href" v-if="!props.tooltip">
        <div class="flex flex-row gap-x-1">
            <IconBase :name="'Create'" :size="4"></IconBase>
            <slot></slot>
        </div>
    </a>

    <a class="inline-flex items-center px-4 py-2 bg-gray-800
     rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700
     focus:bg-gray-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500
     focus:ring-offset-2 transition ease-in-out duration-150" type="button" :href="href" v-if="props.tooltip"
    v-tooltip="tooltip_">
        <div class="flex flex-row gap-x-1">
            <IconBase :name="'Create'" :size="4"></IconBase>
            <slot></slot>
        </div>
    </a>
</template>


