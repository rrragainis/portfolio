<template>
  <div class="main-space">
    <LoadingScreen 
      :isLoading="isLoading" 
      :loadingPercentage="loadingPercentage" 
    />
    <section class="top-section">
      <div class="main-pic-1"></div>
      <div class="top-text-and-pic">
        <div class="portfolio-page-name">Ģirts Gagainis - Kagainis</div>
        <div class="portfolio-header">
          <a href="#about-me" class="nav-link">{{ lang === 'lv' ? 'par mani' : 'about me' }}</a><br>
          <a href="#programming" class="nav-link">{{ lang === 'lv' ? 'programmēšanas darbi' : 'programming works' }}</a><br>
          <a href="#audio" class="nav-link">{{ lang === 'lv' ? 'audio' : 'audio' }}</a><br>
          <a href="#visuals" class="nav-link">{{ lang === 'lv' ? 'vizuālie darbi' : 'visual works' }}</a>
          <div class="lang-switch" @click="toggleLang">{{ lang === 'lv' ? 'lv' : 'en' }}</div>
        </div>
        <div class="main-pic-2"></div>
      </div>
    </section>

    <section class="bottom-background">
      <section class="bottom-section">
        <div class="section about-me" id="about-me">
          <h2>{{ lang === 'lv' ? 'par mani' : 'about me' }}</h2>
          <p v-if="lang === 'lv'">
            Mani sauc Ģirts, un jau vairākus gadus aizraujos ar mūziku, mākslu un kultūru kopumā. Šī aizraušanās ar radošumu ir kļuvusi par manu virzītājspēku, un pašlaik aktīvi strādāju, lai to pārvērstu par veiksmīgu profesionālo karjeru. Ikdienā nodarbojos ar muzicēšanu un vizuālo mākslu. Skaņas apstrādei un ierakstīšanai izmantoju Reaper, bet vizuālo materiālu apstrādei  Adobe Photoshop un DaVinci Resolve. Papildus tam arī programmēju. Programmējot izmantoju vairākas valodas: Vue.js, Next.js, Laravel, MySQL, PostgreSQL, C++, JUCE, Python un PHP. Mājaslapu dizainu veidošanai izmantoju Figma. Esmu bijis praksē SIA "All Media Group" priekš TV3 un Rīgas Valsts tehnikumā.
          </p>
          <p v-else>
            My name is Ģirts and I have been passionate about music, art and culture in general for several years. This passion for creativity has become my driving force and I am now actively working to turn it into a successful professional career. I use Reaper when working with audio, and Adobe Photoshop and DaVinci Resolve for visuals. In addition, I also code. I use several programming languages: Vue.js, Next.js, Laravel, MySQL, PostgreSQL, C++, JUCE, Python and PHP. I use Figma for website design. I have interned at SIA "All Media Group" for TV3 and Riga State Technical School.
          </p>
        </div>

        <div class="section programming" id="programming">
          <h2>{{ lang === 'lv' ? 'programmēšanas darbi:' : 'coding:' }}</h2>
          <p>{{ lang === 'lv' ? 'Šie ir programmēšanas projekti, par kuriem jūtos pietiekami labi, lai atrādītu, vai arī, man ļauj atrādīt.' : 'These are coding projects that I have made that I feel confident enough to showcase, or I am allowed to showcase.' }}</p>
          <div class="card-grid">
            <div v-for="item in programmings" :key="item.id" class="work-card" @click="showDetails('programming', item)">
              <img :src="getWebpImage(item.cropped_image)" :alt="item[lang + '_name']" class="work-card-image">
            </div>
          </div>
        </div>

        <div class="section visuals" id="visuals">
          <h2>{{ lang === 'lv' ? 'vizuālie darbi' : 'visual works' }}</h2>
          <p>
            {{ lang === 'lv' ? 
              'Nodarbojos ar vizuālo mākslu arī jau vairākus gadus. Pārsvarā strādāju rīkos kā Photoshop un DaVinci Resolve, bet sāku radīt šajā novirzienā zīmējot un skicējot savus darbus. Šeit ir apskatāmi daži no maniem darbiem.' :
              'I have been working with visual art for several years. I mainly work with tools like Photoshop and DaVinci Resolve, but I started creating in this direction by drawing and sketching my works. Here are some of my works to view.'
            }}
          </p>
          <div class="card-grid">
            <div v-for="item in photoshops" :key="item.id" class="work-card" @click="showDetails('photoshop', item)">
              <img :src="getWebpImage(item.cropped_image)" :alt="item[lang + '_name']" class="work-card-image">
            </div>
          </div>
        </div>

        <div class="section audio" id="audio">
          <h2>{{ lang === 'lv' ? 'audio' : 'audio' }}</h2>
          <p>
            {{ lang === 'lv' ? 
              'Nodarbojos ar instrumentspēli jau pāri divpadsmit gadiem. Esmu apguvis, kā spēlēt ģitāru, basģitāru, bungas, klavieres, kā arī dziedāt un apieties ar sintezatoriem. Sākot no 2024. gada, arī sāku ierakstīt pats citas grupas un rakstīt mūziku pēc pasūtījuma. Šeit var noklausīties pāris no projektiem kuros esmu piedalījies.' :
              'I have been playing instruments for over twelve years. I have learned to play guitar, bass, drums, piano, as well as singing and working with synthesizers. Starting from 2024, I also began recording other bands and writing music on commission. Here you can listen to some of the projects I have been involved in.'
            }}
          </p>
          <div class="card-grid">
            <div v-for="item in audios" :key="item.id" class="work-card" @click="showDetails('audio', item)">
              <img :src="getWebpImage(item.cropped_image)" :alt="item[lang + '_name']" class="work-card-image">
            </div>
          </div>
        </div>

        <div class="section contacts">
          <div class="contact-row">
            <p class="contact-email">rrragainis@gmail.com</p>
            <h2>{{ lang === 'lv' ? 'sazinies ar mani' : 'contact me' }}</h2>
            <a href="https://www.instagram.com/rrragainis/" target="_blank" rel="noopener noreferrer" class="contact-instagram">
              instagram
            </a>
          </div>
        </div>
      </section>
    </section>

    <!-- Details Modal -->
    <div
      class="modal"
      v-if="showModal"
      @click="closeModal"
      :class="{
        'audio-modal': selectedType === 'audio',
        'visual-modal': selectedType === 'photoshop',
        'programming-modal': selectedType === 'programming'
      }"
    >
      <div class="modal-content" @click.stop>
        <button class="close-button" @click="closeModal">&times;</button>
        <!-- AUDIO POPUP -->
        <template v-if="selectedType === 'audio'">
          <div class="audio-popup">
            <div class="audio-row">
              <a :href="selectedItem?.image_link" target="_blank" rel="noopener noreferrer">
                <img
                  :src="getWebpImage(selectedItem?.cropped_image)"
                  :alt="lang === 'lv' ? selectedItem?.latvian_name : selectedItem?.english_name"
                  class="audio-album-art"
                />
              </a>
              <div class="audio-info">
                <div class="audio-title">{{ lang === 'lv' ? selectedItem?.latvian_name : selectedItem?.english_name }}</div>
                <div class="audio-meta">{{ selectedItem?.artist }}</div>
                <div class="audio-meta">{{ selectedItem?.year }}</div>
              </div>
            </div>
            <div class="audio-description">{{ lang === 'lv' ? selectedItem?.latvian_description : selectedItem?.english_description }}</div>
          </div>
          <audio
            v-if="selectedItem?.mp3_file"
            :src="selectedItem.mp3_file"
            controls
            class="audio-player-bar"
          ></audio>
        </template>
        <!-- VISUAL POPUP -->
        <template v-else-if="selectedType === 'photoshop'">
          <div class="visual-popup">
            <a :href="selectedItem?.image_link || selectedItem?.cropped_image" target="_blank" rel="noopener noreferrer">
              <img
                :src="getWebpImage(selectedItem?.image_link || selectedItem?.cropped_image)"
                :alt="lang === 'lv' ? selectedItem?.latvian_name : selectedItem?.english_name"
                class="visual-image"
              />
            </a>
            <div class="visual-content-row">
              <div class="visual-name">{{ lang === 'lv' ? selectedItem?.latvian_name : selectedItem?.english_name }}</div>
              <div class="visual-description">{{ lang === 'lv' ? selectedItem?.latvian_description : selectedItem?.english_description }}</div>
            </div>
          </div>
        </template>
        <!-- PROGRAMMING POPUP -->
        <template v-else-if="selectedType === 'programming'">
          <div class="programming-popup">
            <a :href="selectedItem?.image_link" target="_blank" rel="noopener noreferrer">
              <img
                :src="getWebpImage(selectedItem?.image_link)"
                :alt="lang === 'lv' ? selectedItem?.latvian_name : selectedItem?.english_name"
                class="programming-image"
              />
            </a>
            <div class="programming-content-row">
              <div class="programming-name">{{ lang === 'lv' ? selectedItem?.latvian_name : selectedItem?.english_name }}</div>
              <div class="programming-description">{{ lang === 'lv' ? selectedItem?.latvian_description : selectedItem?.english_description }}</div>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import LoadingScreen from './LoadingScreen.vue'

