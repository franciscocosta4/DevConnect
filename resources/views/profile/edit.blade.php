@extends('layouts.app')

@section('content')

    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Informações do Perfil') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Actualize as informações do perfil e o endereço de email da sua conta.') }}
            </p>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="name" :value="__('Nome')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                    required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="name" :value="__('Bio')" />
                <x-text-input id="name" name="bio" type="text" class="mt-1 block w-full" :value="old('bio', $user->bio)"
                    required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('O seu endereço de email não está verificado.') }}

                            <button form="send-verification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Clique aqui para reenviar o email de verificação.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('Foi enviado um novo link de verificação para o seu endereço de email.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600">{{ __('Guardado.') }}</p>
                @endif
            </div>
        </form>
    </section>
    <br>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Alterar Palavra-passe') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Garanta que a sua conta utiliza uma palavra-passe longa e aleatória para manter a segurança.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div>
                <x-input-label for="update_password_current_password" :value="__('Palavra-passe Atual')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                    class="mt-1 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('Nova Palavra-passe')" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Palavra-passe')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600">{{ __('Guardado.') }}</p>
                @endif
            </div>
        </form>
    </section>
    <br>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Eliminar Conta') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Uma vez eliminada a sua conta, todos os seus recursos e dados serão permanentemente eliminados. Antes de eliminar a sua conta, por favor transfira qualquer dado ou informação que deseje manter.') }}
            </p>
        </header>

        <x-danger-button x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Eliminar Conta') }}</x-danger-button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Tem a certeza que pretende eliminar a sua conta?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Uma vez eliminada a sua conta, todos os seus recursos e dados serão permanentemente eliminados. Por favor introduza a sua palavra-passe para confirmar que deseja eliminar a sua conta de forma permanente.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Palavra-passe') }}" class="sr-only" />

                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                        placeholder="{{ __('Palavra-passe') }}" />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancelar') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Eliminar Conta') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </section>

@endsection