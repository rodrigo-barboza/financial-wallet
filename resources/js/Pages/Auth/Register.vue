<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputWrapper from '@/Components/InputWrapper.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <form
            class="flex flex-col gap-4"
            @submit.prevent="submit"
        >
            <InputWrapper
                v-model="form.name"
                class="mt-1 block w-full"
                autocomplete="name"
                label="Nome"
                type="text"
                :errors="form.errors.name"
                autofocus
            />
            <InputWrapper
                v-model="form.email"
                class="mt-1 block w-full"
                autocomplete="username"
                label="Email"
                type="text"
                :errors="form.errors.email"
            />
            <InputWrapper
                v-model="form.password"
                class="mt-1 block w-full"
                autocomplete="new-password"
                label="Senha"
                type="password"
                :errors="form.errors.password"
            />
            <InputWrapper
                v-model="form.password_confirmation"
                class="mt-1 block w-full"
                autocomplete="new-password"
                label="Confirmar Senha"
                type="password"
                :errors="form.errors.password_confirmation"
            />
            <div class="flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Já possui uma conta?
                </Link>
                <PrimaryButton
                    class="ms-4"
                    :processing="form.processing"
                    :disabled="form.processing"
                >
                    Registrar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
