import { defineStore } from 'pinia'
import api from '@/services/api'

export const useTaskStore = defineStore('tasks', {
  state: () => ({
    tasks: [],
    pagination: {
      current_page: 1,
      last_page: 1,
    }
  }),
  actions: {
    async fetchTasks(status = '', page = 1) {
      try {
        const res = await api.get('/tasks', {
          params: { status, page }
        })

        const paginated = res.data.data

        this.tasks = paginated.data 
        this.pagination.current_page = paginated.current_page
        this.pagination.last_page = paginated.last_page

      } catch (error) {
        console.error('Error fetching tasks:', error)
        this.tasks = []
        this.pagination.current_page = 1
        this.pagination.last_page = 1
      }
    },
    async getTask(id) {
      try {
        const response = await api.get(`/tasks/${id}`)
        return response.data.data 
      } catch (error) {
        console.error('Failed to fetch task:', error)
        throw new Error('Could not fetch task')
      }
    },
    async addTask(task) {
      await api.post('/tasks', task)
      await this.fetchTasks()
    },
    async updateTask(id, task) {
      await api.put(`/tasks/${id}`, task)
      await this.fetchTasks()
    },
    async deleteTask(id) {
      await api.delete(`/tasks/${id}`)
      this.tasks = this.tasks.filter(t => t.id !== id)
    },
    async completeTask(id) {
      await api.patch(`/tasks/${id}/complete`)
      await this.fetchTasks()
    },
  }
})
