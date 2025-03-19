<template>
  <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
    <div style="width: 400px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
      <h2 style="text-align: center; margin-bottom: 20px; font-size: 24px;">
        Register for an account
      </h2>
      
      <form @submit.prevent="register">
        <div style="margin-bottom: 15px;">
          <label style="display: block; margin-bottom: 5px;">Name</label>
          <input id="name" v-model="form.name" type="text" required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
        </div>

        <div style="margin-bottom: 15px;">
          <label style="display: block; margin-bottom: 5px;">Email address</label>
          <input id="email" v-model="form.email" type="email" required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
        </div>

        <div style="margin-bottom: 15px;">
          <label style="display: block; margin-bottom: 5px;">Password</label>
          <input id="password" v-model="form.password" type="password" required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; margin-bottom: 5px;">Confirm Password</label>
          <input id="password_confirmation" v-model="form.password_confirmation" type="password" required
            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
        </div>

        <button type="submit"
          style="width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
          Register
        </button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    async register() {
      try {
        await axios.post('/register', this.form)
        this.$router.push('/login')
      } catch (error) {
        console.error('Registration failed:', error)
      }
    }
  }
}
</script> 