export default {
  name: 'HelloWorld',
  components: {
    LoadingScreen
  },
  data() {
    return {
      lang: 'lv',
      photoshops: [],
      audios: [],
      programmings: [],
      showModal: false,
      selectedType: null,
      selectedItem: null,
      isLoading: true,
      loadingPercentage: 0,
      preloadedImages: new Map(),
      preloadedAudio: new Map()
    }
  },
  mounted() {
    this.loadData()
  },
  methods: {
    toggleLang() {
      this.lang = this.lang === 'lv' ? 'en' : 'lv';
    },
    async loadData() {
      try {
        this.isLoading = true;
        this.loadingPercentage = 0;

        const [photoshopRes, audioRes, programmingRes] = await Promise.all([
          axios.get('/api/photoshops'),
          axios.get('/api/audio'),
          axios.get('/api/programmings')
        ]);

        this.photoshops = photoshopRes.data;
        this.audios = audioRes.data;
        this.programmings = programmingRes.data;

        // Calculate total items to preload
        const totalItems = this.photoshops.length + this.audios.length + this.programmings.length;
        let loadedItems = 0;

        // Preload images
        const preloadPromises = [];

        // Preload photoshop images
        this.photoshops.forEach(item => {
          preloadPromises.push(this.preloadImage(item.cropped_image));
          preloadPromises.push(this.preloadImage(item.image_link));
        });

        // Preload programming images
        this.programmings.forEach(item => {
          preloadPromises.push(this.preloadImage(item.cropped_image));
          preloadPromises.push(this.preloadImage(item.image_link));
        });

        // Preload audio images and files
        this.audios.forEach(item => {
          preloadPromises.push(this.preloadImage(item.cropped_image));
          preloadPromises.push(this.preloadImage(item.image_link));
          if (item.mp3_file) {
            preloadPromises.push(this.preloadAudio(item.mp3_file));
          }
        });

        // Track loading progress
        for (const promise of preloadPromises) {
          await promise;
          loadedItems++;
          this.loadingPercentage = Math.round((loadedItems / preloadPromises.length) * 100);
        }

        this.isLoading = false;
      } catch (error) {
        console.error('Error loading data:', error);
        this.isLoading = false;
      }
    },
    preloadImage(url) {
      return new Promise((resolve, reject) => {
        if (this.preloadedImages.has(url)) {
          resolve();
          return;
        }

        const img = new Image();
        img.onload = () => {
          this.preloadedImages.set(url, img);
          resolve();
        };
        img.onerror = reject;
        img.src = this.getWebpImage(url);
      });
    },
    preloadAudio(url) {
      return new Promise((resolve, reject) => {
        if (this.preloadedAudio.has(url)) {
          resolve();
          return;
        }

        const audio = new Audio();
        audio.oncanplaythrough = () => {
          this.preloadedAudio.set(url, audio);
          resolve();
        };
        audio.onerror = reject;
        audio.src = url;
      });
    },
    showDetails(type, item) {
      this.selectedItem = item;
      this.selectedType = type;
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.selectedItem = null;
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
.main-space {
  background: #000;
  color: white;
  font-family: 'PT Mono', monospace;
  width: 100%;
  overflow-x: hidden;
  position: relative;
}

.top-section {
  position: relative;
  height: 100vh;
}

.main-pic-1 {
  position: absolute;
  width: 100%;
  height: 100%;
  background: url('@/assets/mainpic1.png') center/cover no-repeat;
  z-index: 0;
}

.main-pic-2 {
  position: absolute;
  top: 40vh;
  left: 60vw;
  width: 12vw;
  height: 35vh;
  background: url('@/assets/mainpic2.png') center/cover no-repeat;
  z-index: 1;
}

.portfolio-page-name {
  position: absolute;
  top: 24px;
  left: 48px;
  font-size: 12px;
  z-index: 2;
}

.portfolio-header {
  padding-top: 8vh;
  position: absolute;
  top: 24px;
  right: 48px;
  width: 284px;
  font-size: 12px;
  z-index: 2;
}

.bottom-background {
  background: url('@/assets/fonapic1.png') top center no-repeat;
  background-size: 100% auto;
  background-attachment: scroll;
  background-repeat: no-repeat;
  width: 100%;
}

.bottom-section {
  padding: 60px;
  max-width: 1086px;
  margin: 0 auto;
}

.section {
  margin-bottom: 80px;
}

.section h2 {
  font-size: 36px;
  margin-bottom: 20px;
}

.section p {
  font-size: 16px;
  line-height: 1.6;
  max-width: 900px;
}

.card-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}

.card-grid.large {
  gap: 20px;
}

.work-card {
  width: 125px;
  height: 125px;
  background: #D9D9D9;
  border-radius: 7px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.2s;
}

.work-card:hover {
  transform: scale(1.05);
}

.work-card-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* Contact section styling */
.contact-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  max-width: 900px;
  margin: 0 auto;
}

.contact-row h2 {
  font-size: 24px;
  margin: 0;
  flex: 1;
  text-align: center;
}

.contact-row p, .contact-row a {
  margin: 0;
  font-size: 16px;
  flex: 1;
  text-align: center;
}

/* Modal styling */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: #eaeaea;
  box-shadow: 0 8px 32px rgba(0,0,0,0.25);
  border-radius: 12px;
  padding: 0;
  max-width: 60vw;
  width: 100%;
  max-height: 80vh;
  min-width: 350px;
  min-height: 350px;
  position: relative;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  margin: 20px;
}

