<template>
    <Head title="Infinity Scroll Up"/>
    <!-- Display a message when there are no more posts to load -->
    <div v-if="noMorePosts" class="text-center py-4 text-red-600 dark:text-red-400 bg-gray-100 dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        NO MORE POSTS
        <!-- Link to navigate back to the homepage -->
        <a href="/" class="block mt-4 text-blue-500 hover:text-blue-600 transition duration-300">
            <!-- SVG icon for "go back" -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Go Back
        </a>
    </div>
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="space-y-4 max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <!-- Invisible element to detect when to load more data as the user scrolls up -->
            <div ref="last" class="translate-y-32"></div>
            <!-- Loop through posts and display them -->
            <div v-for="post in localPosts.data" :key="post.id" class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-2">
                    <span class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ post.id }}</span>
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

const props = defineProps({
    posts: Object // Initial posts passed as props
})

const isInitialScrollDone = ref(false);
const noMorePosts = ref(false);

// Ensure the page scrolls to the bottom on load
window.onload = function () {
    requestAnimationFrame(() => {
        window.scrollTo(0, document.body.scrollHeight);
        isInitialScrollDone.value = true;
    });
};

// Store posts data reactively, reversing order for infinite scroll up
const localPosts = reactive({
    data: [...props.posts.data].reverse(),
    meta: {...props.posts.meta}
});

const last = ref(null);

// Function to load more data when needed
const loadData = async () => {
    if (!localPosts.meta.next_cursor) {
        noMorePosts.value = true;
        return;
    }

    const response = await axios.get(`${props.posts.meta.path}?cursor=${localPosts.meta.next_cursor}`);
    const newData = [...response.data.data].reverse();

    if (newData.length > 0) {
        localPosts.data = [...newData, ...localPosts.data]; // Prepend new data
        localPosts.meta = {...response.data.meta};
    } else {
        noMorePosts.value = true;
    }
};

// Observe the 'last' element to trigger data loading when visible
const {stop} = useIntersectionObserver(
    last,
    ([{isIntersecting}], observerElement) => {
        if (!isIntersecting || !isInitialScrollDone.value) return;
        loadData();
    },
    {
        rootMargin: '500px 0px 500px 0px', // Adjust to control when the loading is triggered
    }
);
</script>

<style scoped>
</style>
