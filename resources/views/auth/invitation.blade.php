<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-6">
            <!-- En-tête -->
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center font-bold text-white text-xl">
                        ✓
                    </div>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    Accepter l'invitation
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Complétez votre profil CampusEval
                </p>
            </div>

            <!-- Infos utilisateur -->
            <div class="rounded-lg bg-blue-50 dark:bg-blue-900/20 p-4 text-sm">
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Utilisateur :</strong> {{ $user->email }}<br>
                    <strong>Rôle :</strong> {{ ucfirst(str_replace('_', ' ', $user->role)) }}<br>
                    <strong>Nom :</strong> {{ $user->first_name }} {{ $user->last_name }}
                </p>
            </div>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('invitation.accept', ['token' => request()->route('token')]) }}" class="space-y-4">
                @csrf

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

                <div class="rounded-lg shadow-md space-y-4 p-4 bg-white dark:bg-slate-800">
                    <!-- Mot de passe -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mot de passe</label>
                        <input name="password" type="password"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-slate-700"
                            placeholder="••••••••"
                            required>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Minimum 8 caractères
                        </p>
                    </div>

                    <!-- Confirmation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmer mot de passe</label>
                        <input name="password_confirmation" type="password"
                            class="mt-1 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-slate-700"
                            placeholder="••••••••"
                            required>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Bouton -->
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                    Accepter et se connecter
                </button>
            </form>

            <!-- Note -->
            <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                Ce lien a été envoyé à {{ $user->email }}<br>
                L'accès expire dans 7 jours.
            </p>
        </div>
    </div>
</x-guest-layout>
