    <script setup>
    import { onMounted, ref } from 'vue'
    import axios from 'axios'
    import AppLayout from '../layouts/AppLayout.vue'

    const user = ref(null)
    const checkingAuth = ref(true)

    onMounted(async () => {
        const token = localStorage.getItem('token')

        if (!token) {
            window.location.href = '/login'
            return
        }

        try {
            const res = await axios.get('/api/user', {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json',
                },
            })

            user.value = res.data.user ?? res.data
        } catch (e) {
            localStorage.removeItem('token')
            window.location.href = '/login'
        } finally {
            checkingAuth.value = false
        }
    })
    </script>

    <template>
        <div v-if="checkingAuth" class="min-h-screen bg-gray-100"></div>

        <AppLayout v-else :user="user">
            <h1 class="text-3xl font-bold mb-4">Dashboard</h1>

            <div class="bg-white p-6 rounded-md shadow">
                <p v-if="user" class="text-lg">
                    Welcome, {{ user.name }}
                </p>
            </div>
        </AppLayout>
    </template>