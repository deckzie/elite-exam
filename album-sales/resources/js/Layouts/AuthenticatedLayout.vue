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
        <main>
            <slot />
        </main>
    </div>
</template>
