<script setup>
import ButtonLink from '@/Components/ButtonLink.vue';
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <header
            v-if="$slots.header"
            class="bg-white shadow"
        >
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between">
                <slot name="header" />
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
