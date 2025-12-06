<template>
    <Teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto"
            role="dialog"
            aria-modal="true"
        >
            <!-- Overlay -->
            <div
                class="fixed inset-0 bg-gray-600 bg-opacity-60 transition-opacity"
                @click="$emit('close')"
            ></div>

            <!-- Modal -->
            <div
                class="bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg w-full z-10 mx-4"
            >
                <!-- Header -->
                <div
                    class="px-6 py-4 border-b border-gray-200 flex justify-between items-center"
                >
                    <h3 class="text-xl font-semibold text-gray-900">
                        Edit Artist
                    </h3>
                    <!-- Small X button -->
                    <button
                        type="button"
                        @click="$emit('close')"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full p-1 transition"
                        aria-label="Close"
                    >
                        <svg
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-6 py-5">
                    <form @submit.prevent="submit" class="space-y-5">
                        <!-- Artist Name -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Artist Name
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between items-center pt-4">
                            <!-- Delete on the left -->
                            <button
                                type="button"
                                v-if="form.id"
                                @click="deleteItem"
                                class="inline-flex items-center justify-center rounded-md border border-red-300 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
                            >
                                Delete
                            </button>

                            <!-- Save Changes on the right -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 transition"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";

const props = defineProps({
    show: Boolean,
    // Renamed prop from 'album' to 'artist'
    artist: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["close"]);

// 1. Initialize form with artist specific fields
const form = useForm({
    id: null,
    name: "",
});

// 2. Watch for changes in the 'artist' prop to populate the form
watch(
    () => props.artist,
    (newArtist) => {
        if (newArtist) {
            form.id = newArtist.code;
            form.name = newArtist.name;
        } else {
            // Clear form for new creation
            form.reset();
        }
    },
    { immediate: true }
); // Run immediately to populate if 'artist' is present on load

const submit = () => {
    // If form has an ID, it's an UPDATE operation (PUT)
    form.put(route("artists.update", form.id), {
        onSuccess: () => {
            emit("close"), window.location.reload();
        },
    });
};

const deleteItem = () => {
    if (!confirm("Are you sure you want to delete this artist?")) return;

    // DELETE operation
    form.delete(route("artists.destroy", form.id), {
        onSuccess: () => {
            emit("close"), window.location.reload();
        },
    });
};
</script>
