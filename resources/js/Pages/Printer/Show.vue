<script setup>
import { ref, computed } from 'vue'
import MobileLayout from '@/Components/Layout/MobileLayout.vue'
import PrinterGallery from '@/Components/Printer/PrinterGallery.vue'
import PrinterFeatures from '@/Components/Printer/PrinterFeatures.vue'
import StateBadge from '@/Components/Printer/StateBadge.vue'
import BackBar from '@/Components/Layout/BackBar.vue'

const props = defineProps({
    printer: {
        type: Object,
        required: true,
    },
})

const activeImageIndex = ref(0)

const activeImage = computed(() => {
    return props.printer.images[activeImageIndex.value]
})

const downloadFileName = computed(() => {
    const brand = props.printer.brand
        .trim()
        .toLowerCase()
        .replace(/\s+/g, '_')

    const model = props.printer.model
        .trim()
        .toLowerCase()
        .replace(/\s+/g, '_')

    return `${brand}_${model}_${activeImageIndex.value + 1}.webp`
})
</script>

<template>
    <MobileLayout>

        <BackBar
            :title="props.printer.title"
        />

        <div class="pb-10">

            <PrinterGallery
                :images="props.printer.images"
                @update:active-index="activeImageIndex = $event"
            />

            <div class="space-y-12 px-10 pb-8 pt-6">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <h1 class="text-3xl font-bold">
                            {{ props.printer.title }}
                        </h1>

                        <div class="mt-4 flex items-center gap-3">
                            <StateBadge :state="printer.state" />

                            <span class="text-sm font-medium text-gray-500">
                                Пробег: {{ printer.pages_printed }} стр.
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col items-end">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ props.printer.price }} ₽
                        </div>

                        <a
                            v-if="activeImage"
                            :href="activeImage"
                            :download="downloadFileName"
                            class="mt-3 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 active:scale-95"
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
                                    d="M12 3v12m0 0 4-4m-4 4-4-4m-5 8h18"
                                />
                            </svg>

                            Скачать фото
                        </a>
                    </div>

                </div>

                <PrinterFeatures
                    :printer="printer"
                />

                <div class="rounded-2xl bg-slate-50 p-4">
                    <h2 class="mb-2 text-lg font-semibold">
                        Описание
                    </h2>

                    <p class="leading-7 text-gray-600">
                        {{ props.printer.description }}
                    </p>
                </div>

            </div>

        </div>

    </MobileLayout>
</template>
