<template>
  <div class="task-form">
    <v-container>
      <h2 class="task-form-title">Create New Task</h2>

      <v-form ref="formRef" v-model="formIsValid" @submit.prevent="createTask">
        <v-text-field
          v-model="form.title"
          label="Title"
          outlined
          :rules="[rules.required]"
          required
        ></v-text-field>

        <v-textarea
          v-model="form.description"
          label="Description"
          outlined
          :rules="[rules.required]"
          auto-grow
          required
        ></v-textarea>

        <v-btn
          type="submit"
          :disabled="loading || !formIsValid"
          color="primary"
          block
        >
          {{ loading ? 'Creating...' : 'Create Task' }}
        </v-btn>

        <v-alert v-if="error" type="error" class="mt-3">{{ error }}</v-alert>
      </v-form>

      <router-link to="/dashboard">
        <v-btn text>← Back to Dashboard</v-btn>
      </router-link>
    </v-container>
    <LoadingTask v-if="loading" message="Creating task..." />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useTaskStore } from '@/stores/tasks'
import LoadingTask from '@/components/LoadingTask.vue'

const router = useRouter()
const taskStore = useTaskStore()

const form = ref({
  title: '',
  description: '',
})

const formRef = ref(null)
const formIsValid = ref(false)
const error = ref(null)
const loading = ref(false)

const rules = {
  required: (v) => !!v || 'This field is required',
}

const createTask = async () => {
  const isValid = await formRef.value?.validate()
  if (!isValid.valid) return

  error.value = null
  loading.value = true
  try {
    await taskStore.addTask(form.value)
    router.push('/dashboard')
  } catch (err) {
    error.value = err.message || 'Task creation failed'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.task-form {
  max-width: 600px;
  margin: auto;
  padding: 2rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.task-form-title {
  font-size: 1.75rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

v-btn {
  margin-top: 1rem;
}

.error {
  margin-top: 1rem;
}
</style>
