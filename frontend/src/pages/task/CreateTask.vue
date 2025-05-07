<template>
    <div class="max-w-md mx-auto">
      <h2 class="text-xl font-bold mb-4">Create Task</h2>
      <form @submit.prevent="createTask">
        <input v-model="form.title" type="text" placeholder="Task Title" class="input mb-2" />
        <textarea v-model="form.description" placeholder="Description" class="input mb-2"></textarea>
        <button type="submit" class="btn">Create</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  import { useTaskStore } from '@/stores/task'
  
  const taskStore = useTaskStore()
  const router = useRouter()
  const form = ref({
    title: '',
    description: ''
  })
  
  const createTask = async () => {
    await taskStore.createTask(form.value)
    router.push('/dashboard')
  }
  </script>
  