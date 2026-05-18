<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- En-tête -->
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center font-bold text-white text-xl">
                        CE
                    </div>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    CampusEval
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Créez votre compte étudiant
                </p>
            </div>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                    <div class="text-sm text-red-700 dark:text-red-300">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-4 space-y-4">
                    <!-- Prénom -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Prénom
                        </label>
                        <input type="text" id="first_name" name="first_name" 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white rounded-md focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700"
                            value="{{ old('first_name') }}"
                            required>
                    </div>

                    <!-- Nom -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nom
                        </label>
                        <input type="text" id="last_name" name="last_name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white rounded-md focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700"
                            value="{{ old('last_name') }}"
                            required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email
                        </label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white rounded-md focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700"
                            value="{{ old('email') }}"
                            required>
                    </div>

                    <!-- Matricule -->
                    <div>
                        <label for="matricule" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Matricule <span class="text-xs text-gray-500">(GL.XXXXX ou SR.XXXXX)</span>
                        </label>
                        <input type="text" id="matricule" name="matricule"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white rounded-md focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700"
                            placeholder="GL.CMRY22.23.K"
                            value="{{ old('matricule') }}"
                            required>
                    </div>

                    <!-- Niveau d'étude -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Niveau d'étude
                        </label>
                        <select id="level" name="level"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white rounded-md focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700"
                            required>
                            <option value=""> Sélectionner un niveau </option>
                            <option value="Licence 1" {{ old('level') === 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                            <option value="Licence 2" {{ old('level') === 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                            <option value="Licence 3" {{ old('level') === 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
                            <option value="Master 1" {{ old('level') === 'Master 1' ? 'selected' : '' }}>Master 1</option>
                            <option value="Master 2" {{ old('level') === 'Master 2' ? 'selected' : '' }}>Master 2</option>
                            <option value="Doctorat" {{ old('level') === 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                        </select>
                    </div>

                    <!-- Classe -->
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Classe
                        </label>
                        <select id="class_id" name="class_id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white rounded-md focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700"
                            required>
                            <option value="">-- Sélectionner une classe --</option>
                            @foreach(\App\Models\ClassModel::with('department')->get() as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }} ({{ $class->department->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Mot de passe (min 8 caractères)
                        </label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white rounded-md focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700"
                            required>
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Confirmer le mot de passe
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white rounded-md focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700"
                            required>
                    </div>
                </div>

                <!-- Bouton -->
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                    Créer mon compte
                </button>

                <!-- Lien login -->
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 font-medium">
                            Se connecter
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
