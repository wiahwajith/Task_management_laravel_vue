import { defineStore } from 'pinia';
import api from '@/services/api';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    async login(credentials) {
      try {
        const res = await api.post('/login', credentials);
        this.token = res.data.data.token;
        this.user = res.data.data.user;
        localStorage.setItem('token', this.token);
      } catch (error) {
        throw new Error(error.message || 'Login failed');
      }
    },

    async register(data) {
      try {
        const res = await api.post('/register', data);
        this.token = res.data.data.token;
        this.user = res.data.data.user;
        localStorage.setItem('token', this.token);
      } catch (error) {
        throw new Error(error.message || 'Registration failed');
      }
    },

    logout() {
      this.token = null;
      this.user = null;
      localStorage.removeItem('token');
    },

    async fetchUser() {
      try {
        const res = await api.get('/me');
        this.user = res.data.data;
      } catch (error) {
        console.error('Failed to fetch user:', error);
      }
    }
  }
});
