<template>
    <Head title="Posts"/>
    <div class="space-y-4 max-w-xl mx-auto" ref="scrollContainer">
        <!-- Изменен порядок элементов: сначала ref, затем посты -->
        <div ref="first" class="anchor-top"></div>
        <div v-for="post in posts.data" :key="post.id" class="p-4 border border-gray-200 rounded-lg">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-lg">{{ post.id }}:</span>
                <span class="font-semibold text-xl">{{ post.title }}</span>
            </div>
            <p class="mt-2 text-gray-700">{{ post.teaser }}</p>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { ref, watchEffect } from 'vue'
import { useIntersectionObserver } from '@vueuse/core'
import axios from 'axios'

const props = defineProps({
    posts: Object
})

const scrollContainer = ref(null)
const first = ref(null)

const { stop } = useIntersectionObserver(first, async ([{ isIntersecting }], observerElement) => {
    if (!isIntersecting) return
    const response = await axios.get(`${props.posts.meta.path}?cursor=${props.posts.meta.previous_cursor}`) // Предполагается, что API поддерживает пагинацию в обратном направлении
    const oldHeight = scrollContainer.value.scrollHeight
    props.posts.data = [...response.data.data, ...props.posts.data] // Добавляем данные в начало массива
    props.posts.meta = response.data.meta
    if (!response.data.meta.previous_cursor) stop()
    else {
        // Корректируем scrollTop, чтобы пользователь оставался на том же месте
        scrollContainer.value.scrollTop += scrollContainer.value.scrollHeight - oldHeight
    }
})
</script>
