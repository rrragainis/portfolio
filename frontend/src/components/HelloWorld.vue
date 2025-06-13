<template>
  <div class="main-space">
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
            Mani sauc Ģirts. Jau vairākus gadus man interesē viss, kas ir saistīts ar mūziku un jebkāda cita veida kultūru.
            Pašlaik cenšos pārvērst savu mīlestību pret mākslu un radošumu par karjeru.
            Jau labu laiku nodarbojos ar muzicēšanu un mākslu. Ikdienā izmantoju rīkus kā Reaper audio
            apstrādei un ierakstīšanai, kā arī Photoshop un DaVinci vizuālo mēdiju apstrādei.
            Vēl arī es programmēju! Es programmēju izmantojot valodas kā:
            Vue.js; Next.js; Laravel; MySQL; PostgreSQL; C++; JUCE; Python; PHP.
            Pārsvarā visus dizainus mājaslapām radu aplikācijā Figma.
            Esmu bijis praksē SIA "All Media Group" priekš TV3 un esmu pašlaik praksē Rīgas Valsts tehnikumā.
          </p>
          <p v-else>
            My name is Ģirts. For several years, I have been interested in everything related to music and all kinds of culture.
            Currently, I am trying to turn my love for art and creativity into a career.
            For a long time, I have been involved in music and art. On a daily basis, I use tools like Reaper for audio
            editing and recording, as well as Photoshop and DaVinci for visual media editing.
            I also program! I use languages like:
            Vue.js; Next.js; Laravel; MySQL; PostgreSQL; C++; JUCE; Python; PHP.
            I mostly design websites in Figma.
            I have interned at SIA "All Media Group" for TV3 and am currently interning at Riga State Technical School.
          </p>
        </div>

        <div class="section programming" id="programming">
          <h2>{{ lang === 'lv' ? 'programmēšanas darbi:' : 'coding:' }}</h2>
          <p>{{ lang === 'lv' ? 'Šie ir programmēšanas projekti, par kuriem jūtos pietiekami labi, lai atrādītu, vai arī, man ļauj atrādīt.' : 'These are coding projects that I have made that I feel confident enough to showcase, or I am allowed to showcase.' }}</p>
          <div class="card-grid">
            <div v-for="item in programmings" :key="item.id" class="work-card" @click="showDetails('programming', item)">
              <img :src="item.cropped_image" :alt="lang === 'lv' ? item.latvian_name : item.english_name" class="work-card-image">
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
          <div class="card-grid large">
            <div v-for="item in photoshops" :key="item.id" class="work-card" @click="showDetails('photoshop', item)">
              <img :src="item.cropped_image" :alt="lang === 'lv' ? item.latvian_name : item.english_name" class="work-card-image">
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
              <img :src="item.cropped_image" :alt="lang === 'lv' ? item.latvian_name : item.english_name" class="work-card-image">
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
                  :src="selectedItem?.cropped_image"
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
                :src="selectedItem?.image_link || selectedItem?.cropped_image"
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
                :src="selectedItem?.image_link"
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

export default {
  name: 'HelloWorld',
  data() {
    return {
      photoshops: [],
      audios: [],
      programmings: [],
      showModal: false,
      selectedItem: null,
      selectedType: null,
      lang: 'lv',
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
        const [photoshopRes, audioRes, programmingRes] = await Promise.all([
          axios.get('/api/photoshops'),
          axios.get('/api/audio'),
          axios.get('/api/programmings')
        ])
        console.log('Photoshop data:', photoshopRes.data)
        console.log('Audio data:', audioRes.data)
        console.log('Programming data:', programmingRes.data)
        
        this.photoshops = photoshopRes.data
        this.audios = audioRes.data
        this.programmings = programmingRes.data
      } catch (error) {
        console.error('Error loading data:', error)
      }
    },
    showDetails(type, item) {
      this.selectedItem = item
      this.selectedType = type
      this.showModal = true
    },
    closeModal() {
      this.showModal = false
      this.selectedItem = null
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
  background: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal.audio-modal,
.modal.visual-modal,
.modal.programming-modal {
  background: rgba(0, 0, 0, 0.8);
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
.audio-player-bar {
  width: 90%;
  margin: 32px auto 0 auto;
  display: block;
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

@media (max-width: 768px) {
  .modal-content {
    max-width: 90vw;
    min-width: unset;
    margin: 20px;
  }

  .close-button {
    top: 10px;
    left: 10px;
  }

  .audio-popup, .visual-popup, .programming-popup {
    padding: 48px 20px 20px 20px;
  }

  .audio-album-art {
    width: 150px;
    height: 150px;
  }

  .audio-info {
    font-size: 16px;
  }

  .audio-title {
    font-size: 16px;
  }

  .audio-meta {
    font-size: 14px;
  }

  .audio-description {
    font-size: 14px;
  }

  .visual-name, .programming-name {
    font-size: 16px;
  }

  .visual-description, .programming-description {
    font-size: 14px;
  }
}
</style>
