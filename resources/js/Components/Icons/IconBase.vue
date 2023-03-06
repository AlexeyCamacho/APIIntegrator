<script setup>

const props = defineProps(['name']);
import IconBuildings from '@/Components/Icons/IconBuildings.vue';
import IconHome from '@/Components/Icons/IconHome.vue';
import IconPerson from '@/Components/Icons/IconHome.vue';
import IconPersonGear from '@/Components/Icons/IconPersonGear.vue';
import IconBuildingsGear from '@/Components/Icons/IconBuildingsGear.vue';
import IconPersonVcard from '@/Components/Icons/IconPersonVcard.vue';

</script>

<template>
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
        <IconBuildings v-if="props.name === 'Buildings'"></IconBuildings>
        <IconHome v-if="props.name === 'Home'"></IconHome>
        <IconPerson v-if="props.name === 'Person'"></IconPerson>
        <IconPersonGear v-if="props.name === 'PersonGear'"></IconPersonGear>
        <IconBuildingsGear v-if="props.name === 'BuildingsGear'"></IconBuildingsGear>
        <IconPersonVcard v-if="props.name === 'PersonVcard'"></IconPersonVcard>
    </svg>
</template>
