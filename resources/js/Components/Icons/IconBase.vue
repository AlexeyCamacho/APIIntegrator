<script setup>
import IconBuildings from '@/Components/Icons/IconBuildings.vue';
import IconHome from '@/Components/Icons/IconHome.vue';
import IconPerson from '@/Components/Icons/IconHome.vue';
import IconPersonGear from '@/Components/Icons/IconPersonGear.vue';
import IconBuildingsGear from '@/Components/Icons/IconBuildingsGear.vue';
import IconPersonVcard from '@/Components/Icons/IconPersonVcard.vue';
import IconEdit from '@/Components/Icons/IconEdit.vue';
import IconDelete from '@/Components/Icons/IconDelete.vue';
import IconCreate from '@/Components/Icons/IconCreate.vue';
import IconChecklg from '@/Components/Icons/IconChecklg.vue';
import { computed } from 'vue';

const props = defineProps({
    name: {
        type: String,
    },
    size: {
        type: Number,
        default: 5
    },
})

const classes = computed(() => {
    return 'w-' + String(props.size) + ' ' + 'h-' + String(props.size);
});

</script>

<template>
    <svg :class="classes" class="self-center" stroke="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
        <IconBuildings v-if="props.name === 'Buildings'"></IconBuildings>
        <IconHome v-if="props.name === 'Home'"></IconHome>
        <IconPerson v-if="props.name === 'Person'"></IconPerson>
        <IconPersonGear v-if="props.name === 'PersonGear'"></IconPersonGear>
        <IconBuildingsGear v-if="props.name === 'BuildingsGear'"></IconBuildingsGear>
        <IconPersonVcard v-if="props.name === 'PersonVcard'"></IconPersonVcard>
        <IconEdit v-if="props.name === 'Edit'"></IconEdit>
        <IconDelete v-if="props.name === 'Delete'"></IconDelete>
        <IconCreate v-if="props.name === 'Create'"></IconCreate>
        <IconChecklg v-if="props.name === 'Checklg'"></IconChecklg>
    </svg>
</template>
