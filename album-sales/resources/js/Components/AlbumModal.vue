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
                        Edit Album
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
                        <!-- Album Name -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Album Name
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

                        <!-- Artist -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Artist
                            </label>
                            <select
                                v-model="form.artist_code"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700"
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
                            <div
                                v-if="form.errors.artist_code"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.artist_code }}
                            </div>
                        </div>

                        <!-- Year -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Year
                            </label>
                            <input
                                v-model="form.year"
                                type="number"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700"
                            />
                            <div
                                v-if="form.errors.year"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.year }}
                            </div>
                        </div>

                        <!-- Sales -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Sales
                            </label>
                            <input
                                v-model="form.sales"
                                type="number"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700"
                            />
                            <div
                                v-if="form.errors.sales"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.sales }}
                            </div>
                        </div>

                        <!-- Album Cover -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Album Cover
                            </label>
                            <input
                                type="file"
                                @change="handleFileChange"
                                accept=".jpg, .jpeg, .png, .webp"
                                class="file:cursor-pointer w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            />

                            <p class="text-xs text-gray-500 mt-1">
                                Upload a JPG, PNG, or WEBP (Max 2MB).
                            </p>

                            <div
                                v-if="form.errors.cover"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.cover }}
                            </div>
                            <div
                                v-if="form.errors.cover"
                                class="text-red-500 text-xs mt-1"
                            >
                                {{ form.errors.cover }}
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between items-center pt-6">
                            <!-- Delete on the left -->
                            <button
                                type="button"
                                v-if="form.id"
                                @click="deleteItem"
                                class="cursor-pointer inline-flex items-center justify-center rounded-md border border-red-300 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
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
    cover: null,
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
    form.post(route("albums.update", form.id), {
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

// Inside <script setup>

const handleFileChange = (event) => {
    const file = event.target.files[0];

    if (!file) return;

    const allowedTypes = ["image/jpeg", "image/png", "image/webp"];

    if (!allowedTypes.includes(file.type)) {
        form.errors.cover = "Invalid format. Only JPG, PNG, or WEBP allowed.";
        form.cover = null;
        event.target.value = "";

        return;
    }

    form.clearErrors("cover");
    form.cover = file;
};
</script>
>