.close-button {
  position: absolute;
  top: 20px;
  left: 20px;
  background: none;
  border: none;
  color: #222;
  font-size: 2rem;
  z-index: 2;
  cursor: pointer;
  padding: 10px;
  margin: -10px;
}

/* AUDIO POPUP */
.audio-popup {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: transparent;
  border-radius: 4px;
  padding: 48px 40px 20px 56px;
  gap: 24px;
  width: 100%;
  box-sizing: border-box;
}

.audio-row {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  gap: 24px;
}

.audio-album-art {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 4px;
}

.audio-info {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  color: #222;
  font-family: 'PT Mono', monospace;
  font-size: 18px;
  word-break: break-word;
  max-width: 100%;
}

.audio-title {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 4px;
}

.audio-meta {
  font-size: 16px;
  margin-bottom: 2px;
}

.audio-description {
  margin-top: 24px;
  font-size: 16px;
  color: #222;
  word-break: break-word;
  width: 100%;
  text-align: center;
}

/* VISUAL & PROGRAMMING POPUP SHARED LAYOUT */
.visual-popup, .programming-popup {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #eaeaea;
  border-radius: 4px;
  padding: 48px 40px 20px 40px;
  width: 100%;
  box-sizing: border-box;
  gap: 24px;
}

.visual-image, .programming-image {
  max-width: 100%;
  max-height: 60vh;
  object-fit: contain;
  border-radius: 4px;
}

