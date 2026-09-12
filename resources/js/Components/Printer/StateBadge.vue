<script setup>
defineProps({
    state: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <span
        class="inline-flex w-fit rounded-full bg-sky-100 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-sky-700"
    >
        {{ state }}
    </span>
</template>
