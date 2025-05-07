<template>
  <div class="dashboard">
    <div class="header">
      <h2 class="dashboard-title">Task Dashboard</h2>
      <router-link to="/dashboard/create">
        <v-btn color="primary" class="create-btn">+ Create Task</v-btn>
      </router-link>
    </div>

    <div class="filters">
      <v-btn class="filter-btn" @click="setFilter('')" :color="filter === '' ? 'primary' : 'default'">
        All
      </v-btn>
      <v-btn class="filter-btn" @click="setFilter('pending')" :color="filter === 'pending' ? 'primary' : 'default'">
        Pending
      </v-btn>
      <v-btn class="filter-btn" @click="setFilter('completed')" :color="filter === 'completed' ? 'primary' : 'default'">
        Completed
      </v-btn>
    </div>

    <div v-if="loading" class="loading">Loading tasks...</div>

    <div v-else-if="tasks.length === 0" class="no-tasks">No tasks found.</div>

    <ul class="task-list" v-else>
      <li v-for="task in tasks" :key="task.id" class="task-item">
        <div class="task-details">
          <h3>Task No: {{ String(task.id).padStart(3, '0') }}</h3>
          <h3 :class="{ done: task.status === 'completed' }">{{ task.title }}</h3>
          <p>{{ task.description }}</p>
          <p>Status: <strong>{{ task.status }}</strong></p>
        </div>
        <div class="actions">
          <router-link :to="`/dashboard/edit/${task.id}`">
            <v-btn small color="info">Edit</v-btn>
          </router-link>
          <v-btn small color="success" @click="completeTask(task.id)" :disabled="task.status === 'completed'">
            Complete
          </v-btn>
          <v-btn small color="error" @click="openDeleteDialog(task.id)">
            Delete
          </v-btn>
        </div>
      </li>
    </ul>

    <!-- Vuetify Pagination -->
    <v-pagination v-if="totalPages > 1" v-model="currentPage" :length="totalPages" :total-visible="5" class="mt-4"
      @update:modelValue="fetchTasks" :disabled="loading" color="primary" />

    <div v-if="tasks.length > 0 && totalPages > 1" class="pagination-info">
      Page {{ currentPage }} of {{ totalPages }}
    </div>
    <LoadingTask v-if="loading" message="Loading tasks..." />
    <v-dialog v-model="deleteDialog" max-width="400">
      <v-card>
        <v-card-title class="text-h6">Confirm Deletion</v-card-title>
        <v-card-text>Are you sure you want to delete this task?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey" text @click="deleteDialog = false">Cancel</v-btn>
          <v-btn color="error" text @click="deleteTask">Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useTaskStore } from '@/stores/tasks'
import LoadingTask from '@/components/LoadingTask.vue'

const taskStore = useTaskStore()

const loading = ref(true)
const filter = ref('')
const currentPage = ref(1)
const deleteDialog = ref(false)
const taskToDelete = ref(null)

const fetchTasks = async () => {
  loading.value = true
  await taskStore.fetchTasks(filter.value, currentPage.value)
  loading.value = false
}

const setFilter = (value) => {
  filter.value = value
  currentPage.value = 1
}

const deleteTask = async (id) => {
  deleteDialog.value = false
  if (taskToDelete.value !== null) {
    await taskStore.deleteTask(taskToDelete.value)
    taskToDelete.value = null
    await fetchTasks()
  }
}

const openDeleteDialog = (id) => {
  taskToDelete.value = id
  deleteDialog.value = true
}

const completeTask = async (id) => {
  await taskStore.completeTask(id)
  await fetchTasks()
}

onMounted(fetchTasks)
watch([filter, currentPage], fetchTasks)

const tasks = computed(() => taskStore.tasks)
const totalPages = computed(() => taskStore.pagination.last_page)
</script>

<style scoped>
.dashboard {
  max-width: 900px;
  margin: auto;
  padding: 2rem;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.dashboard-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.create-btn {
  padding: 0.7rem 1.2rem;
}

.filters {
  margin: 1rem 0;
  display: flex;
  justify-content: space-between;
}

.filter-btn {
  width: 30%;
}

.task-list {
  list-style: none;
  padding: 0;
  margin-top: 2rem;
}

.task-item {
  display: flex;
  justify-content: space-between;
  border: 1px solid #e0e0e0;
  padding: 1.2rem;
  margin-bottom: 1.5rem;
  border-radius: 8px;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.task-details {
  flex: 1;
}

.task-details h3.done {
  text-decoration: line-through;
  color: green;
}

.actions {
  display: flex;
  gap: 10px;
  align-items: center;
}

.v-pagination {
  margin-top: 20px;
  display: flex;
  justify-content: center;
}

.pagination-info {
  text-align: center;
  margin-top: 1rem;
  font-size: 1rem;
  color: #616161;
}

.loading,
.no-tasks {
  text-align: center;
  margin-top: 2rem;
  color: #757575;
}

.loading-spinner {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 2rem;
  color: #757575;
}
</style>
