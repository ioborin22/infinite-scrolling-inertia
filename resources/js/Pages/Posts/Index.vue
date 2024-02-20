<template>

    <Head title="Posts"/>
    <div class="space-y-4 max-w-xl mx-auto">
        <div v-for="post in posts.data" :key="post.id" class="p-4 border border-gray-200 rounded-lg">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-lg">{{ post.id }}:</span>
                <span class="font-semibold text-xl">{{ post.title }}</span>
            </div>
            <p class="mt-2 text-gray-700">{{ post.teaser }}</p>
        </div>
        <div ref="last" class="-translate-y-32"></div>
    </div>

</template>

<script setup>
import {Head} from '@inertiajs/vue3'
import {ref} from 'vue'
import {useIntersectionObserver} from '@vueuse/core'
import axios from 'axios'

const props = defineProps({
    posts: Object
})

const last = ref(null);

const {stop} = useIntersectionObserver(last, ([{isIntersecting}]) => {
    if (!isIntersecting) {
        return
    }

    axios.get(`${props.posts.meta.path}?cursor=${props.posts.meta.next_cursor}`).then((response) => {
        props.posts.data = [...props.posts.data, ...response.data.data];
        props.posts.meta = response.data.meta
        if(!response.data.meta.next_cursor){
            stop()
        }
    });

});

</script>

<style scoped>

</style>
