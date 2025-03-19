<script>
export default {
  methods: {
    async logout() {
      try {
        await axios.post('/logout')
        this.$store.dispatch('setUser', null)
        this.$router.push('/login')
      } catch (error) {
        console.error('Logout failed:', error)
      }
    }
  }
}
</script> 