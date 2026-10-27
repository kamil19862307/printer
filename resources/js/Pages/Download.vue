<script setup>
import { computed, ref } from 'vue'
import MobileLayout from '@/Components/Layout/MobileLayout.vue'
import TopBar from '@/Components/Layout/TopBar.vue'

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },

    downloads: {
        type: Array,
        required: true,
    },
})

const search = ref('')
const selectedCategory = ref(null)

const filteredDownloads = computed(() => {
    return props.downloads.filter((download) => {
        const query = search.value.trim().toLowerCase()

        const matchesSearch =
            !query ||
            download.name.toLowerCase().includes(query) ||
            (download.description ?? '').toLowerCase().includes(query) ||
            (download.version ?? '').toLowerCase().includes(query) ||
            (download.original_filename ?? '').toLowerCase().includes(query)

        const matchesCategory =
            selectedCategory.value === null ||
            download.download_category_id === selectedCategory.value

        return matchesSearch && matchesCategory
    })
})

function formatFileSize(bytes) {
    if (bytes < 1024 * 1024) {
        return `${(bytes / 1024).toFixed(0)} КБ`
    }

    return `${(bytes / (1024 * 1024)).toFixed(1)} МБ`
}
</script>

<template>
    <MobileLayout>
        <TopBar
            :categories="[]"
            :selected-category="null"
            :filters="{
                usb: null,
                ethernet: null,
                wifi: null,
                duplex: null,
            }"
        />

        <div class="px-4 py-5 sm:px-6">
            <!-- Заголовок -->
            <header class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">
                    Загрузки
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Программы, драйверы и полезные утилиты для ремонта
                    и обслуживания компьютеров и принтеров.
                </p>
            </header>

            <!-- Поиск -->
            <div class="mb-5">
                <label
                    for="download-search"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Поиск программ и драйверов
                </label>

                <input
                    id="download-search"
                    v-model="search"
                    type="search"
                    placeholder="Например, HP, 7-Zip, драйвер..."
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3
                           text-base text-slate-900 outline-none transition
                           placeholder:text-slate-400
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <!-- Категории -->
            <div v-if="categories.length" class="mb-6">
                <h2 class="mb-3 text-sm font-semibold text-slate-700">
                    Категории
                </h2>

                <div class="flex gap-2 overflow-x-auto pb-2">
                    <button
                        type="button"
                        @click="selectedCategory = null"
                        class="shrink-0 rounded-full px-4 py-2 text-sm font-medium transition"
                        :class="selectedCategory === null
                            ? 'bg-blue-600 text-white'
                            : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    >
                        Все
                    </button>

                    <button
                        v-for="category in categories"
                        :key="category.id"
                        type="button"
                        @click="selectedCategory = category.id"
                        class="shrink-0 rounded-full px-4 py-2 text-sm font-medium transition"
                        :class="selectedCategory === category.id
                            ? 'bg-blue-600 text-white'
                            : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    >
                        {{ category.name }}
                    </button>
                </div>
            </div>

            <!-- Количество результатов -->
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">
                    Файлы для скачивания
                </h2>

                <span class="text-sm text-slate-500">
                    {{ filteredDownloads.length }}
                </span>
            </div>

            <!-- Список загрузок -->
            <div v-if="filteredDownloads.length" class="space-y-4">
                <article
                    v-for="download in filteredDownloads"
                    :key="download.id"
                    class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm"
                >
                    <div class="flex items-start gap-3">
                        <!-- Иконка файла -->
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center
                                   rounded-xl bg-blue-50 text-blue-600"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.7"
                                stroke="currentColor"
                                class="h-7 w-7"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V16.5M8.25 2.25v3.375c0 .621.504 1.125 1.125 1.125h3.375"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="break-words text-base font-semibold text-slate-900">
                                {{ download.name }}
                            </h3>

                            <p
                                v-if="download.category"
                                class="mt-1 text-xs font-medium text-blue-600"
                            >
                                {{ download.category.name }}
                            </p>

                            <p
                                v-if="download.description"
                                class="mt-2 whitespace-pre-line text-sm leading-5 text-slate-600"
                            >
                                {{ download.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Информация о файле -->
                    <div class="mt-4 flex flex-wrap gap-x-4 gap-y-2 text-xs text-slate-500">
                        <span v-if="download.version">
                            Версия: {{ download.version }}
                        </span>

                        <span v-if="download.operating_system">
                            ОС: {{ download.operating_system }}
                        </span>

                        <span v-if="download.architecture">
                            {{ download.architecture }}
                        </span>

                        <span>
                            {{ formatFileSize(download.file_size) }}
                        </span>
                    </div>

                    <!-- Кнопка скачивания -->
                    <a
                        :href="`/downloads/${download.slug}/file`"
                        class="mt-4 flex w-full items-center justify-center gap-2
                               rounded-xl bg-blue-600 px-4 py-3
                               text-sm font-semibold text-white
                               transition hover:bg-blue-700
                               active:scale-[0.99]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 16.5v2.25c0 .621.504 1.125 1.125 1.125h15.75c.621 0 1.125-.504 1.125-1.125V16.5M7.5 10.5 12 15m0 0 4.5-4.5M12 15V3"
                            />
                        </svg>

                        Скачать
                    </a>
                </article>
            </div>

            <!-- Ничего не найдено -->
            <div
                v-else
                class="rounded-2xl border border-dashed border-slate-300
                       bg-slate-50 px-5 py-10 text-center"
            >
                <h3 class="font-semibold text-slate-800">
                    Ничего не найдено
                </h3>

                <p class="mt-2 text-sm leading-5 text-slate-500">
                    Попробуйте изменить поисковый запрос или выбрать другую категорию.
                </p>

                <button
                    v-if="search || selectedCategory !== null"
                    type="button"
                    @click="search = ''; selectedCategory = null"
                    class="mt-4 rounded-lg bg-white px-4 py-2 text-sm font-medium
                           text-blue-600 ring-1 ring-slate-200 transition
                           hover:bg-slate-100"
                >
                    Сбросить фильтры
                </button>
            </div>
        </div>
    </MobileLayout>
</template>
