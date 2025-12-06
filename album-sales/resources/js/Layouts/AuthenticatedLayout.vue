<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="h-screen flex flex-col overflow-hidden bg-gray-100">
        <nav
            class="sticky top-0 z-50 border-b border-gray-200 bg-white backdrop-blur-md shadow-sm"
        >
            <div class="w-[85%] mx-auto py-5 flex justify-between items-center">
                <Link
                    :href="route('dashboard')"
                    class="group flex items-center gap-2"
                >
                    <span
                        class="text-xl font-bold text-gray-900 hover:text-indigo-600 transition"
                    >
                        Album Sales Data
                    </span>
                </Link>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition"
                >
                    Log Out
                </Link>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-h-0 overflow-hidden">
            <slot />
        </main>
    </div>
</template>
