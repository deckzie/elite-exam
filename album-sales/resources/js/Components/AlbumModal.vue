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
                        Edit Album
                    </h3>

                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                >Album Name</label
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

                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                >Artist</label
                            >
                            <div class="relative">
                                <select
                                    v-model="form.artist_code"
                                    class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                                >
                                    <option value="" disabled>
                                        Select an Artist
                                    </option>
                                    <option
                                        v-for="artist in artists"
                                        :key="artist.code"
                                        :value="artist.code"
                                    >
                                        {{ artist.name }}
                                    </option>
                                </select>
                            </div>
                            <div
                                v-if="form.errors.artist_code"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.artist_code }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                >Year</label
                            >
                            <input
                                v-model="form.year"
                                type="number"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-300"
                            />
                            <div
                                v-if="form.errors.year"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.year }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                >Sales</label
                            >
                            <input
                                v-model="form.sales"
                                type="number"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-300"
                            />
                            <div
                                v-if="form.errors.sales"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.sales }}
                            </div>
                        </div>

                        <div class="flex-grow">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                >Album Cover</label
                            >
                            <input
                                v-model="form.cover"
                                @input="handleUrlInput"
                                type="text"
                                placeholder="https://site.com/image.jpg"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-300"
                            />

                            <div class="text-xs mt-1">
                                <span class="text-gray-500"
                                    >Paste a direct link to a JPG, PNG, or
                                    WEBP.</span
                                >
                            </div>

                            <div
                                v-if="form.errors.cover"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.cover }}
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
    album: Object, // The album object passed from parent
    artists: Array,
});

const emit = defineEmits(["close"]);

// Initialize form
const form = useForm({
    id: null,
    name: "",
    artist_code: "",
    year: "",
    sales: 0,
    cover: "",
});

// Watch for changes in the 'album' prop to populate the form
watch(
    () => props.album,
    (newAlbum) => {
        if (newAlbum) {
            form.id = newAlbum.id;
            form.artist_code = newAlbum.artist_code;
            form.name = newAlbum.name;
            form.year = newAlbum.year;
            form.sales = newAlbum.sales;
            form.cover = newAlbum.cover;
        } else {
            form.reset(); // Clear form if no album (or creating new)
        }
    },
    { immediate: true }
);

const submit = () => {
    form.put(route("albums.update", form.id), {
        onSuccess: () => {
            emit("close"), window.location.reload();
        },
    });
};

const deleteItem = () => {
    if (!confirm("Are you sure?")) return;

    form.delete(route("albums.destroy", form.id), {
        onSuccess: () => {
            emit("close"), window.location.reload();
        },
    });
};
</script>
>
