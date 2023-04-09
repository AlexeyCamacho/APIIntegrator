<script setup>
import {onMounted, ref} from 'vue';

defineProps(['modelValue', 'options']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <select class="block w-full pl-3 pr-10 py-2 transition duration-100 ease-in-out border rounded-md
        shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50
        disabled:cursor-not-allowed text-black placeholder-gray-400 bg-white border-gray-300 focus:border-blue-500"
        ref="input"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)">
        <option v-for="(item, key) in options" :value="item.value" :key="item.value + item.name">{{ item.name }}</option>
    </select>
</template>
