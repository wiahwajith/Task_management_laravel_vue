<template>
  <div class="task-form">
    <div class="header">
      <h2>Edit Task</h2>
    </div>

    <v-form v-if="loaded" ref="formRef" v-model="formIsValid" @submit.prevent="updateTask">
      <v-text-field
        v-model="form.title"
        label="Title"
        :rules="[rules.required]"
        outlined
        required
      ></v-text-field>

      <v-textarea
        v-model="form.description"
        label="Description"
        :rules="[rules.required]"
        outlined
        auto-grow
        required
      ></v-textarea>

      <v-btn type="submit" :disabled="loading || !formIsValid" color="primary" block>
        {{ loading ? 'Updating...' : 'Update Task' }}
      </v-btn>

      <v-alert v-if="error" type="error" class="mt-3">{{ error }}</v-alert>
    </v-form>

    <div v-else class="loading">Loading task...</div>

    <router-link to="/dashboard" class="back-link">← Back to Dashboard</router-link>
    <LoadingTask v-if="loading" message="Editing tasks..." />
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useTaskStore } from '@/stores/tasks'
import LoadingTask from '@/components/LoadingTask.vue'

const router = useRouter()
const route = useRoute()
const taskStore = useTaskStore()

const form = ref({
  title: '',
  description: '',
})

const loading = ref(false)
const error = ref(null)
const loaded = ref(false)
const formRef = ref(null)
const formIsValid = ref(false)

const rules = {
  required: v => !!v || 'This field is required',
}

const fetchTask = async () => {
  try {
    const task = await taskStore.getTask(route.params.id)
    form.value = {
      title: task.title,
      description: task.description
    }
    loaded.value = true
  } catch (err) {
    error.value = err.message || 'Failed to load task'
  }
}

const updateTask = async () => {
  const isValid = await formRef.value?.validate()
  if (!isValid.valid) return

  loading.value = true
  error.value = null
  try {
    await taskStore.updateTask(route.params.id, form.value)
    router.push('/dashboard')
  } catch (err) {
    error.value = err.message || 'Failed to update task'
  } finally {
    loading.value = false
  }
}

onMounted(fetchTask)

</script>

<style scoped>
.task-form {
  max-width: 600px;
  margin: auto;
  padding: 2rem;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.header {
  text-align: center;
}

h2 {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

input,
textarea {
  width: 100%;
  margin-bottom: 1.5rem;
  padding: 0.75rem;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  box-sizing: border-box;
}

button.primary-btn {
  background-color: #1976d2;
  color: white;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  width: 100%;
}

button.primary-btn:disabled {
  background-color: #b0bec5;
  cursor: not-allowed;
}

.error {
  color: red;
  margin-top: 0.5rem;
  text-align: center;
}

.loading {
  text-align: center;
  font-size: 1.2rem;
  color: #757575;
}

.back-link {
  display: block;
  text-align: center;
  margin-top: 2rem;
  font-size: 1rem;
  color: #1976d2;
  text-decoration: none;
}

.back-link:hover {
  text-decoration: underline;
}
</style>
