<template>
    <div class="max-w-md mx-auto">
      <h2 class="text-xl font-bold mb-4">Edit Task</h2>
      <form @submit.prevent="updateTask">
        <input v-model="form.title" type="text" placeholder="Task Title" class="input mb-2" />
        <textarea v-model="form.description" placeholder="Description" class="input mb-2"></textarea>
        <button type="submit" class="btn">Update</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import { useTaskStore } from '@/stores/task'
  
  const taskStore = useTaskStore()
  const route = useRoute()
  const router = useRouter()
  const form = ref({
    title: '',
    description: ''
  })
  
  onMounted(async () => {
    const task = await taskStore.fetchTask(route.params.id)
    form.value = {
      title: task.title,
      description: task.description
    }
  })
  
  const updateTask = async () => {
    await taskStore.updateTask(route.params.id, form.value)
    router.push('/dashboard')
  }
  </script>
  