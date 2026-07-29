<script setup>
import { computed } from 'vue'
import printerStates from '@/constants/printerStates'

const props = defineProps({
    state: {
        type: String,
        required: true,
    },
})

const current = computed(() => {
    return printerStates[props.state] ?? printerStates.used
})
</script>

<template>
    <span
        class="inline-flex w-fit rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide"
        :class="current.classes"
    >
        {{ current.label }}
    </span>
</template>
