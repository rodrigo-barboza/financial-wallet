<script setup>
import { ref, watchEffect } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const emit = defineEmits(['onTransfer', 'onDeposit']);

const props = defineProps({
    tabs: {
        type: Array,
        default: () => ([]),
    },
});

const currentTabKey = ref(null);

watchEffect(() => currentTabKey.value = (props.tabs.length > 0) ? props.tabs[0].key : null);
</script>

<template>
    <div class="flex flex-wrap text-md font-semibold text-center text-gray-500 border-b border-gray-200 justify-between">
        <div class="me-2">
            <div class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50">Histórico de transações</div>
        </div>
        <div class="flex gap-2 self-center">
            <SecondaryButton @click="emit('on-transfer')">Transferir</SecondaryButton>
            <PrimaryButton @click="emit('on-deposit')">Depositar</PrimaryButton>
        </div>
    </div>
</template>
