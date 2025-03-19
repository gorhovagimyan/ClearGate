<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Mobile Navigation Header -->
        <div class="lg:hidden">
            <div class="bg-white dark:bg-gray-800 shadow-sm">
                <div class="px-4 sm:px-6">
                    <div class="flex items-center justify-between h-16">
                        <!-- Logo/Brand -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Admin Panel</h1>
                            </div>
                        </div>
                        
                        <!-- Mobile menu button -->
                        <div class="flex items-center">
                            <button 
                                @click="mobileMenuOpen = !mobileMenuOpen" 
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                aria-expanded="false"
                            >
                                <span class="sr-only">Open main menu</span>
                                <!-- Icon when menu is closed -->
                                <svg 
                                    v-if="!mobileMenuOpen" 
                                    class="block h-6 w-6" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor" 
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <!-- Icon when menu is open -->
                                <svg 
                                    v-else 
                                    class="block h-6 w-6" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor" 
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state -->
            <div v-if="mobileMenuOpen" class="bg-white dark:bg-gray-800 shadow-md">
                <!-- User Info for Mobile -->
                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center">
                            <span class="text-white text-lg">{{ userInitials }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-base font-medium text-gray-800 dark:text-white">{{ $page.props.auth.user.name }}</p>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $page.props.auth.user.email }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Navigation Links -->
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a 
                        href="/dashboard" 
                        :class="[$page.url === '/dashboard' ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white', 'block pl-3 pr-4 py-2 border-l-4 text-base font-medium']"
                    >
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </div>
                    </a>

                    <a 
                        href="/tasks" 
                        :class="[$page.url === '/tasks' ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white', 'block pl-3 pr-4 py-2 border-l-4 text-base font-medium']"
                    >
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                            </svg>
                            Tasks
                        </div>
                    </a>

                    <form method="POST" action="/logout" class="block">
                        <button 
                            type="submit" 
                            class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white"
                        >
                            <div class="flex items-center">
                                <svg class="mr-3 h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
            <!-- Sidebar component -->
            <div class="flex-1 flex flex-col min-h-0 bg-gray-800">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 bg-gray-900">
                    <h1 class="text-white text-xl font-semibold">Admin Panel</h1>
                </div>
                
                <!-- User Info -->
                <div class="p-4 border-b border-gray-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center">
                            <span class="text-white text-lg">{{ userInitials }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-white">{{ $page.props.auth.user.name }}</p>
                            <p class="text-gray-400 text-sm">{{ $page.props.auth.user.email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="mt-4 space-y-1 px-2">
                    <MenuItem 
                        href="/dashboard"
                        :active="$page.url === '/dashboard'"
                    >
                        <template #icon>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </template>
                        Dashboard
                    </MenuItem>

                    <MenuItem 
                        href="/tasks"
                        :active="$page.url === '/tasks'"
                    >
                        <template #icon>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                            </svg>
                        </template>
                        Tasks
                    </MenuItem>

                    <MenuItem 
                        href="/logout"
                        method="post"
                    >
                        <template #icon>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </template>
                        Logout
                    </MenuItem>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:pl-64 flex flex-col flex-1">
            <main class="flex-1">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <slot></slot>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import MenuItem from '@/Components/MenuItem.vue'

const page = usePage()
const mobileMenuOpen = ref(false)

const userInitials = computed(() => {
    const name = page.props.auth.user.name
    return name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
})
</script>

<style scoped>
/* Add any component-specific styles here */
@media (max-width: 1023px) {
    /* Mobile and tablet specific styles */
    .min-h-screen {
        min-height: 100vh;
        padding-bottom: env(safe-area-inset-bottom);
    }
}

/* Smooth transitions for mobile menu */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(-10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Apply animations */
.lg\:hidden > div:last-child {
    animation: fadeIn 0.3s ease-out;
}

.lg\:hidden > div:last-child > div {
    animation: slideIn 0.3s ease-out;
}
</style> 