<template>
  <div v-if="show" class="modal-overlay" @click="close">
    <div class="modal-content" :class="{ 'exploding': isExploding }" @click.stop>
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
  data() {
    return {
      isExploding: false
    }
  },
  methods: {
    close() {
      this.isExploding = true;
      setTimeout(() => {
        this.$emit('close');
        this.isExploding = false;
      }, 500); // Match the explosion animation duration
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
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease forwards;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  transform: translateY(100%);
  animation: slideUp 0.3s ease forwards;
}

.modal-content.exploding {
  animation: explode 0.5s ease-out forwards;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #333;
  z-index: 1;
}

.modal-body {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.modal-image {
  max-width: 100%;
  height: auto;
  border-radius: 4px;
}

.modal-info {
  flex: 1;
}

.modal-info h2 {
  margin: 0 0 10px 0;
  color: #333;
}

.modal-info p {
  margin: 0;
  color: #666;
  line-height: 1.5;
}

.audio-player {
  margin-top: 20px;
}

.audio-player audio {
  width: 100%;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    transform: translateY(100%);
  }
  to {
    transform: translateY(0);
  }
}

@keyframes explode {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  20% {
    transform: scale(1.1);
    opacity: 0.9;
  }
  40% {
    transform: scale(0.8);
    opacity: 0.8;
  }
  60% {
    transform: scale(0.6) translateY(20px);
    opacity: 0.6;
  }
  80% {
    transform: scale(0.4) translateY(40px);
    opacity: 0.4;
  }
  100% {
    transform: scale(0.2) translateY(100px);
    opacity: 0;
  }
}

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