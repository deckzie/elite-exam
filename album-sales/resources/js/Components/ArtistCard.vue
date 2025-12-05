<template>
  <div
    class="bg-gray-100 rounded p-4 mb-4 shadow hover:shadow-md transition cursor-pointer"
    @click="$emit('open', artist)"
  >
    <!-- Artist name -->
    <h3 class="font-bold text-lg">{{ artist.name }}</h3>

    <!-- Stats -->
    <p class="text-sm text-gray-700">Albums: {{ artist.album_count }}</p>
    <p class="text-sm text-gray-700">Total Sales: {{ artist.total_sales || 0 }}</p>
  </div>
</template>

<script setup>
defineProps({
  artist: {
    type: Object,
    required: true,
  },
})
</script>

