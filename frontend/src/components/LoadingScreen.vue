<template>
  <div class="loading-screen" v-if="isLoading">
    <div class="loading-content">
      <div class="loading-text">Loading...</div>
      <div class="loading-percentage">{{ loadingPercentage }}%</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LoadingScreen',
  props: {
    isLoading: {
      type: Boolean,
      required: true
    },
    loadingPercentage: {
      type: Number,
      required: true
    }
  }
}
</script>

<style scoped>
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: black;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.loading-content {
  text-align: center;
  color: white;
}

.loading-text {
  font-size: 24px;
  margin-bottom: 10px;
}

.loading-percentage {
  font-size: 48px;
  font-weight: bold;
}
</style> 