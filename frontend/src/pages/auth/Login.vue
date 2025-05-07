<template>
    <div class="login-container">
      <h2>Login</h2>
      <form @submit.prevent="handleLogin">
        <input v-model="form.email" type="email" placeholder="Email" required />
        <input v-model="form.password" type="password" placeholder="Password" required />
        <button type="submit" :disabled="loading">{{ loading ? 'Logging in...' : 'Login' }}</button>
        <p v-if="error" class="error">{{ error }}</p>
      </form>
      <router-link to="/register">Don't have an account? Register</router-link>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  import { useAuthStore } from '@/stores/auth'
  
  const auth = useAuthStore()
  const router = useRouter()
  
  const form = ref({ email: '', password: '' })
  const error = ref(null)
  const loading = ref(false)
  
  const handleLogin = async () => {
    error.value = null
    loading.value = true
    try {
      await auth.login(form.value)
      router.push('/dashboard')
      console.log('user loged');
      
    } catch (err) {
      error.value = err.message || 'Login failed'
    } finally {
      loading.value = false
    }
  }
  </script>
  
  <style scoped>
  .login-container {
    max-width: 400px;
    margin: auto;
    padding: 2rem;
    border: 1px solid #ddd;
    border-radius: 8px;
  }
  input {
    display: block;
    width: 100%;
    margin-bottom: 1rem;
    padding: 0.5rem;
  }
  button {
    width: 100%;
    padding: 0.5rem;
  }
  .error {
    color: red;
    margin-top: 0.5rem;
  }
  </style>
  