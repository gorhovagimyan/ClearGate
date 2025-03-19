<template>
  <AuthenticatedLayout>
    <div class="space-y-4 sm:space-y-6">
      <!-- Stats Grid - Responsive layout with stacking on mobile -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Welcome Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-shadow duration-300 hover:shadow-md">
          <div class="p-4 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
              </div>
              <div class="ml-4 sm:ml-5">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Welcome Back</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $page.props.auth.user.name }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Tasks Card -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-shadow duration-300 hover:shadow-md">
          <div class="p-4 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div class="ml-4 sm:ml-5">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Your Tasks</h3>
                <p class="mt-1 text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $page.props.stats.tasksCount }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Activity Stats -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-shadow duration-300 hover:shadow-md sm:col-span-2 lg:col-span-1">
          <div class="p-4 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-4 sm:ml-5">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Recent Activity</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Last 24 hours</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- User Details Card - Responsive layout -->
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-shadow duration-300 hover:shadow-md">
        <div class="px-4 py-4 sm:px-6 sm:py-5 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">User Details</h3>
        </div>
        <div class="px-4 py-4 sm:px-6 sm:py-5">
          <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-6 gap-y-4 sm:gap-y-5">
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $page.props.auth.user.name }}</dd>
            </div>
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white break-all">{{ $page.props.auth.user.email }}</dd>
            </div>
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Joined Date</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ formatDate($page.props.auth.user.created_at) }}</dd>
            </div>
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Status</dt>
              <dd class="mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                  Active
                </span>
              </dd>
            </div>
          </dl>
        </div>
      </div>
      
      <!-- Quick Actions Section - Added for better mobile experience -->
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-shadow duration-300 hover:shadow-md">
        <div class="px-4 py-4 sm:px-6 sm:py-5 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h3>
        </div>
        <div class="p-4 sm:p-6">
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="/tasks" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
              <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              <span class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tasks</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const formatDate = (date) => {
  if (!date) return ''
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>

<style scoped>
/* Add any component-specific styles here */
@media (max-width: 640px) {
  /* Mobile-specific styles */
  .break-all {
    word-break: break-all;
  }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
  /* Any specific dark mode adjustments can go here */
}
</style> 