<script setup>
defineProps({
    images: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <div class="bg-white p-6">

        <img
            :src="images[0]"
            alt=""
            class="mx-auto h-72 w-full object-contain"
        />

        <div
            class="mt-4 flex justify-center gap-2"
        >
            <div
                class="h-2 w-5 rounded-full bg-blue-600"
            />

            <div
                class="h-2 w-2 rounded-full bg-gray-300"
            />

            <div
                class="h-2 w-2 rounded-full bg-gray-300"
            />

            <div
                class="h-2 w-2 rounded-full bg-gray-300"
            />

        </div>

    </div>
</template>
