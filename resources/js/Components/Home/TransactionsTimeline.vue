<script setup>
import TransactionsTimelineItem from '@/Components/Home/TransactionsTimelineItem.vue';

defineProps({
    transactions: {
        type: Array,
        default: () => ([]),
    },
});
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
            />
        </ol>
    </div>
</template>
