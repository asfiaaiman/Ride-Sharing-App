<template>
    <div class="pt-16">
        <h1 class="mb-4 text-3xl font-semibold">Andrewber</h1>
        <div class="max-w-sm mx-auto overflow-hidden text-left shadow sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="flex justify-between">
                    <button
                        @click="handleStartDriving"
                        class="px-4 py-2 text-sm font-medium text-white bg-black border border-transparent rounded-md shadow-sm hover:bg-gray-600 focus:outline-none">
                        Start Driving
                    </button>
                    <button
                        @click="handleFindARide"
                        class="px-4 py-2 text-sm font-medium text-white bg-black border border-transparent rounded-md shadow-sm hover:bg-gray-600 focus:outline-none">
                        Find A Ride
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>
