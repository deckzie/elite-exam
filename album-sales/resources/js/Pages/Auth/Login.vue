<template>
    <div
        class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100"
    >
        <form
            @submit.prevent="submit"
            class="w-96 p-8 bg-white shadow-lg rounded-xl transition-transform transform hover:scale-[1.01]"
        >
            <!-- Header -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Welcome Back
            </h2>

            <!-- Username -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1"
                    >Username</label
                >
                <input
                    v-model="form.username"
                    type="text"
                    placeholder="Enter your username"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-600 mb-1"
                    >Password</label
                >
                <input
                    v-model="form.password"
                    type="password"
                    placeholder="••••••••"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                />
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
            >
                Login
            </button>
        </form>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

const form = reactive({
    username: "",
    password: "",
});

function submit() {
    router.post("/login", form, {
        onSuccess: () => router.visit("/dashboard"),
    });
}
</script>
