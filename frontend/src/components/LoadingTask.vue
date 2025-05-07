<template>
    <div class="loading-spinner">
      <v-progress-circular
        indeterminate
        color="primary"
        size="40"
      />
      <p>{{ message }}</p>
    </div>
  </template>
  
  <script setup>
  defineProps({
    message: {
      type: String,
      default: 'Loading...'
    }
  })
  </script>
  
  <style scoped>
  .loading-spinner {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 2rem;
    color: #757575;
  }
  </style>
  