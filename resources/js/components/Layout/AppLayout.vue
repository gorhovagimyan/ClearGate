<template>
  <div v-if="user" style="display: flex; min-height: 100vh;">
    <!-- Sidebar -->
    <div style="width: 250px; background: #2c3e50; color: white; padding: 20px; position: fixed; height: 100vh;">
      <!-- User Profile Section -->
      <div style="padding: 20px; margin-bottom: 20px; border-bottom: 1px solid #34495e;">
        <div style="text-align: center; margin-bottom: 10px;">
          <div style="width: 80px; height: 80px; background: #34495e; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            {{ user.name.charAt(0).toUpperCase() }}
          </div>
          <h3 style="margin: 0; font-size: 18px;">{{ user.name }}</h3>
          <p style="margin: 5px 0; color: #95a5a6; font-size: 14px;">{{ user.email }}</p>
        </div>
      </div>

      <!-- Navigation Menu -->
      <nav style="display: flex; flex-direction: column; gap: 8px;">
        <router-link to="/dashboard" 
          style="padding: 12px 15px; color: white; text-decoration: none; border-radius: 6px; display: flex; align-items: center; gap: 10px; transition: background 0.3s;"
          :style="$route.path === '/dashboard' ? 'background: #34495e;' : 'hover:background: #34495e;'">
          <span>🏠</span> Dashboard
        </router-link>
        <router-link to="/posts"
          style="padding: 12px 15px; color: white; text-decoration: none; border-radius: 6px; display: flex; align-items: center; gap: 10px; transition: background 0.3s;"
          :style="$route.path === '/posts' ? 'background: #34495e;' : 'hover:background: #34495e;'">
          <span>📝</span> Posts
        </router-link>
        <form @submit.prevent="logout" style="margin-top: auto;">
          <button type="submit" 
            style="width: 100%; padding: 12px 15px; color: white; background: none; border: none; border-radius: 6px; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: background 0.3s;">
            <span>🚪</span> Logout
          </button>
        </form>
      </nav>
    </div>

    <!-- Main Content -->
    <div style="margin-left: 250px; flex: 1; background: #f5f7fa; min-height: 100vh; padding: 20px;">
      <router-view></router-view>
    </div>
  </div>

  <router-view v-else></router-view>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

export default {
  setup() {
    const router = useRouter()
    const user = ref(null)

    onMounted(async () => {
      try {
        const response = await axios.get('/api/user')
        user.value = response.data
      } catch (error) {
        router.push('/login')
      }
    })

    const logout = async () => {
      try {
        await axios.post('/logout')
        user.value = null
        router.push('/login')
      } catch (error) {
        console.error('Logout failed:', error)
      }
    }

    return {
      user,
      logout
    }
  }
}
</script>

<style scoped>
.active-link {
  background: #333;
}
</style> 