.visual-content-row, .programming-content-row {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 16px;
  width: 100%;
}

.visual-name, .programming-name {
  font-size: 18px;
  font-weight: bold;
  color: #222;
}

.visual-description, .programming-description {
  font-size: 16px;
  color: #222;
  word-break: break-word;
  width: 100%;
}

.lang-switch {
  margin-top: 0;
  font-family: 'PT Mono', monospace;
  color: #fff;
  font-size: 12px;
  cursor: pointer;
  background: none;
  border: none;
  font-weight: normal;
  user-select: none;
  transition: opacity 0.2s;
}

.lang-switch:hover {
  opacity: 0.7;
}

.contact-instagram {
  font-family: 'PT Mono', monospace;
  color: #fff;
  font-size: 18px;
  cursor: pointer;
  background: none;
  border: none;
  font-weight: normal;
  user-select: none;
  text-decoration: none;
  transition: opacity 0.2s;
}

.contact-instagram:hover {
  opacity: 0.8;
  text-decoration: none;
}

.nav-link {
  color: white;
  text-decoration: none;
  cursor: pointer;
  transition: opacity 0.2s;
}

.nav-link:hover {
  opacity: 0.7;
}

html {
  scroll-behavior: smooth;
}

.audio-player-bar {
  width: calc(100% - 80px);
  margin: 32px auto 40px auto;
  display: block;
}

@media (max-width: 768px) {
  .card-grid {
    gap: 15px;
    padding: 0 10px;
    justify-content: center;
  }

  .work-card {
    width: calc(50% - 15px);
    height: auto;
    aspect-ratio: 1;
  }

  .audio-player-bar {
    width: calc(100% - 40px);
    margin: 24px auto 32px auto;
  }

  .contact-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    padding: 0 20px;
  }

  .contact-section h2 {
    margin-bottom: 0;
    order: 1;
  }

  .contact-links {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    order: 2;
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
