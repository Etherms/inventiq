<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Pencil, KeyRound } from 'lucide-vue-next'

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
})

const editingUser = ref(null)

const form = ref({
    name: '',
    email: '',
})

function editUser(user) {
    editingUser.value = user

    form.value = {
        name: user.name,
        email: user.email,
    }
}

function updateUser() {
    router.put(`/users/${editingUser.value.id}`, form.value, {
        onSuccess: () => {
            editingUser.value = null
        },
    })
}

function sendPasswordReset(user) {
    router.post(`/users/${user.id}/send-password-reset`)
}
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Users</h1>
                <p class="text-sm text-gray-500">
                    Manage user accounts, edit details, and send password reset links.
                </p>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-semibold uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Registered</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="user in users" :key="user.id">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ user.name }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ user.email }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ new Date(user.created_at).toLocaleDateString() }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button
                                        @click="editUser(user)"
                                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-2 text-xs font-medium hover:bg-gray-50"
                                    >
                                        <Pencil class="h-4 w-4" />
                                        Edit
                                    </button>

                                    <button
                                        @click="sendPasswordReset(user)"
                                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-2 text-xs font-medium hover:bg-gray-50"
                                    >
                                        <KeyRound class="h-4 w-4" />
                                        Reset Password
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="users.length === 0">
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                v-if="editingUser"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
            >
                <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-semibold text-gray-900">
                        Edit User
                    </h2>

                    <form @submit.prevent="updateUser" class="space-y-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                Name
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2"
                            />
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                Email
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2"
                            />
                        </div>

                        <div class="flex justify-end gap-2 pt-4">
                            <button
                                type="button"
                                @click="editingUser = null"
                                class="rounded-lg border px-4 py-2 text-sm"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>