<script setup>
import PrinterGallery from './PrinterGallery.vue'
import PrinterFeatures from './PrinterFeatures.vue'

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

            <div
                class="mb-5 flex items-end justify-between"
            >
                <h2
                    class="text-4xl font-bold tracking-tight text-gray-900"
                >
                    {{ printer.title }}
                </h2>

                <span
                    class="text-3xl font-bold text-gray-900"
                >
                    {{ printer.price }}
                    ₽
                </span>
            </div>

            <PrinterFeatures
                :printer="printer"
            />

        </div>
    </article>
</template>
