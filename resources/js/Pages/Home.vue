<script setup>
import MobileLayout from '@/Components/Layout/MobileLayout.vue'
import TopBar from "@/Components/Layout/TopBar.vue"
import PrinterCard from "@/Components/Printer/PrinterCard.vue"

defineProps({
    printers: {
        type: Array,
        required: true,
    },
})

</script>

<template>
    <MobileLayout>

        <TopBar />

        <div class="space-y-6 p-5">

            <PrinterCard
                v-for="printer in printers"
                :key="printer.id"
                :printer="printer"
            />

        </div>

    </MobileLayout>
</template>
