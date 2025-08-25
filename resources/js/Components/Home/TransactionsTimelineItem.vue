<script setup>
import { computed } from 'vue';
import { TRANSACTION_TYPES, DEPOSIT } from '@/Constants/OperationTypes';
import { usePage } from '@inertiajs/vue3';
import useCurrency from '@/Composables/useCurrency';

const emit = defineEmits(['on-revert']);

const { toCurrency } = useCurrency();

const { props: page } = usePage();

const props = defineProps({
    type: {
        type: Array,
        default: () => ([]),
        validator: (value) => TRANSACTION_TYPES.includes(value),
    },
    amount: {
        type: Number,
        default: null,
    },
    receiver: {
        type: Object,
        default: () => ({}),
    },
    sender: {
        type: Object,
        default: () => ({}),
    },
    date: {
        type: String,
        default: null,
    },
});

const resolveTimelineLabel = computed(() => {
   if (props.type?.value === DEPOSIT) {
        return 'Depósito realizado';
   }

   if (isReceiver.value) {
        return 'Transferência recebida';
   }

   return 'Transferência realizada';
});

const resolveTimelineTransactionDescription = computed(() => {
    if (props.type?.value === DEPOSIT) {
        return '';
    }

    if (isReceiver.value) {
        return `Transferência TED recebida de ${props.sender?.name} (${props.sender?.account})`;
    }

    return `Transferência TED realizada para o(a) ${props.receiver?.name} (${props.receiver?.account})`;
});

const resolveAmount = computed(() => {
    if (props.type?.value === DEPOSIT) {
        return `+${toCurrency(props.amount)}`;
    }

    if (isReceiver.value) {
        return `+${toCurrency(props.amount)}`;
    }

    return `-${toCurrency(props.amount)}`;
});

const isReceiver = computed(() => props.receiver.id === page.auth.user.id);
</script>

<template>
    <li class="mt-4 ms-6 flex justify-between">
        <div>
            <span
                v-if="props.type?.value === DEPOSIT || isReceiver"
                class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white"
            >
                <svg class="w-5 h-5 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 0a1 1 0 0 1 1 1v5.586l2.293-2.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L9 6.586V1a1 1 0 0 1 1-1zm0 18a1 1 0 0 1-1-1v-5.586l-2.293 2.293a1 1 0 0 1-1.414-1.414l4-4a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1-1.414 1.414L11 12.414V17a1 1 0 0 1-1 1z"/>
                </svg>
            </span>
            <span
                v-else
                class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white"
            >
                <svg class="w-5 h-5 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 20a1 1 0 0 1-1-1v-5.586l-2.293 2.293a1 1 0 0 1-1.414-1.414l4-4a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1-1.414 1.414L11 13.414V19a1 1 0 0 1-1 1zm0-18a1 1 0 0 0-1 1v5.586l-2.293-2.293a1 1 0 0 0-1.414 1.414l4 4a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L11 6.586V3a1 1 0 0 0-1-1z"/>
            </svg>
            </span>
            <h3 class="mb-1 text-lg font-semibold text-gray-900">{{ resolveTimelineLabel }}</h3>
            <time class="block mb-2 text-sm font-normal leading-none text-gray-400">{{ date }}</time>
            <p class="text-base font-normal text-gray-500">{{ resolveTimelineTransactionDescription }}</p>
        </div>
        <div class="flex flex-col gap-2">
            <span
                class="inline-flex items-center px-2 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full"
                :class="isReceiver ? 'bg-green-100 text-green-800' : type?.badge"
            >
                {{ resolveAmount }}
            </span>
            <small
                class="self-center text-gray-500 cursor-pointer hover:underline"
                @click="emit('on-revert')"
            >
                reverter
            </small>
        </div>
    </li>
</template>
