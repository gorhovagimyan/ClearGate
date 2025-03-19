<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Mobile Navigation Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm lg:hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <img src="/logo.svg" alt="Logo" class="h-8 w-auto" />
          </div>
          
          <!-- Mobile menu button -->
          <div class="flex items-center">
            <button 
              @click="mobileMenuOpen = !mobileMenuOpen" 
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700"
            >
              <span class="sr-only">Open main menu</span>
              <svg 
                class="h-6 w-6" 
                :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen}" 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg 
                class="h-6 w-6" 
                :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      
      <!-- Mobile menu -->
      <div v-show="mobileMenuOpen" class="lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <a 
            v-for="item in navigationItems" 
            :key="item.name" 
            :href="item.href" 
            :class="[
              currentPath === item.href
                ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-300'
                : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700',
              'block pl-3 pr-4 py-2 border-l-4 text-base font-medium'
            ]"
            @click="mobileMenuOpen = false"
          >
            {{ item.name }}
          </a>
        </div>
      </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
      <div class="flex-1 flex flex-col min-h-0 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
          <div class="flex items-center flex-shrink-0 px-4">
            <img class="h-8 w-auto" src="/logo.svg" alt="Logo" />
          </div>
          <nav class="mt-5 flex-1 px-2 space-y-1">
            <a 
              v-for="item in navigationItems" 
              :key="item.name" 
              :href="item.href" 
              :class="[
                currentPath === item.href
                  ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white'
                  : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white',
                'group flex items-center px-2 py-2 text-sm font-medium rounded-md'
              ]"
            >
              {{ item.name }}
            </a>
          </nav>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="lg:pl-64 flex flex-col flex-1">
      <main class="flex-1">
        <div class="py-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <slot></slot>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const mobileMenuOpen = ref(false);

// Example navigation items - replace with your actual navigation
const navigationItems = [
  { name: 'Dashboard', href: '/dashboard' },
  { name: 'Tasks', href: '/tasks' },
  { name: 'Projects', href: '/projects' },
  { name: 'Settings', href: '/settings' },
];

// Simple way to determine current path
const currentPath = computed(() => {
  return window.location.pathname;
});
</script>

<style>
.nav-link:hover, .nav-link.active {
  background: #34495e;
}
</style> 