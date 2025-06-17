<template>
  <div v-if="show" class="modal-overlay" @click="close">
    <div class="modal-content" @click.stop>
      <button class="close-button" @click="close">&times;</button>
      <div class="modal-body">
        <img :src="getWebpImage(item.image_link)" :alt="item.title" class="modal-image">
        <div class="modal-info">
          <h2>{{ item.title }}</h2>
          <p v-html="formatDescription(item.description)"></p>
          <div v-if="type === 'audio' && item.mp3_file" class="audio-player">
            <audio controls>
              <source :src="item.mp3_file" type="audio/mpeg">
              Your browser does not support the audio element.
            </audio>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Modal',
  props: {
    show: {
      type: Boolean,
      required: true
    },
    item: {
      type: Object,
      required: true
    },
    type: {
      type: String,
      required: true
    }
  },
  methods: {
    close() {
      this.$emit('close');
    },
    getWebpImage(imageUrl) {
      if (!imageUrl) return '';
      
      // If the image is already a WebP, return it
      if (imageUrl.endsWith('.webp')) {
        return imageUrl;
      }
      
      // If the image is a data URL, return it as is
      if (imageUrl.startsWith('data:')) {
        return imageUrl;
      }
      
      // Convert the image URL to WebP
      const webpUrl = imageUrl.replace(/\.(jpg|jpeg|png)$/i, '.webp');
      
      // Check if WebP version exists, if not, fall back to original
      return webpUrl;
    },
    formatDescription(text) {
      if (!text) return '';
      
      // Replace ```text``` with clickable links
      return text.replace(/```([^`]+)```/g, (match, url) => {
        return `<a href="${url}" target="_blank" rel="noopener noreferrer">${url}</a>`;
      });
    }
  }
}
</script>

<style scoped>
/* Add styles for clickable links */
a {
  color: #007bff;
  text-decoration: underline;
  cursor: pointer;
}

a:hover {
  color: #0056b3;
}
</style> 