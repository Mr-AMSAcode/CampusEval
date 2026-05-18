<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- En-tête -->
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center font-bold text-white text-xl">
                        CE
                    </div>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    CampusEval
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Connectez-vous à votre compte
                </p>
            </div>

            <!-- Messages -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            @if ($errors->any())
                <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                Erreur de connexion
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                {{ $errors->first('email') ?: $errors->first() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulaire -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="rounded-lg shadow-md space-y-4 p-4 bg-white dark:bg-slate-800">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Adresse email
                        </label>
                        <input id="email" name="email" type="email" 
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            placeholder="admin@campuseval.test"
                            value="{{ old('email') }}"
                            required autofocus autocomplete="email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Mot de passe
                        </label>
                        <input id="password" name="password" type="password"
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            placeholder="••••••••"
                            required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember me -->
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Se souvenir de moi</span>
                    </label>
                </div>

                <!-- Bouton -->
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Se connecter
                </button>

                <!-- Liens -->
                <div class="flex items-center justify-between text-sm">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400">
                            Mot de passe oublié ?
                        </a>
                    @endif
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400">
                        Créer un compte
                    </a>
                </div>
            </form>

            <!-- Info -->
            <div class="text-center text-xs text-gray-500 dark:text-gray-400 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <strong>Admin :</strong> admin@campuseval.test / CampusEval!2026
            </div>
        </div>
    </div>
</x-guest-layout>
