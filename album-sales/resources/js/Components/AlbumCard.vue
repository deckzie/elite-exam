<template>
  <div
    class="bg-white shadow rounded p-4 cursor-pointer hover:shadow-lg transition"
    @click="$emit('open', album)"
  >
    <!-- Album cover -->
    <img
      :src="album.cover_url || '/placeholder.png'"
      alt="Album Cover"
      class="w-full h-40 object-cover rounded"
    />

    <!-- Album details -->
    <h3 class="mt-2 font-bold text-lg">{{ album.name }}</h3>
    <p class="text-sm text-gray-600">
      {{ album.artist?.name }} • {{ album.year }}
    </p>
    <p class="text-sm text-gray-800">Sales: {{ album.sales }}</p>
  </div>
</template>

<script setup>
defineProps({
  album: {
    type: Object,
    required: true,
  },
})
</script>
