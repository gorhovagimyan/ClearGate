<template>
  <div v-if="!isLoading">
    <component 
      :is="page.component" 
      :key="page.component"
      v-bind="page.props" 
    />
  </div>
  <div v-else class="loading">
    Loading...
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { useStore } from 'vuex'

const page = usePage()
const store = useStore()
const isLoading = computed(() => store.state.isLoading)
</script>

<style scoped>
.loading {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  font-size: 1.5rem;
  color: #666;
}
</style> 