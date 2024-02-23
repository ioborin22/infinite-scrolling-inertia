<template>

    <Head title="Posts"/>
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="space-y-4 max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <div ref="last" class="translate-y-32"></div>
            <div v-for="post in localPosts.data" :key="post.id" class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-2">
                    <span class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ post.id }}:</span>
                    <span class="font-semibold text-xl text-gray-900 dark:text-gray-100">{{ post.title }}</span>
                </div>
                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ post.teaser }}</p>
            </div>
        </div>
    </div>

</template>


<script setup>
import {Head} from '@inertiajs/vue3'
import {ref, reactive} from 'vue'
import {useIntersectionObserver} from '@vueuse/core'
import axios from 'axios'

// Defining component props
const props = defineProps({
    posts: Object
})

// Flag to control the initial data loading
const isInitialScrollDone = ref(false);

// Ensuring scroll to the bottom of the page after it's fully loaded
window.onload = function () {
    requestAnimationFrame(() => {
        window.scrollTo(0, document.body.scrollHeight);
        isInitialScrollDone.value = true; // Updating the flag after scrolling
    });
};

// Reactive variable to store the posts data
const localPosts = reactive({
    data: [...props.posts.data].reverse(), // Reversing the data for display
    meta: {...props.posts.meta}
});

const last = ref(null);

// Function to load more data
const loadData = async () => {
    // Checking if there's a next cursor to fetch more data
    if (!localPosts.meta.next_cursor) return;

    // Fetching data
    const response = await axios.get(`${props.posts.meta.path}?cursor=${localPosts.meta.next_cursor}`);
    // Reversing and adding the new data at the beginning of the array
    const newData = [...response.data.data].reverse();
    localPosts.data = [...newData, ...localPosts.data];
    localPosts.meta = {...response.data.meta}; // Updating meta data including the cursor
};

// Setting up IntersectionObserver to load data when the 'last' element is visible
const {stop} = useIntersectionObserver(
    last, // The element to observe
    ([{isIntersecting}], observerElement) => {
        // Loading data if the initial scroll is done and the element is intersecting
        if (!isIntersecting || !isInitialScrollDone.value) return;
        loadData();
    },
    {
        rootMargin: '500px 0px 500px 0px', // Increasing the visibility area for early triggering
    }
);
</script>

<style scoped>
</style>
