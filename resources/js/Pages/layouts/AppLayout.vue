<script setup>
function logout(){
    localStorage.removeItem('token')
    window.location.href = '/login'
}
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b px-6 py-4 flex justify-between">
            <h1 class="font-bold">Inventiq</h1>
            <button @click="logout" class="text-sm bg-red-600 text-white px-4 py-2 rounded">
                logout
            </button>
        </nav>

        <main class="p-6">
            <slot />
        </main>
    </div>
</template>