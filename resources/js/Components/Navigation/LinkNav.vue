<script setup>

import {computed} from "vue";

const props = defineProps(['title', 'href', 'active']);

const classes = computed(() =>
    props.active
        ? 'text-gray-800 border-indigo-500 bg-gray-50'
        : 'border-transparent'
);

</script>

<template>
    <li>
        <a :href="href" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-100 text-gray-600 hover:text-gray-800 border-l-4 hover:border-indigo-500 pr-6"
        :class="classes">
            <span class="inline-flex justify-center items-center ml-4">
                <slot></slot>
            </span>
            <span class="ml-2 text-sm tracking-wide truncate">{{ title }}</span>
        </a>
    </li>
</template>
