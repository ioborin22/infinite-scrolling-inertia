<template>
    <Head title="Infinity Scroll Down"/>
    <!-- Container for the scrollable content -->
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="space-y-4 max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <!-- Loop through the posts and display them -->
            <div v-for="post in posts.data" :key="post.id" class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300 ease-in-out">
                <div class="flex items-center space-x-2">
                    <span class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ post.id }}</span>
                    <span class="font-semibold text-xl text-gray-900 dark:text-gray-100">{{ post.title }}</span>
                </div>
                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ post.teaser }}</p>
            </div>
            <!-- Invisible element to trigger loading more posts -->
            <div ref="last" class="-translate-y-32"></div>
        </div>
    </div>
    <!-- Message displayed when there are no more posts to load -->
    <div v-if="noMorePosts" class="text-center py-4 text-red-600 dark:text-red-400 bg-gray-100 dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        NO MORE POSTS
        <a href="/" class="block mt-4 text-blue-500 hover:text-blue-600 transition duration-300">
            <!-- Icon representing the action to go back -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Go Back
        </a>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import { useIntersectionObserver } from '@vueuse/core'
import axios from 'axios'

const props = defineProps({
    posts: Object // Expected prop: the initial list of posts
})

const last = ref(null); // Reference to the invisible element used to trigger data loading
const noMorePosts = ref(false); // State to track when there are no more posts to load

// Function to load more data when triggered
const loadData = () => {
    axios.get(`${props.posts.meta.path}?cursor=${props.posts.meta.next_cursor}`).then((response) => {
        // Append new posts to the existing list
        props.posts.data = [...props.posts.data, ...response.data.data];
        // Update the metadata with the new data's metadata
        props.posts.meta = response.data.meta;
        // If there's no next cursor, it means we've reached the end of the data
        if (!response.data.meta.next_cursor) {
            noMorePosts.value = true; // Set the flag to true, indicating there are no more posts to load
            stop(); // Stop the intersection observer from checking for intersections
        }
    });
};

// Setup the intersection observer on the 'last' element to trigger loading more data
const { stop } = useIntersectionObserver(
    last,
    ([{ isIntersecting }]) => {
        if (isIntersecting) loadData(); // If the 'last' element is in view, load more data
    }
);
</script>

<style scoped>
</style>
