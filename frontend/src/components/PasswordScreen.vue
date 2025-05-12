<template>
  <div class="password-screen">
    <div class="password-container">
      <h2>Admin Access</h2>
      <form @submit.prevent="checkPassword" class="password-form">
        <div class="form-group">
          <label for="password1">Password 1</label>
          <input 
            type="password" 
            id="password1" 
            v-model="passwords.password1" 
            required
            class="form-control"
          >
        </div>
        <div class="form-group">
          <label for="password2">Password 2</label>
          <input 
            type="password" 
            id="password2" 
            v-model="passwords.password2" 
            required
            class="form-control"
          >
        </div>
        <div class="form-group">
          <label for="password3">Password 3</label>
          <input 
            type="password" 
            id="password3" 
            v-model="passwords.password3" 
            required
            class="form-control"
          >
        </div>
        <button type="submit" class="btn btn-primary">Access Admin Panel</button>
      </form>
      <p v-if="error" class="error-message">{{ error }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PasswordScreen',
  data() {
    return {
      passwords: {
        password1: '',
        password2: '',
        password3: ''
      },
      error: '',
      correctPasswords: {
        password1: 'Lotte3772!',
        password2: 'Jana3772!',
        password3: 'Maris3772!'
      },
      retryAfter: 0,
      rateLimitTimer: null
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
    checkPassword() {
      // Sanitize inputs
      const sanitizedPasswords = {
        password1: this.sanitizeInput(this.passwords.password1),
        password2: this.sanitizeInput(this.passwords.password2),
        password3: this.sanitizeInput(this.passwords.password3)
      }

      if (
        sanitizedPasswords.password1 === this.correctPasswords.password1 &&
        sanitizedPasswords.password2 === this.correctPasswords.password2 &&
        sanitizedPasswords.password3 === this.correctPasswords.password3
      ) {
        // Store authentication state
        localStorage.setItem('adminAuthenticated', 'true')
        // Emit event to parent
        this.$emit('authenticated')
      } else {
        this.error = 'Incorrect passwords. Please try again.'
        this.passwords = {
          password1: '',
          password2: '',
          password3: ''
        }
      }
    }
  },
  beforeUnmount() {
    if (this.rateLimitTimer) {
      clearInterval(this.rateLimitTimer)
    }
  }
}
</script>

<style scoped>
.password-screen {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #f8f9fa;
}

.password-container {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

.password-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-control {
  padding: 0.5rem;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 1rem;
}

.btn-primary {
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
}

.btn-primary:hover {
  background: #0056b3;
}

.error-message {
  color: #dc3545;
  margin-top: 1rem;
  text-align: center;
}

h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  color: #333;
}
</style> 