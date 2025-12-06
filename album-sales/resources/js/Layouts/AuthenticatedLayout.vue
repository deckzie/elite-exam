<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation Bar -->
        <nav class="border-b border-gray-200 bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <!-- Left: Title -->
                    <div class="flex items-center">
                        <Link
                            :href="route('dashboard')"
                            class="flex items-center"
                        >
                            <span
                                class="text-lg font-semibold text-gray-800 hover:text-indigo-600 transition"
                            >
                                Album Sales Data
                            </span>
                        </Link>
                    </div>

                    <!-- Right: Log Out -->
                    <div>
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                        >
                            Log Out
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
