<template>

    <Head title="Infinity Scroll Down"/>
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="space-y-4 max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <div v-for="post in posts.data" :key="post.id" class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-2">
                    <span class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ post.id }}:</span>
                    <span class="font-semibold text-xl text-gray-900 dark:text-gray-100">{{ post.title }}</span>
                </div>
                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ post.teaser }}</p>
            </div>
            <div ref="last" class="-translate-y-32"></div>
        </div>
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
