<script setup>
import { router } from '@inertiajs/vue3'
import { ArrowLeftIcon, HomeIcon } from '@heroicons/vue/24/outline'

function goBack() {
    const referrer = document.referrer

    if (referrer) {
        try {
            const referrerUrl = new URL(referrer)
            const currentUrl = new URL(window.location.href)

            if (referrerUrl.origin === currentUrl.origin) {
                window.history.back()
                return
            }
        } catch {
            // Если адрес некорректный, перейдём в каталог.
        }
    }

    router.visit('/')
}

function goHome() {
    router.visit('/')
}

defineProps({
    title: String,
})
</script>

<template>
    <header
        class="sticky top-0 z-30 flex items-center justify-between gap-3 border-b border-slate-200 bg-white/90 px-5 py-4 backdrop-blur"
    >
        <!-- Кнопка назад -->
        <button
            type="button"
            @click="goBack"
            class="flex shrink-0 items-center gap-1 rounded-xl px-2 py-2 transition hover:bg-slate-100"
        >
            <ArrowLeftIcon class="h-6 w-6" />
            <span class="text-xl font-medium">
                Назад
            </span>
        </button>

        <!-- Заголовок -->
        <h1
            class="absolute left-1/2 max-w-[40%] -translate-x-1/2 truncate text-base font-semibold"
        >
            {{ title }}
        </h1>

        <!-- Кнопка на главную -->
        <button
            type="button"
            @click="goHome"
            class="flex shrink-0 items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
        >
            <HomeIcon class="h-5 w-5" />
            <span class="hidden sm:inline">
                На главную
            </span>
        </button>
    </header>
</template>
