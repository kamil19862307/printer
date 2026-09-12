<script setup>
import { Link } from '@inertiajs/vue3'
import PrinterGallery from './PrinterGallery.vue'
import PrinterFeatures from './PrinterFeatures.vue'
import StateBadge from './StateBadge.vue'

defineProps({
    printer: {
        type: Object,
        required: true,
    },
})
</script>

<template>

    <Link
        :href="`/printers/${printer.id}`"
        class="block transition-all duration-300"
    >

        <article
            class="block
                    rounded-3xl
                    transition-all
                    duration-300
                    hover:-translate-y-1
                    hover:shadow-2xl
                    active:scale-[0.99]"
        >
            <PrinterGallery
                :images="printer.images"
            />

            <div class="px-6 pt-3 pb-6">

                <div class="mb-5">
                    <div class="flex items-start justify-between gap-4">

                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">
                                {{ printer.title }}
                            </h2>

                            <div class="mt-4 flex items-center gap-3">
                                <StateBadge :state="printer.state" />

                                <span class="text-sm font-medium text-gray-500">
                                    Пробег: {{ printer.pages_printed }} стр.
                                </span>
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-900">
                                {{ printer.price }} ₽
                            </div>
                        </div>

                    </div>
                </div>

                <PrinterFeatures
                    :printer="printer"
                />

            </div>
        </article>
    </Link>
</template>
