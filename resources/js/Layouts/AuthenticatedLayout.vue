<script setup>
import ButtonLink from '@/Components/ButtonLink.vue';
import useCurrency from '@/Composables/useCurrency';

const { toCurrency } = useCurrency();
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">Financial Wallet</h2>
                    <h6>Ola, {{ $page.props.auth.user.name }}</h6>
                    <div class="mt-4 flex gap-12">
                        <div>
                            <small>Saldo</small>
                            <h4>{{ toCurrency($page.props.auth.user.balance) }}</h4>
                        </div>
                        <div>
                            <small>Número de conta</small>
                            <h4>{{ $page.props.auth.user.account }}</h4>
                        </div>
                        <div>
                            <small>Agência</small>
                            <h4>{{ $page.props.auth.user.agency }}</h4>
                        </div>
                    </div>
                </div>
                <div>
                    <ButtonLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        Sair
                    </ButtonLink>
                </div>
            </div>
        </header>
        <main>
            <slot />
        </main>
    </div>
</template>
