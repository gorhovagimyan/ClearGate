import store from '../store'

export default async function auth({ next }) {
    const isAuthenticated = await store.dispatch('checkAuth')
    
    if (!isAuthenticated && window.location.pathname !== '/login') {
        window.location.href = '/login'
        return
    }
    
    return next()
} 