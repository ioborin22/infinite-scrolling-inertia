<script setup>
import {Head, Link} from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Infinity Scroll Inertia"/>

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <svg fill="#FF2D20" height="100px" width="100px" version="1.1" id="Layer_1"
                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                     xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier"> <g> <g> <path
                        d="M155.804,205.902c-27.625,0-50.098,22.473-50.098,50.098s22.473,50.098,50.098,50.098 c28.788,0,52.979-23.076,77.68-50.098C208.782,228.978,184.593,205.902,155.804,205.902z"></path> </g> </g>
                        <g> <g> <path
                            d="M356.196,205.902c-28.788,0-52.979,23.076-77.68,50.098c24.7,27.022,48.891,50.098,77.68,50.098 c27.625,0,50.098-22.473,50.098-50.098S383.821,205.902,356.196,205.902z"></path> </g> </g>
                        <g> <g> <path
                            d="M256,0C114.844,0,0,114.839,0,256s114.844,256,256,256s256-114.839,256-256S397.156,0,256,0z M356.196,339.496 c-41.465,0-71.896-27.919-100.196-58.632c-28.3,30.713-58.73,58.632-100.196,58.632c-46.042,0-83.496-37.454-83.496-83.496 c0-46.042,37.454-83.496,83.496-83.496c41.465,0,71.896,27.919,100.196,58.632c28.3-30.713,58.73-58.632,100.196-58.632 c46.042,0,83.496,37.454,83.496,83.496C439.692,302.042,402.238,339.496,356.196,339.496z"></path> </g> </g> </g></svg>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <a href="/posts"
                       class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div
                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6"
                                     style="transform: rotate(90deg);">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                </svg>

                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Infinity Scroll
                                Down</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                This block features an infinite scroll with inertia, displaying 100 posts downwards.
                            </p>
                        </div>

                    </a>

                    <a href="/posts/reversed"
                       class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div
                                class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6"
                                     style="transform: rotate(-90deg);">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                                </svg>

                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Infinity Scroll Up</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                This block features an infinite scroll with inertia, displaying 100 posts upwards.
                            </p>
                        </div>


                    </a>


                </div>
            </div>

            <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">

                <div class="ms-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-end sm:ms-0">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
