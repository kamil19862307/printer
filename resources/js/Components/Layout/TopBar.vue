<script setup>
import { ref } from 'vue'
import {
    Bars3Icon,
    ChevronDownIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'

defineProps({
    categories: {
        type: Array,
        required: true,
    },
})

const isMenuOpen = ref(false)

const selectedCategory = ref(null)

const selectCategory = (categoryId) => {
    selectedCategory.value = categoryId
    isMenuOpen.value = false
}
</script>

<template>
    <header
        class="sticky top-0 z-20 border-b border-gray-100 bg-white"
    >
        <div class="flex items-center gap-3 px-5 py-4">

            <!-- Бургер -->
            <button
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition hover:bg-gray-100"
                @click="isMenuOpen = !isMenuOpen"
            >
                <XMarkIcon
                    v-if="isMenuOpen"
                    class="h-7 w-7 text-gray-900"
                />

                <Bars3Icon
                    v-else
                    class="h-7 w-7 text-gray-900"
                />
            </button>

            <!-- Категории — десктоп -->
            <div
                class="hidden flex-1 gap-3 overflow-x-auto no-scrollbar md:flex"
            >
                <!-- Все -->
                <button
                    class="whitespace-nowrap rounded-xl border px-5 py-2.5 text-base font-medium transition"
                    :class="
                        selectedCategory === null
                            ? 'border-blue-500 text-blue-600'
                            : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-50'
                    "
                    @click="selectCategory(null)"
                >
                    Все
                </button>

                <!-- Категории из БД -->
                <button
                    v-for="category in categories"
                    :key="category.id"
                    class="whitespace-nowrap rounded-xl border px-5 py-2.5 text-base font-medium transition"
                    :class="
                        selectedCategory === category.id
                            ? 'border-blue-500 text-blue-600'
                            : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-50'
                    "
                    @click="selectCategory(category.id)"
                >
                    {{ category.name }}
                </button>
            </div>

            <!-- Фильтр — десктоп -->
            <button
                class="hidden items-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 font-medium transition hover:bg-gray-50 md:flex"
                @click="isMenuOpen = !isMenuOpen"
            >
                <ChevronDownIcon class="h-5 w-5" />

                Фильтры
            </button>
        </div>

        <!-- Мобильное меню -->
        <div
            v-if="isMenuOpen"
            class="border-t border-gray-100 bg-white px-5 py-4 md:hidden"
        >
            <div class="flex flex-col gap-2">

                <div class="mb-2 text-sm font-medium text-gray-500">
                    Категория
                </div>

                <!-- Все -->
                <button
                    class="flex items-center rounded-xl px-4 py-3 text-left font-medium transition"
                    :class="
                        selectedCategory === null
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-900 hover:bg-gray-50'
                    "
                    @click="selectCategory(null)"
                >
                    Все
                </button>

                <!-- Категории из БД -->
                <button
                    v-for="category in categories"
                    :key="category.id"
                    class="flex items-center rounded-xl px-4 py-3 text-left font-medium transition"
                    :class="
                        selectedCategory === category.id
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-900 hover:bg-gray-50'
                    "
                    @click="selectCategory(category.id)"
                >
                    {{ category.name }}
                </button>

                <div class="my-2 border-t border-gray-100"></div>

                <button
                    class="flex items-center justify-between rounded-xl px-4 py-3 text-left font-medium text-gray-900 transition hover:bg-gray-50"
                    @click="isMenuOpen = false"
                >
                    <span>Фильтры</span>

                    <ChevronDownIcon class="h-5 w-5" />
                </button>
            </div>
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
