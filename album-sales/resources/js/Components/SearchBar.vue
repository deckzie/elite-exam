<script setup>
defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: "Search...",
    },
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="sticky top-0 z-10 pb-4 pt-2 rounded-xl">
        <input
            type="text"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            class="border-blue-300 shadow-md focus:border-indigo-500 focus:ring-indigo-500 rounded-md w-full px-4 py-2 pr-10"
        />

        <span
            v-if="modelValue"
            class="absolute right-3 top-2.5 text-gray-400 cursor-pointer hover:text-gray-600 transition"
            @click="$emit('update:modelValue', '')"
        >
            ✕
        </span>
    </div>
</template>
