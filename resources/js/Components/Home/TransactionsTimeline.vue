<script setup>
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import TransactionsTimelineItem from '@/Components/Home/TransactionsTimelineItem.vue';
import useToast from '@/Composables/useToast';

const toast = useToast();

defineProps({
    transactions: {
        type: Array,
        default: () => ([]),
    },
});

async function handleRevertTransaction(transaction) {
    try {
        const { data: { message } } = await axios.post(`/revert-transaction/${transaction.id}`);
        toast.success(message);
        router.visit(route('home'));
    } catch (error) {
        toast.error('Erro ao reverter transação.');
    }
}
</script>

<template>
    <div class="p-4">
        <div v-if="transactions.length === 0">
            Sem transações ainda.
        </div>
        <ol
            v-else
            class="relative border-s border-gray-200"
        >
            <TransactionsTimelineItem
                v-for="(transaction, index) in transactions"
                v-bind="transaction"
                :key="index"
                @on-revert="handleRevertTransaction(transaction)"
            />
        </ol>
    </div>
</template>
