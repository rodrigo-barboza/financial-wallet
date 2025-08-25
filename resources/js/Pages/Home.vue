<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HomeDepositModal from '@/Components/Home/DepositModal.vue';
import HomeHeader from '@/Components/Home/Header.vue';
import HomeTransactionsTimeline from '@/Components/Home/TransactionsTimeline.vue';
import HomeTransferModal from '@/Components/Home/TransferModal.vue';
import axios from 'axios';

const showDepositModal = ref(false);
const showTransferModal = ref(false);
const transactions = ref([]);

onMounted(async () => {
    const { data } = await axios.get(route('transactions'));
    transactions.value = data;
});
</script>

<template>
    <Head title="Inicio" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <HomeHeader
                            @on-transfer="showTransferModal = true"
                            @on-deposit="showDepositModal = true"
                        />
                        <HomeTransactionsTimeline
                            class="mt-6"
                            :transactions="transactions?.data"
                        />
                        <HomeTransferModal v-model="showTransferModal" />
                        <HomeDepositModal v-model="showDepositModal" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
