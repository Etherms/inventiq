<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Categories
                    </h1>
                    <p class="text-sm text-gray-500">
                        Manage product categories.
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                >
                    + Create Category
                </button>
            </div>

            <div class="rounded-xl bg-white p-4 shadow-sm">
                <input
                    type="text"
                    placeholder="Search categories..."
                    class="w-full rounded-lg border px-4 py-2 text-sm outline-none"
                >
            </div>

            <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead class="border-b bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b">
                            <td class="px-4 py-3 font-medium">Electronics</td>
                            <td class="px-4 py-3 text-gray-600">
                                Phones, laptops, and accessories.
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button class="text-sm text-blue-600 hover:underline">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>