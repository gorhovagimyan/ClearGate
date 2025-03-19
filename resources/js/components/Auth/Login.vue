<template>
  <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f5f7fa;">
    <div style="width: 100%; max-width: 400px; padding: 40px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
      <h1 style="text-align: center; margin-bottom: 30px; color: #2c3e50;">Login</h1>
      
      <form @submit.prevent="login">
        <div style="margin-bottom: 20px;">
          <label style="display: block; margin-bottom: 8px; color: #2c3e50;">Email</label>
          <input 
            v-model="form.email"
            type="email"
            required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
          >
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; margin-bottom: 8px; color: #2c3e50;">Password</label>
          <input 
            v-model="form.password"
            type="password"
            required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
          >
        </div>

        <button 
          type="submit"
          style="width: 100%; padding: 12px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;"
        >
          Login
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
  setup() {
    const router = useRouter()
    const form = ref({
      email: '',
      password: ''
    })

    const login = async () => {
      try {
        await axios.post('/login', form.value)
        
        // Get authenticated user
        const response = await axios.get('/api/user')
        
        // Store user data
        localStorage.setItem('user', JSON.stringify(response.data))
        
        // Redirect to dashboard
        router.push('/dashboard')
        
        // Reload page to ensure fresh state
        window.location.reload()
      } catch (error) {
        console.error('Login failed:', error)
      }
    }

    return {
      form,
      login
    }
  }
}
</script> 