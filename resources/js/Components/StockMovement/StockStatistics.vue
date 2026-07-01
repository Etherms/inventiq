<script setup>
import Card from '../Global/Card.vue'
import { stockStats } from '../../Config/stockStats.js'

defineProps({
    stats: {
        type: Object,
        required: true,
    },
})
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
            :href="stat.href"
        />
    </div>
</template>