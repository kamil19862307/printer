<script setup>
import MobileLayout from '@/Components/Layout/MobileLayout.vue'
import TopBar from "@/Components/Layout/TopBar.vue"
import PrinterCard from "@/Components/Printer/PrinterCard.vue"

defineProps({
    printers: {
        type: Array,
        required: true,
    },

    categories: {
        type: Array,
        required: true,
    },

    selectedCategory: {
        type: Number,
        default: null,
    },

    filters: {
        type: Object,
        default: () => ({
            usb: null,
            ethernet: null,
            wifi: null,
            duplex: null,
        }),
    },
})

</script>

<template>
    <MobileLayout>

        <TopBar :categories="categories"
                :selected-category="selectedCategory"
                :filters="filters"
        />

        <div class="space-y-6 p-5">

            <PrinterCard
                v-for="printer in printers"
                :key="printer.id"
                :printer="printer"
            />

        </div>

    </MobileLayout>
</template>
