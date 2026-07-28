<script setup>
import {
    Bars3Icon,
    ChevronDownIcon,
} from '@heroicons/vue/24/outline'

const categories = [
    'Все',
    'МФУ',
    'Принтеры',
]
</script>

<template>
    <header
        class="sticky top-0 z-20 bg-white border-b border-gray-100"
    >
        <div class="flex items-center gap-3 px-5 py-4">

            <!-- Меню -->
            <button
                class="flex h-11 w-11 items-center justify-center rounded-xl transition hover:bg-gray-100"
            >
                <Bars3Icon class="h-7 w-7 text-gray-900" />
            </button>

            <!-- Категории -->
            <div class="flex flex-1 gap-3 overflow-x-auto no-scrollbar">

                <button
                    v-for="(item, index) in categories"
                    :key="item"
                    class="whitespace-nowrap rounded-xl border px-5 py-2.5 text-base font-medium transition"
                    :class="
                        index === 0
                            ? 'border-blue-500 text-blue-600'
                            : 'border-gray-200 bg-white text-gray-900'
                    "
                >
                    {{ item }}
                </button>

            </div>

            <!-- Фильтр -->
            <button
                class="flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 font-medium transition hover:bg-gray-50"
            >
                <ChevronDownIcon class="h-5 w-5" />

                Фильтры
            </button>

        </div>
    </header>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}

.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
