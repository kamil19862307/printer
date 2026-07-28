<script setup>
import {
    WifiIcon,
    EllipsisHorizontalIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
    printer: Object,
})

const items = [
    {
        visible: props.printer.wifi,
        icon: WifiIcon,
        label: 'Wi-Fi',
    },
    {
        visible: props.printer.duplex,
        icon: EllipsisHorizontalIcon,
        label: 'Двусторонняя печать',
    },
    {
        visible: props.printer.ethernet,
        icon: EllipsisHorizontalIcon,
        label: 'Сетевой разъём',
    },
]
</script>

<template>
    <div class="grid grid-cols-2 gap-3">

        <div
            v-for="item in items.filter(i => i.visible)"
            :key="item.label"
            class="flex items-center gap-3 rounded-2xl border border-gray-200 p-4"
        >
            <component
                :is="item.icon"
                class="h-6 w-6 text-blue-600"
            />

            <span
                class="text-sm font-medium"
            >
                {{ item.label }}
            </span>

        </div>

    </div>
</template>
