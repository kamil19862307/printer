<script setup>
import { router } from '@inertiajs/vue3'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

function goBack() {
    window.history.length > 1
        ? router.visit(document.referrer || '/')
        : router.visit('/')
}
</script>

<template>
    <header
        class="sticky top-0 z-30 flex items-center gap-3 border-b border-slate-200 bg-white/90 px-4 py-3 backdrop-blur"
    >
        <button
            @click="goBack"
            class="rounded-full p-2 transition-colors hover:bg-slate-100"
        >
            <ArrowLeftIcon class="h-5 w-5" />
        </button>

        <span class="text-base font-semibold text-slate-900">
            Принтер
        </span>
    </header>
</template>
