<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import {
    printerFilters,
    defaultPrinterFilters,
} from '@/Data/printerFilters'

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({ ...defaultPrinterFilters }),
    },
    selectedCategory: {
        type: Number,
        default: null,
    },
})

const selectedFilters = ref({ ...props.filters })

watch(
    () => props.filters,
    (filters) => {
        selectedFilters.value = { ...filters }
    },
    { deep: true },
)

const applyFilters = () => {
    const params = {}

    if (props.selectedCategory !== null) {
        params.category = props.selectedCategory
    }

    for (const option of printerFilters) {
        const value = selectedFilters.value[option.key]

        if (value !== null && value !== undefined) {
            params[option.key] = value
        }
    }

    router.get('/', params, {
        preserveScroll: true,
    })
}

const resetFilters = () => {
    selectedFilters.value = { ...defaultPrinterFilters }

    applyFilters()
}
</script>

<template>
    <section class="mx-auto max-w-lg rounded-2xl border border-gray-100 bg-white p-6 text-center shadow-sm sm:p-8">
        <h2 class="text-lg font-semibold text-gray-900">
            Ничего не найдено
        </h2>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Попробуйте изменить параметры фильтрации.
        </p>

        <div class="mt-6 text-left">
            <p class="mb-4 text-sm font-medium text-gray-900">
                Возможности устройства
            </p>

            <div class="space-y-4">
                <label
                    v-for="option in printerFilters"
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
        </div>

        <div class="mt-6 flex flex-col gap-3">
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
                Сбросить фильтры
            </button>
        </div>
    </section>
</template>
