<script setup>

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
</script>

<template>
    <MobileLayout>

        <BackBar
            :title="props.printer.title"
        />

        <div
            class="pb-10"
        >
            <PrinterGallery
                :images="props.printer.images"
            />

            <div class="space-y-12 px-10 pb-8 pt-6">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <h1 class="text-3xl font-bold">
                            {{ props.printer.title }}
                        </h1>

                        <div class="mt-4">
                            <StateBadge :state="props.printer.state" />
                        </div>
                    </div>

                    <div class="flex flex-col items-end">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ props.printer.price }} ₽
                        </div>

<!--                        #TODO сделать возможность бронирования аппрата для аутентифицированных пользователей -->
<!--                        <button-->
<!--                            class="mt-5 rounded-xl bg-blue-600 px-5 py-3 text-m font-semibold text-white transition hover:bg-blue-700"-->
<!--                        >-->
<!--                            Забронировать-->
<!--                        </button>-->
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
                        {{ props.printer.description}}
                    </p>
                </div>

            </div>

        </div>

    </MobileLayout>

</template>
