<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('global.head');
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div id="app" class="w-full max-w-2xl p-8 bg-white rounded-xl shadow-lg transition-all">

        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            Formatador de CPFs
        </h1>

        <!-- Seção de Input -->
        <div>
            <label for="cpfs" class="block text-sm font-medium text-gray-700 mb-2">
                Insira os CPFs (um por linha):
            </label>
            <textarea
                id="cpfs"
                v-model="rawCpfs"
                rows="8"
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="00000000000&#10;11111111111&#10;..."
            ></textarea>
        </div>

        <!-- Botão de Ação -->
        <button
            @click="formatCpfs"
            :disabled="isLoading"
            class="w-full mt-4 py-3 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed"
        >
            <!-- Mostra texto diferente durante o carregamento -->
            <span v-if="isLoading">Formatando...</span>
            <span v-else>Formatar</span>
        </button>

        <!-- Seção de Feedback (Erro ou Loading) -->
        <div class="mt-4 text-center">
            <!-- Mensagem de Erro -->
            <div v-if="error" class="text-red-600 bg-red-100 p-3 rounded-lg">
                {{ error }}
            </div>
        </div>

        <!-- Seção de Resultados -->
        <div v-if="formattedCpfs.length > 0" class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                CPFs Formatados:
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
    </body>
</html>
