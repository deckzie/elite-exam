<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AlbumCard from "@/Components/AlbumCard.vue";
import ArtistCard from "@/Components/ArtistCard.vue";
import AlbumModal from "@/Components/AlbumModal.vue";
import ArtistModal from "@/Components/ArtistModal.vue";
import SearchBar from "@/Components/SearchBar.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import axios from "axios";

// reactive state
const albums = ref([]);
const artists = ref([]);
const searchQuery = ref("");

// computed: sort artists by total sales
const sortedArtists = computed(() =>
    [...artists.value].sort((a, b) => b.total_sales - a.total_sales)
);

const sortedAlbums = computed(() =>
    [...albums.value].sort((a, b) => b.sales - a.sales)
);

const filteredArtists = computed(() => {
    if (!searchQuery.value) return sortedArtists.value;

    const lowerQuery = searchQuery.value.toLowerCase();
    return sortedArtists.value.filter((artist) =>
        artist.name.toLowerCase().includes(lowerQuery)
    );
});

// 2. Filter Albums based on the *artists* found in step 1
const filteredAlbums = computed(() => {
    if (!searchQuery.value) return sortedAlbums.value;

    const lowerQuery = searchQuery.value.toLowerCase();

    // First, find the IDs of all artists that match the name
    const matchingArtistIds = artists.value
        .filter((artist) => artist.name.toLowerCase().includes(lowerQuery))
        .map((artist) => artist.code);

    // Then, return only albums that belong to those artist IDs
    return sortedAlbums.value.filter((album) =>
        matchingArtistIds.includes(album.artist_code)
    );
});

const showAlbumModal = ref(false);
const selectedAlbum = ref(null);

const showArtistModal = ref(false);
const selectedArtist = ref(null);

const openAlbumModal = (album) => {
    selectedAlbum.value = album;
    showAlbumModal.value = true;
};

const closeAlbumModal = () => {
    showAlbumModal.value = false;
    setTimeout(() => (selectedAlbum.value = null), 200);
};

const openArtistModal = (artist) => {
    selectedArtist.value = artist;
    showArtistModal.value = true;
};
const handleUrlInput = () => {
    const url = form.cover_url;

    // Clear previous timeout (Debounce)
    if (debounceTimeout) clearTimeout(debounceTimeout);

    if (!url) {
        imageStatus.value = "idle";
        isValidating.value = false;
        return;
    }

    isValidating.value = true;

    // Wait 500ms after user stops typing before checking
    debounceTimeout = setTimeout(() => {
        const img = new Image();

        img.onload = () => {
            isValidating.value = false;
            imageStatus.value = "valid";
        };

        img.onerror = () => {
            isValidating.value = false;
            imageStatus.value = "error";
        };

        img.src = url; // This triggers the load
    }, 500);
};

const closeArtistModal = () => {
    showArtistModal.value = false;
    setTimeout(() => (selectedArtist.value = null), 200);
};

// fetch data from backend
onMounted(async () => {
    try {
        const albumRes = await axios.get("/albums");
        albums.value = albumRes.data;

        const artistRes = await axios.get("/artists");
        artists.value = artistRes.data;
    } catch (err) {
        console.error("Failed to load dashboard data:", err);
    }
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <div class="flex h-screen">
            <div class="flex-1 p-6 overflow-y-auto ml-20">
                <SearchBar
                    v-model="searchQuery"
                    placeholder="Search by Artist..."
                />
                <div
                    v-if="filteredAlbums.length === 0"
                    class="text-center text-gray-500 mt-10"
                >
                    No albums found for this artist.
                </div>

                <div
                    v-else
                    class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
                >
                    <!-- Using filteredAlbums here -->
                    <AlbumCard
                        v-for="album in filteredAlbums"
                        :key="album.id"
                        :album="album"
                        @open="openAlbumModal"
                    />
                </div>
            </div>

            <div class="w-1/3 p-6 overflow-y-auto border-l border-gray-200">
                <h2 class="text-xl font-bold mb-4">
                    {{ searchQuery ? "Matching Artists" : "Artist Stats" }}
                </h2>

                <div v-if="filteredArtists.length === 0" class="text-gray-500">
                    No artists found.
                </div>

                <!-- Using filteredArtists here -->
                <ArtistCard
                    v-for="artist in filteredArtists"
                    :key="artist.id"
                    :artist="artist"
                    @open="openArtistModal"
                />
            </div>

            <AlbumModal
                :show="showAlbumModal"
                :album="selectedAlbum"
                :artists="sortedArtists"
                @close="closeAlbumModal"
            />

            <ArtistModal
                :show="showArtistModal"
                :artist="selectedArtist"
                @close="closeArtistModal"
            />
        </div>
    </AuthenticatedLayout>
</template>
