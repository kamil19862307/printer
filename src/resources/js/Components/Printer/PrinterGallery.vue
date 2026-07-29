<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination } from 'swiper/modules'

defineProps({
    images: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <Swiper
        :modules="[Pagination]"
        :pagination="{ clickable: true }"
        :slides-per-view="1"
        :space-between="0"
        :speed="350"
        class="printer-swiper"
    >
        <SwiperSlide
            v-for="(image, index) in images"
            :key="index"
        >
            <div class="bg-white p-6">
                <img
                    :src="image"
                    alt=""
                    class="mx-auto h-72 w-full cursor-pointer object-contain select-none transition-transform duration-300 hover:scale-[1.02]"
                    draggable="false"
                />
            </div>
        </SwiperSlide>
    </Swiper>
</template>

<style scoped>
:deep(.swiper-pagination) {
    position: static;
    margin-top: 8px;
}

:deep(.swiper-pagination-bullet) {
    width: 8px;
    height: 8px;

    background: #d1d5db;
    opacity: 1;

    transition: all .25s;
}

:deep(.swiper-pagination-bullet-active) {
    width: 22px;
    border-radius: 999px;

    background: #2563eb;
}
</style>
