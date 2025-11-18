<template>
    <div class="flex justify-center items-center h-screen bg-gray-100">
        <div class="w-full max-w-2xl p-8 bg-white rounded-xl shadow-lg transition-all ">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                CPF Formatter
            </h1>

            <div>
                <label for="cpfs" class="block text-sm font-medium text-gray-700 mb-2">
                    Enter the CPF numbers (one per line):
                </label>
                <textarea
                    id="cpfs"
                    v-model="rawCpfs"
                    rows="8"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="000.000.000-00&#10;111.111.111-11&#10;..."
                ></textarea>
            </div>

            <button
                @click="formatCpfs"
                :disabled="isLoading"
                class="w-full mt-4 py-3 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed"
            >
                <span v-if="isLoading">Formatting...</span>
                <span v-else>Format</span>
            </button>

            <div class="mt-4 text-center">
                <div v-if="error" class="text-red-600 bg-red-100 p-3 rounded-lg">
                    {{ error }}
                </div>
            </div>

            <div v-if="formattedCpfs.length > 0" class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    Formatted CPF numbers:
                </h2>
                <ul class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-2 max-h-60 overflow-y-auto">
                    <li
                        v-for="(cpf, index) in formattedCpfs"
                        :key="index"
                        class="text-gray-800 font-mono text-lg p-2 rounded"
                        :class="cpf.includes('inválido') ? 'text-red-500 bg-red-50' : 'bg-green-50 text-green-700'"
                    >
                        {{ cpf }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    const rawCpfs = ref('');
    const formattedCpfs = ref([]);
    const isLoading = ref(false);
    const error = ref(null);

    const API_ENDPOINT = '/api/cpf-formatter';

    const formatCpfs = async () => {
        if (isLoading.value === true) {
            return;
        }
        isLoading.value = true;
        error.value = null;
        formattedCpfs.value = [];

        // Transforma input textarea em array de CPF's
        const cpfsToProcess = rawCpfs.value
            .split('\n')
            .map(cpf => cpf.trim())
            .filter(cpf => cpf.length > 0);

        if (cpfsToProcess.length === 0) {
            isLoading.value = false;
            error.value = "Please enter at least one CPF.";
            return;
        }

        try {
            const response = await fetch(API_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    cpfs: cpfsToProcess
                }),
            });

            // Consome API de formataçao de CPF's
            if (!response.ok) {
                let errorData;

                // Verifica se realmente retornou JSON
                try {
                    errorData = await response.json();
                } catch (jsonError) {
                    throw new Error(`API error: ${response.status} ${response.statusText}.`);
                }

                // Verifica se erro é do laravel
                if (errorData.message && errorData.errors) {
                    const firstErrorField = Object.keys(errorData.errors)[0];
                    if (firstErrorField && errorData.errors[firstErrorField][0]) {
                        error.value = errorData.errors[firstErrorField][0];
                    } else {
                        error.value = errorData.message || "Validation error.";
                    }
                } else {
                    error.value = errorData.message || `API Error: ${response.status} ${response.statusText} .`;
                }
                return;
            }

            // Trata resposta da API
            const responseData = await response.json();
            if (responseData.data) {
                formattedCpfs.value = responseData.data;
            } else {
                throw new Error("Invalid API response.");
            }
        } catch (err) {
            console.error("Failed to format CPF numbers:", err);
            error.value = `Falha to connect to the API '${API_ENDPOINT}'.`;
        } finally {
            isLoading.value = false;
        }
    };
</script>
