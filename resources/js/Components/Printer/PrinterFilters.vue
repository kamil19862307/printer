<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import {
    ChevronDownIcon,
    FunnelIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({
            usb: null,
            ethernet: null,
            wifi: null,
            duplex: null,
        }),
    },

    selectedCategory: {
        type: Number,
        default: null,
    },
})

const isOpen = ref(false)

const options = [
    { key: 'duplex', label: 'Дуплекс' },
    { key: 'wifi', label: 'Wi-Fi' },
    { key: 'ethernet', label: 'Ethernet' },
    { key: 'usb', label: 'USB' },
]

const selectedFilters = ref({ ...props.filters })

watch(
    () => props.filters,
    (filters) => {
        selectedFilters.value = { ...filters }
    },
    { deep: true },
)

const activeFiltersCount = () => {
    return Object.values(selectedFilters.value)
        .filter((value) => value !== null && value !== undefined)
        .length
}

const applyFilters = () => {
    const params = {}

    if (props.selectedCategory !== null) {
        params.category = props.selectedCategory
    }

    for (const option of options) {
        const value = selectedFilters.value[option.key]

        if (value !== null && value !== undefined) {
            params[option.key] = value
        }
    }

    router.get('/', params, {
        preserveScroll: true,
        preserveState: true,
        replace: false,
        onSuccess: () => {
            isOpen.value = false
        },
    })
}

const resetFilters = () => {
    selectedFilters.value = {
        usb: null,
        ethernet: null,
        wifi: null,
        duplex: null,
    }

    applyFilters()
}
</script>

<template>
    <div class="relative">
        <!-- Кнопка открытия фильтров -->
        <button
            type="button"
            class="flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 font-medium text-gray-900 transition hover:bg-gray-50"
            :aria-expanded="isOpen"
            @click="isOpen = !isOpen"
        >
            <FunnelIcon class="h-5 w-5" />

            <span>Фильтры</span>

            <span
                v-if="activeFiltersCount() > 0"
                class="flex h-5 min-w-5 items-center justify-center rounded-full bg-blue-600 px-1 text-xs text-white"
            >
                {{ activeFiltersCount() }}
            </span>

            <ChevronDownIcon
                class="h-4 w-4 transition-transform"
                :class="{ 'rotate-180': isOpen }"
            />
        </button>

        <!-- Панель фильтров -->
        <div
            v-if="isOpen"
            class="absolute right-0 top-full z-30 mt-2 w-72 max-w-[calc(100vw-2.5rem)] rounded-2xl border border-gray-100 bg-white p-5 shadow-xl"
        >
            <div class="mb-4 text-sm font-semibold text-gray-900">
                Возможности устройства
            </div>

            <div class="space-y-4">
                <label
                    v-for="option in options"
                    :key="option.key"
                    class="flex cursor-pointer items-center gap-3"
                >
                    <input
                        v-model="selectedFilters[option.key]"
                        type="checkbox"
                        :true-value="1"
                        :false-value="null"
                        class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    />

                    <span class="text-sm text-gray-700">
                        {{ option.label }}
                    </span>
                </label>
            </div>

            <div class="mt-6 flex flex-col gap-2">
                <button
                    type="button"
                    class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-blue-700"
                    @click="applyFilters"
                >
                    Применить
                </button>

                <button
                    type="button"
                    class="w-full rounded-xl px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50"
                    @click="resetFilters"
                >
                    Сбросить
                </button>
            </div>
        </div>
    </div>
</template>
