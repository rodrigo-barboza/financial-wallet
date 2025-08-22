<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputWrapper from '@/Components/InputWrapper.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />
        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>
        <form
            class="flex flex-col gap-4"
            @submit.prevent="submit"
        >
            <InputWrapper
                v-model="form.email"
                class="mt-1 block w-full"
                label="Email"
                autocomplete="username"
                type="email"
                :errors="form.errors.email"
                autofocus
            />
            <InputWrapper
                v-model="form.password"
                class="mt-1 block w-full"
                label="Senha"
                autocomplete="current-password"
                type="password"
                :errors="form.errors.password"
            />
            <div class="flex items-center justify-end">
                <Link
                    :href="route('register')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Criar conta
                </Link>
                <PrimaryButton
                    class="ms-4"
                    :processing="form.processing"
                    :disabled="form.processing"
                >
                    Entrar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
