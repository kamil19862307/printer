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

        <BackBar
            :title="printer.title"
        />

        <div
            v-if="printer"
            class="pb-10"
        >
            <PrinterGallery
                :images="printer.images"
            />

            <div class="space-y-12 px-10 pb-8 pt-6">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <h1 class="text-3xl font-bold">
                            {{ printer.title }}
                        </h1>

                        <div class="mt-4">
                            <StateBadge :state="printer.state" />
                        </div>
                    </div>

                    <div class="flex flex-col items-end">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ printer.price }} ₽
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
                        {{ printer.description}}
                    </p>
                </div>

            </div>

        </div>

    </MobileLayout>

</template>
