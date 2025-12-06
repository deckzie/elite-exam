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
                Sign up
            </h2>

            <!-- Global Error (Optional, for general auth failure) -->
            <div
                v-if="form.errors.username"
                class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm"
            >
                {{ form.errors.username }}
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1"
                    >Username</label
                >
                <input
                    v-model="form.username"
                    type="text"
                    placeholder="Enter your username"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                    :class="{
                        'border-red-500': form.errors.username,
                        'border-gray-300': !form.errors.username,
                    }"
                />
                <!-- Individual Field Error -->
                <p
                    v-if="form.errors.username"
                    class="text-red-500 text-xs mt-1"
                >
                    {{ form.errors.username }}
                </p>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-600 mb-1"
                    >Password</label
                >
                <input
                    v-model="form.password"
                    type="password"
                    placeholder="Enter your password"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                    :class="{
                        'border-red-500': form.errors.password,
                        'border-gray-300': !form.errors.password,
                    }"
                />
                <p
                    v-if="form.errors.password"
                    class="text-red-500 text-xs mt-1"
                >
                    {{ form.errors.password }}
                </p>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition disabled:opacity-50"
            >
                <span v-if="form.processing">Logging in...</span>
                <span v-else>Login</span>
            </button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

// 1. Use the Inertia useForm helper
const form = useForm({
    username: "",
    password: "",
});

function submit() {
    // 2. Use form.post() instead of router.post()
    // 3. Remove manual onSuccess logic; let the backend redirect handle it.
    form.post("/login", {
        onFinish: () => form.reset("password"),
    });
}
</script>
