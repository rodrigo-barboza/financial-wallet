<script setup>
import { onMounted, ref, watch } from 'vue';
import useCurrency from '@/Composables/useCurrency';

const emit = defineEmits(['update:model-value', 'unformatted-value']);

const { toCurrency, unformattedValue } = useCurrency();

const model = defineModel({
    type: String,
    required: true,
});

const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },

    currency: {
        type: Boolean,
        default: false,
    },
});

const input = ref(null);

watch(model, (currentValue) => {
    if (!props.currency || !currentValue) {
        return;
    }

    emit('unformatted-value', unformattedValue(currentValue));

    const formattedValue = toCurrency(currentValue);

    if (formattedValue !== currentValue) {
        emit('update:model-value', formattedValue);
    }
}, { immediate: true });

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        v-model="model"
        v-mask="'###.###.###-##'"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        ref="input"
    />
</template>
