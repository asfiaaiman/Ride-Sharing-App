<script setup>
    // Functionality of component lies here
    import { vMaska } from "maska"
    import { computed, onMounted, reactive, ref } from "vue"
    import axios from 'axios'
    import { useRouter } from "vue-router";

    const router = useRouter()

    const credentials = reactive({
        phone: null,
    })

    const waitingOnVerification = ref(false)

    onMounted(() => {
        if(localStorage.getItem('token')) {
            router.push({
                name: 'landing'
            })
        }
    })

    const formattedCredentials = computed(() => {
        return {
            phone: credentials.phone.replaceAll(' ', '').replace('(', '').replace(')', ''),
            login_code: credentials.login_code
        }
    })

    const handleLogin = () => {
        axios.post('http://127.0.0.1:8000/api/login', formattedCredentials)
            .then(function (response) {
            console.log(response)
            waitingOnVerification.value = true
            })
            .catch(function (error) {
                console.log(error)
             })
    }

    const handleVerification = () => {
        axios.post('http://127.0.0.1:8000/api/login/verify', formattedCredentials)
           .then(function (response) {
                console.log(response) //auth token
                localStorage.setItem('token', response.data)
                router.push({
                    name: 'landing'
                })
            })
            .catch(function (error) {
                console.log(error)
             })
    }
</script>
<template>
    <!-- Markup of component lies here -->
    <div class="pt-16">
        <h1 class="mb-4 text-3xl font-semibold">Enter your phone number</h1>
        <form v-if="!waitingOnVerification" action="#" @submit.prevent="handleLogin">
            <div class="max-w-sm mx-auto overflow-hidden text-left shadow sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div>
                        <input type="text" v-maska data-maska="## (####) #######" v-model="credentials.phone" name="phone" id="phone" placeholder="92 (2344) 5678900"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:border-black focus:outline-none">
                    </div>
                </div>
                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                    <button type="submit" @submit.prevent="handleLogin"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-black border border-transparent rounded-md shadow-sm hover:bg-gray-600 focus:outline-none">Continue</button>
                </div>
            </div>
        </form>

        <form v-else action="#" @submit.prevent="handleLogin">
            <div class="max-w-sm mx-auto overflow-hidden text-left shadow sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div>
                        <input type="text" v-maska data-maska="## (####) #######" v-model="credentials.phone" name="phone" id="phone" placeholder="92 (2344) 5678900"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:border-black focus:outline-none">
                    </div>
                </div>
                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                    <button type="submit" @submit.prevent="handleLogin"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-black border border-transparent rounded-md shadow-sm hover:bg-gray-600 focus:outline-none">Continue</button>
                </div>
            </div>
        </form>

    </div>
</template>
<style>
    /* Styling of component lies here */
</style>
