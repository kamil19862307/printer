<script setup>
import { router } from '@inertiajs/vue3'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

function goBack() {
    window.history.length > 1
        ? router.visit(document.referrer || '/')
        : router.visit('/')
}

defineProps({
    title: String,
})
</script>

<template>
    <header
        class="sticky top-0 z-30 flex items-center gap-3 border-b border-slate-200 bg-white/90 px-5 py-4 backdrop-blur"
    >
        <button
            @click="goBack"
            class="flex items-center gap-1 rounded-xl px-2 py-2 transition hover:bg-slate-100"
        >
            <ArrowLeftIcon class="h-6 w-6" />
            <span class="text-xl font-medium">
                Назад
            </span>
        </button>
        <h1
            class="text-xl absolute left-1/2 -translate-x-1/2 max-w-[45%] truncate text-base font-semibold"
        >
            {{ title }}
        </h1>
    </header>
</template>
