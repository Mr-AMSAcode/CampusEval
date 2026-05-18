<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-6">
            <!-- En-tête -->
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center font-bold text-white text-xl">
                        CE
                    </div>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    Créer un compte
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Inscription pour les étudiants
                </p>
            </div>

            <!-- Erreurs -->
            @if ($errors->any())
                <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="rounded-lg shadow-md space-y-4 p-4 bg-white dark:bg-slate-800">
                    <!-- Prénom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prénom</label>
                        <input name="first_name" type="text" 
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            value="{{ old('first_name') }}" required>
                        <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
                    </div>

                    <!-- Nom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                        <input name="last_name" type="text"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            value="{{ old('last_name') }}" required>
                        <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input name="email" type="email"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            value="{{ old('email') }}" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Matricule -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Matricule <span class="text-xs text-gray-500">(GL.CMRY22.23.K ou SR.CMRY21.22.A)</span></label>
                        <input name="matricule" type="text" placeholder="exemple: GL.CMRY22.23.K"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            value="{{ old('matricule') }}" required>
                        <x-input-error :messages="$errors->get('matricule')" class="mt-1" />
                    </div>

                    <!-- Niveau -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Niveau</label>
                        <select name="level"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            required>
                            <option value="">-- Sélectionnez un niveau --</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level }}" @selected(old('level') === $level)>{{ $level }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('level')" class="mt-1" />
                    </div>

                    <!-- Classe -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Classe</label>
                        <select name="class_id"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            required>
                            <option value="">-- Sélectionnez une classe --</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('class_id') === (string)$class->id)>
                                    {{ $class->name }} ({{ $class->department->name }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('class_id')" class="mt-1" />
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mot de passe</label>
                        <input name="password" type="password"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Confirmation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmer mot de passe</label>
                        <input name="password_confirmation" type="password"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700"
                            required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>
                </div>

                <!-- Bouton -->
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Créer un compte
                </button>

                <!-- Lien connexion -->
                <div class="text-center text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Vous avez déjà un compte ?</span>
                    <a href="{{ route('login') }}" class="ml-2 text-blue-600 hover:text-blue-500 dark:text-blue-400 font-medium">
                        Se connecter
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
