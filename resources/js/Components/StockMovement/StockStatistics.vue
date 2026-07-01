<script setup>
import Card from '../Global/Card.vue'
import { stockStats } from '../../Config/stockStats.js'

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    activeFilter: {
        type: String,
        default: 'all',
    },
})

defineEmits(['filter'])
</script>

<template>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <Card
            v-for="stat in stockStats"
            :key="stat.key"
            :label="stat.label"
            :value="stats[stat.valueKey] ?? 0"
            :description="stat.description"
            :icon="stat.icon"
            :active="activeFilter === stat.filter"
            @click="$emit('filter', stat.filter)"
        />
    </div>
</template>