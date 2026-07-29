<script setup>
import {
    WifiIcon,
    ArrowsRightLeftIcon,
    CpuChipIcon,
    GlobeAltIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
    printer: Object,
})

const items = [
    {
        visible: props.printer.usb,
        icon: CpuChipIcon,
        label: 'USB',
    },
    {
        visible: props.printer.wifi,
        icon: WifiIcon,
        label: 'Wi-Fi',
    },
    {
        visible: props.printer.duplex,
        icon: ArrowsRightLeftIcon,
        label: 'Дуплекс',
    },
    {
        visible: props.printer.ethernet,
        icon: GlobeAltIcon,
        label: 'Сеть',
    },
]
</script>

<template>
    <div class="flex flex-wrap gap-2">

        <div
            v-for="item in items.filter(i => i.visible)"
            :key="item.label"
            class="
                inline-flex
                items-center
                gap-2
                rounded-xl
                border
                border-gray-200
                bg-gray-50
                px-3
                py-2"
        >
            <component
                :is="item.icon"
                class="h-6 w-6 text-blue-600"
            />

            <span
                class="text-[13px] font-medium"
            >
                {{ item.label }}
            </span>

        </div>

    </div>
</template>
