<template>
    <Teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="$emit('close')"
            ></div>

            <div
                class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full z-10 mx-4"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3
                        class="text-lg leading-6 font-medium text-gray-900 mb-4"
                    >
                        Edit Artist
                    </h3>

                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                >Artist Name</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-300"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none disabled:opacity-50"
                            >
                                Save Changes
                            </button>

                            <button
                                type="button"
                                v-if="form.id"
                                @click="deleteItem"
                                class="text-red-600 hover:text-red-800 font-bold text-sm px-4"
                            >
                                Delete
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse">
                    <button
                        type="button"
                        @click="$emit('close')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Cancel
                    </button>
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
