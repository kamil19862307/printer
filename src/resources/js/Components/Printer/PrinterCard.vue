<script setup>
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
    <article
        class="overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-100"
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

                        <div class="mt-2">
                            <StateBadge :state="printer.state" />
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
</template>
