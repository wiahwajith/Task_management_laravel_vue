<template>
    <div class="layout">
      <header class="header">
        <h1>Task Manager</h1>
        <div class="user-actions">
          <span v-if="auth.user">Hello, {{ auth.user.name }}</span>
          <button @click="logout">Logout</button>
        </div>
      </header>
  
      <main class="main">
        <router-view />
      </main>
    </div>
  </template>
  
  <script setup>
  import { useAuthStore } from '@/stores/auth'
  import { useRouter } from 'vue-router'
  
  const auth = useAuthStore()
  const router = useRouter()
  
  const logout = () => {
    auth.logout()
    router.push('/login')
  }
  </script>
  
  <style scoped>
  .layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #f0f0f0;
    border-bottom: 1px solid #ccc;
  }
  .main {
    flex: 1;
    padding: 2rem;
  }
  .user-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  button {
    padding: 0.4rem 0.8rem;
  }
  </style>
  