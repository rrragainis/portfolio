<template>
  <div class="admin-panel">
    <PasswordScreen v-if="!isAuthenticated" @authenticated="handleAuthentication" />
    <div v-else class="container mt-4">
      <h1>Admin Panel</h1>
      
      <div class="row">
        <!-- Photoshop Section -->
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Photoshop</h5>
              <button class="btn btn-primary btn-sm" @click="showAddModal('photoshop')">
                Add New
              </button>
            </div>
            <div class="card-body">
              <div class="list-group">
                <div v-for="item in photoshops" :key="item.id" class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <img :src="getImageUrl(item.cropped_image)" :alt="item.name" class="thumbnail">
                      <span class="ms-2">{{ item.name }}</span>
                    </div>
                    <div>
                      <button class="btn btn-warning btn-sm me-2" @click="editItem('photoshop', item.id)">Edit</button>
                      <button class="btn btn-danger btn-sm" @click="deleteItem('photoshop', item.id)">Delete</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Audio Section -->
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Audio</h5>
              <button class="btn btn-primary btn-sm" @click="showAddModal('audio')">
                Add New
              </button>
            </div>
            <div class="card-body">
              <div class="list-group">
                <div v-for="item in audio" :key="item.id" class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <img :src="getImageUrl(item.cropped_image)" :alt="item.name" class="thumbnail">
                      <span class="ms-2">{{ item.name }}</span>
                    </div>
                    <div>
                      <button class="btn btn-warning btn-sm me-2" @click="editItem('audio', item.id)">Edit</button>
                      <button class="btn btn-danger btn-sm" @click="deleteItem('audio', item.id)">Delete</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Programming Section -->
        <div class="col-md-4">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Programming</h5>
              <button class="btn btn-primary btn-sm" @click="showAddModal('programming')">
                Add New
              </button>
            </div>
            <div class="card-body">
              <div class="list-group">
                <div v-for="item in programmings" :key="item.id" class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <img :src="getImageUrl(item.cropped_image)" :alt="item.name" class="thumbnail">
                      <span class="ms-2">{{ item.name }}</span>
                    </div>
                    <div>
                      <button class="btn btn-warning btn-sm me-2" @click="editItem('programming', item.id)">Edit</button>
                      <button class="btn btn-danger btn-sm" @click="deleteItem('programming', item.id)">Delete</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" :class="{ show: showModal }" tabindex="-1" style="display: block;" v-if="showModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editingItem ? 'Edit' : 'Add New' }} {{ currentType }} Entry</h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveItem">
              <div class="mb-3">
                <label for="latvian_name" class="form-label">Latvian Name</label>
                <input type="text" class="form-control" v-model="formData.latvian_name" required>
              </div>
              <div class="mb-3">
                <label for="english_name" class="form-label">English Name</label>
                <input type="text" class="form-control" v-model="formData.english_name" required>
              </div>
              <div class="mb-3">
                <label for="latvian_description" class="form-label">Latvian Description</label>
                <textarea class="form-control" v-model="formData.latvian_description" required></textarea>
              </div>
              <div class="mb-3">
                <label for="english_description" class="form-label">English Description</label>
                <textarea class="form-control" v-model="formData.english_description" required></textarea>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Main Image</label>
                <input type="file" class="form-control" @change="handleImageUpload" accept="image/*" required>
                <img v-if="formData.imagePreview" :src="formData.imagePreview" class="image-preview mt-2">
              </div>
              <div v-if="currentType === 'audio'" class="mb-3">
                <label for="mp3File" class="form-label">MP3 File</label>
                <input type="file" class="form-control" @change="handleMp3Upload" accept="audio/mp3">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Cropper Modal -->
    <div class="modal fade" :class="{ show: showCropperModal }" tabindex="-1" style="display: block;" v-if="showCropperModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crop Image</h5>
            <button type="button" class="btn-close" @click="closeCropperModal"></button>
          </div>
          <div class="modal-body">
            <img ref="cropperImage" :src="cropperImageSrc" style="max-width: 100%;">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeCropperModal">Cancel</button>
            <button type="button" class="btn btn-primary" @click="cropImage">Crop</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Gallery Modal -->
    <div class="modal fade" :class="{ show: showGalleryModal }" tabindex="-1" style="display: block;" v-if="showGalleryModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ currentGalleryItem.name }}</h5>
            <button type="button" class="btn-close" @click="closeGalleryModal"></button>
          </div>
          <div class="modal-body">
            <div class="gallery-container">
              <div class="gallery-image-container">
                <img :src="currentGalleryImage" class="gallery-image" :alt="currentGalleryItem.name">
                <div class="gallery-navigation">
                  <button class="btn btn-light" @click="previousImage" :disabled="currentImageIndex === 0">
                    Left
                  </button>
                  <button class="btn btn-light" @click="nextImage" :disabled="currentImageIndex === galleryImages.length - 1">
                    Right
                  </button>
                </div>
              </div>
              <div class="gallery-description mt-3">
                <p>{{ currentGalleryItem.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Cropper from 'cropperjs'
import 'cropperjs/dist/cropper.css'
import PasswordScreen from '@/components/PasswordScreen.vue'

export default {
  name: 'AdminPanel',
  components: {
    PasswordScreen
  },
  data() {
    return {
      isAuthenticated: false,
      showModal: false,
      showCropperModal: false,
      showGalleryModal: false,
      currentType: '',
      editingItem: null,
      cropper: null,
      cropperImageSrc: '',
      photoshops: [],
      audio: [],
      programmings: [],
      formData: {
        latvian_name: '',
        english_name: '',
        latvian_description: '',
        english_description: '',
        imagePreview: null,
        mp3File: null,
        originalImage: null
      },
      currentGalleryItem: null,
      currentImageIndex: 0,
      galleryImages: [],
      retryAfter: 0,
      rateLimitTimer: null
    }
  },
  computed: {
    currentGalleryImage() {
      return this.galleryImages[this.currentImageIndex] || ''
    }
  },
  mounted() {
    // Check if user is already authenticated
    this.isAuthenticated = localStorage.getItem('adminAuthenticated') === 'true'
    if (this.isAuthenticated) {
      this.loadData()
    }
  },
  methods: {
    sanitizeInput(input) {
      if (typeof input !== 'string') return input
      return input
        .replace(/[<>]/g, '') // Remove < and > to prevent HTML injection
        .replace(/javascript:/gi, '') // Remove javascript: protocol
        .trim()
    },
    handleRateLimit(response) {
      if (response.status === 429) {
        this.retryAfter = response.headers['retry-after'] || 60
        this.startRateLimitTimer()
        return true
      }
      return false
    },
    startRateLimitTimer() {
      if (this.rateLimitTimer) {
        clearInterval(this.rateLimitTimer)
      }
      this.rateLimitTimer = setInterval(() => {
        if (this.retryAfter > 0) {
          this.retryAfter--
        } else {
          clearInterval(this.rateLimitTimer)
        }
      }, 1000)
    },
    handleAuthentication() {
      this.isAuthenticated = true
      this.loadData()
    },
    getImageUrl(imagePath) {
      if (!imagePath) return ''
      if (imagePath.startsWith('http')) return imagePath
      if (imagePath.startsWith('data:')) return imagePath
      return `http://localhost:8000${imagePath}`
    },
    async loadData() {
      try {
        const [photoshopRes, audioRes, programmingRes] = await Promise.all([
          axios.get('/api/photoshops'),
          axios.get('/api/audio'),
          axios.get('/api/programmings')
        ])
        this.photoshops = photoshopRes.data
        this.audio = audioRes.data
        this.programmings = programmingRes.data
      } catch (error) {
        if (this.handleRateLimit(error.response)) {
          alert(`Too many requests. Please wait ${this.retryAfter} seconds.`)
          return
        }
        console.error('Error loading data:', error)
        alert('Error loading data: ' + (error.response?.data?.message || error.message))
      }
    },
    showAddModal(type) {
      this.currentType = type
      this.editingItem = null
      this.formData = {
        latvian_name: '',
        english_name: '',
        latvian_description: '',
        english_description: '',
        imagePreview: null,
        mp3File: null,
        originalImage: null
      }
      this.showModal = true
    },
    async editItem(type, id) {
      try {
        const endpoint = type === 'programming' ? 'programmings' : type === 'audio' ? 'audio' : type + 's'
        const response = await axios.get(`/api/${endpoint}/${id}`)
        this.editingItem = response.data
        this.currentType = type
        this.formData = {
          latvian_name: response.data.latvian_name,
          english_name: response.data.english_name,
          latvian_description: response.data.latvian_description,
          english_description: response.data.english_description,
          imagePreview: this.getImageUrl(response.data.cropped_image),
          mp3File: null,
          originalImage: this.getImageUrl(response.data.original_image)
        }
        this.showModal = true
      } catch (error) {
        console.error('Error loading item:', error)
        alert('Error loading item: ' + (error.response?.data?.message || error.message))
      }
    },
    async deleteItem(type, id) {
      if (confirm('Are you sure you want to delete this item?')) {
        try {
          const endpoint = type === 'programming' ? 'programmings' : type === 'audio' ? 'audio' : type + 's'
          await axios.delete(`/api/${endpoint}/${id}`)
          this.loadData()
        } catch (error) {
          console.error('Error deleting item:', error)
          alert('Error deleting item: ' + (error.response?.data?.message || error.message))
        }
      }
    },
    handleImageUpload(event) {
      const file = event.target.files[0]
      if (file) {
        const reader = new FileReader()
        reader.onload = (e) => {
          this.cropperImageSrc = e.target.result
          this.formData.originalImage = e.target.result
          this.showCropperModal = true
          this.$nextTick(() => {
            if (this.cropper) {
              this.cropper.destroy()
            }
            this.cropper = new Cropper(this.$refs.cropperImage, {
              aspectRatio: 1,
              viewMode: 1,
              dragMode: 'move',
              autoCropArea: 1,
              restore: false,
              guides: true,
              center: true,
              highlight: false,
              cropBoxMovable: true,
              cropBoxResizable: true,
              toggleDragModeOnDblclick: false,
            })
          })
        }
        reader.readAsDataURL(file)
      }
    },
    handleMp3Upload(event) {
      this.formData.mp3File = event.target.files[0]
    },
    cropImage() {
      const canvas = this.cropper.getCroppedCanvas({
        width: 300,
        height: 300
      })
      this.formData.imagePreview = canvas.toDataURL('image/jpeg', 0.8)
      this.closeCropperModal()
    },
    closeModal() {
      this.showModal = false
      this.editingItem = null
      this.formData = {
        latvian_name: '',
        english_name: '',
        latvian_description: '',
        english_description: '',
        imagePreview: null,
        mp3File: null,
        originalImage: null
      }
    },
    closeCropperModal() {
      this.showCropperModal = false
      if (this.cropper) {
        this.cropper.destroy()
        this.cropper = null
      }
    },
    async saveItem() {
      try {
        const formData = new FormData()
        
        // Sanitize and validate input
        const sanitizedData = {
          latvian_name: this.sanitizeInput(this.formData.latvian_name),
          english_name: this.sanitizeInput(this.formData.english_name),
          latvian_description: this.sanitizeInput(this.formData.latvian_description),
          english_description: this.sanitizeInput(this.formData.english_description)
        }
        
        // Always include name and description
        formData.append('latvian_name', sanitizedData.latvian_name)
        formData.append('english_name', sanitizedData.english_name)
        formData.append('latvian_description', sanitizedData.latvian_description)
        formData.append('english_description', sanitizedData.english_description)
        
        // Handle image - only if a new image was selected
        if (this.formData.imagePreview && this.formData.imagePreview.startsWith('data:')) {
          formData.append('cropped_image', this.formData.imagePreview)
          formData.append('original_image', this.formData.originalImage)
        }

        if (this.currentType === 'audio') {
          if (!this.editingItem && !this.formData.mp3File) {
            throw new Error('MP3 file is required for new audio entries')
          }
          if (this.formData.mp3File) {
            formData.append('mp3_file', this.formData.mp3File)
          }
        }

        const endpoint = this.currentType === 'programming' ? 'programmings' : this.currentType === 'audio' ? 'audio' : this.currentType + 's'
        
        let response
        if (this.editingItem) {
          // For updates, we need to send the _method field for Laravel to recognize it as a PUT request
          formData.append('_method', 'PUT')
          response = await axios.post(`/api/${endpoint}/${this.editingItem.id}`, formData)
        } else {
          response = await axios.post(`/api/${endpoint}`, formData)
        }

        if (response.status === 200 || response.status === 201) {
          this.closeModal()
          await this.loadData() // Reload data after successful update
        } else {
          throw new Error('Unexpected response status: ' + response.status)
        }
      } catch (error) {
        if (error.response && this.handleRateLimit(error.response)) {
          alert(`Too many requests. Please wait ${this.retryAfter} seconds.`)
          return
        }
        console.error('Error saving item:', error)
        let errorMessage = 'An error occurred while saving the item.'
        if (error.response) {
          errorMessage = error.response.data.message || error.response.data.error || JSON.stringify(error.response.data)
        } else if (error.request) {
          errorMessage = 'No response received from server'
        } else {
          errorMessage = error.message
        }
        alert(errorMessage)
      }
    },
    showGallery(type, item) {
      this.currentGalleryItem = item
      if (type === 'programming') {
        this.galleryImages = [this.getImageUrl(item.cropped_image)]
      } else if (type === 'audio') {
        this.galleryImages = [this.getImageUrl(item.image_link)]
      }
      this.currentImageIndex = 0
      this.showGalleryModal = true
    },
    closeGalleryModal() {
      this.showGalleryModal = false
      this.currentGalleryItem = null
      this.galleryImages = []
      this.currentImageIndex = 0
    },
    previousImage() {
      if (this.currentImageIndex > 0) {
        this.currentImageIndex--
      }
    },
    nextImage() {
      if (this.currentImageIndex < this.galleryImages.length - 1) {
        this.currentImageIndex++
      }
    }
  }
}
</script>

<style scoped>
.admin-panel {
  background: #f8f9fa;
  min-height: 100vh;
  padding: 20px 0;
}

.thumbnail {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 4px;
}

.image-preview {
  max-width: 300px;
  margin: 10px 0;
}

.modal {
  background-color: rgba(0, 0, 0, 0.5);
}

.modal.show {
  display: block;
}

.list-group-item {
  background: transparent;
  border: 1px solid rgba(0, 0, 0, 0.125);
}

.card {
  background: white;
  border: none;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-header {
  background: white;
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.gallery-container {
  position: relative;
  width: 100%;
}

.gallery-image-container {
  position: relative;
  width: 100%;
  height: 400px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #f8f9fa;
  border-radius: 8px;
  overflow: hidden;
}

.gallery-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.gallery-navigation {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
  display: flex;
  justify-content: space-between;
  padding: 0 20px;
}

.gallery-navigation button {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.8);
  border: none;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.gallery-navigation button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.gallery-description {
  padding: 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style> 