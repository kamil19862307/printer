<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

import MobileLayout from '@/Components/Layout/MobileLayout.vue'
import PrinterGallery from '@/Components/Printer/PrinterGallery.vue'
import PrinterFeatures from '@/Components/Printer/PrinterFeatures.vue'
import StateBadge from '@/Components/Printer/StateBadge.vue'
import BackBar from '@/Components/Layout/BackBar.vue'

import printers from '@/mock/printers'

const page = usePage()

const printer = computed(() => {
    return printers.find(
        item => item.id === Number(page.props.printerId)
    )
})
</script>

<template>
    <MobileLayout>

        <BackBar />

        <div
            v-if="printer"
            class="pb-10"
        >
            <PrinterGallery
                :images="printer.images"
            />

            <div class="space-y-6 px-5 pb-8 pt-6">

                <h1
                    class="text-3xl font-bold text-gray-900"
                >
                    {{ printer.title }}
                </h1>

                <StateBadge
                    :state="printer.state"
                />

                <div
                    class="text-3xl font-bold text-blue-600"
                >
                    {{ printer.price }} ₽
                </div>

                <PrinterFeatures
                    :printer="printer"
                />

                <div class="rounded-2xl bg-slate-50 p-4">
                    <h2 class="mb-2 text-lg font-semibold">
                        Описание
                    </h2>

                    <p class="leading-7 text-gray-600">
                        {{ printer.description}}
                    </p>
                </div>

            </div>

        </div>

    </MobileLayout>

</template>
