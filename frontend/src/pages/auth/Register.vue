<template>
    <div class="register-container">
      <h2>Register</h2>
      <form @submit.prevent="handleRegister">
        <input v-model="form.name" type="text" placeholder="Name" required />
        <input v-model="form.email" type="email" placeholder="Email" required />
        <input v-model="form.password" type="password" placeholder="Password" required />
        <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" required />
        <button type="submit" :disabled="loading">{{ loading ? 'Registering...' : 'Register' }}</button>
        <p v-if="error" class="error">{{ error }}</p>
      </form>
      <router-link to="/login">Already have an account? Login</router-link>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  import { useAuthStore } from '@/stores/auth'
  
  const auth = useAuthStore()
  const router = useRouter()
  
  const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
  })
  const error = ref(null)
  const loading = ref(false)
  
  const handleRegister = async () => {
    error.value = null
    loading.value = true
    try {
      await auth.register(form.value)
      router.push('/dashboard')
    } catch (err) {
      error.value = err.message || 'Registration failed'
    } finally {
      loading.value = false
    }
  }
  </script>
  
  <style scoped>
  .register-container {
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
  