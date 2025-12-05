<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AlbumCard from '@/Components/AlbumCard.vue'
import ArtistCard from '@/Components/ArtistCard.vue'
import AlbumModal from '@/Components/AlbumModal.vue'

import { Head } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

// reactive state
const albums = ref([])
const artists = ref([])


// computed: sort artists by total sales
const sortedArtists = computed(() =>
  [...artists.value].sort((a, b) => b.total_sales - a.total_sales)
)

const showAlbumModal = ref(false);
const selectedAlbum = ref(null);

const openAlbumModal = (album) => {
    selectedAlbum.value = album;
    showAlbumModal.value = true;
};

const closeAlbumModal = () => {
    showAlbumModal.value = false;
    setTimeout(() => selectedAlbum.value = null, 200);
};

// fetch data from backend
onMounted(async () => {
  try {
    const albumRes = await axios.get('/albums')
    albums.value = albumRes.data

    const artistRes = await axios.get('/artists')
    artists.value = artistRes.data
  } catch (err) {
    console.error('Failed to load dashboard data:', err)
  }
})
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Dashboard" />

    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="flex h-screen">
      <div class="w-2/3 p-6 grid grid-cols-3 gap-4 overflow-y-auto">
        <AlbumCard
          v-for="album in albums"
          :key="album.id"
          :album="album"
          @open="openAlbumModal"
        />
      </div>

      <div class="w-1/3 p-6 bg-gray-50 overflow-y-auto">
        <h2 class="text-xl font-bold mb-4">Artist Stats</h2>
        <ArtistCard
          v-for="artist in sortedArtists"
          :key="artist.id"
          :artist="artist"
          @open="openArtistModal"
        />
      </div>

      <AlbumModal 
            :show="showAlbumModal" 
            :album="selectedAlbum" 
            @close="closeAlbumModal" 
        />
      
    </div>
  </AuthenticatedLayout>
</template>
