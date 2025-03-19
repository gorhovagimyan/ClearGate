<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full mx-4">
      <div class="bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-center mb-8">Login</h1>
        
        <form @submit.prevent="submit">
          <!-- Email -->
          <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">
              Email
            </label>
            <input
              v-model="form.email"
              type="email"
              class="w-full px-3 py-2 border rounded-lg"
              required
            >
            <div v-if="errors.email" class="text-red-500 text-sm mt-1">
              {{ errors.email }}
            </div>
          </div>

          <!-- Password -->
          <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">
              Password
            </label>
            <input
              v-model="form.password"
              type="password"
              class="w-full px-3 py-2 border rounded-lg"
              required
            >
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 disabled:opacity-50"
          >
            {{ loading ? 'Loading...' : 'Login' }}
          </button>
        </form>

        <!-- Register Section -->
        <div class="mt-6 border-t border-gray-200 pt-6">
          <div class="text-center">
            <p class="text-sm text-gray-600">Don't have an account?</p>
            <Link
              href="/register"
              class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
              Register Now
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

export default {
    name: 'Login',
    setup() {
        const form = useForm({
            email: '',
            password: ''
        })

        const loading = ref(false)

        const submit = () => {
            loading.value = true
            form.post('/login', {
                onFinish: () => loading.value = false,
                preserveScroll: true
            })
        }

        return {
            form,
            loading,
            submit,
            errors: form.errors,
            Link
        }
    }
}
</script>

<style scoped>
.min-h-screen {
    min-height: 100vh;
}
.flex {
    display: flex;
}
.items-center {
    align-items: center;
}
.justify-center {
    justify-content: center;
}
.bg-gray-100 {
    background-color: #f3f4f6;
}
.max-w-md {
    max-width: 28rem;
}
.w-full {
    width: 100%;
}
.mx-4 {
    margin-left: 1rem;
    margin-right: 1rem;
}
.bg-white {
    background-color: white;
}
.p-8 {
    padding: 2rem;
}
.rounded-lg {
    border-radius: 0.5rem;
}
.shadow-md {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.mb-6 {
    margin-bottom: 1.5rem;
}
.mb-8 {
    margin-bottom: 2rem;
}
.mb-2 {
    margin-bottom: 0.5rem;
}
.text-2xl {
    font-size: 1.5rem;
}
.text-sm {
    font-size: 0.875rem;
}
.font-bold {
    font-weight: 700;
}
.text-center {
    text-align: center;
}
.text-gray-700 {
    color: #374151;
}
.text-gray-600 {
    color: #4b5563;
}
.text-red-500 {
    color: #ef4444;
}
.border {
    border-width: 1px;
    border-color: #e5e7eb;
}
.px-3 {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
}
.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}
.bg-blue-500 {
    background-color: #3b82f6;
}
.hover\:bg-blue-600:hover {
    background-color: #2563eb;
}
.text-white {
    color: white;
}
.disabled\:opacity-50:disabled {
    opacity: 0.5;
}
</style> 