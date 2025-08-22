<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import InputWrapper from '../InputWrapper.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import useToast from '@/Composables/useToast';

const emit = defineEmits(['update:model-value']);

const toast = useToast();

const show = defineModel({
    type: Boolean,
    default: false,
});

const form = useForm({
    amount: '',
});

const unformattedAmount = ref(null);

watch(show, () => {
    if (show.value) {
        form.errors.amount = null;
    }
});

function closeModal() {
    emit('update:model-value', false);
    form.reset();
}

async function onSubmit() {
    if (!form.amount) {
        unformattedAmount.value = null;
    }

    form.amount = unformattedAmount.value;

    try {
        const { data: { message } } = await axios.post(route('deposit'), form.data());

        toast.success(message);
        closeModal();
        router.visit(route('home'));
    } catch (error) {
        form.errors.amount = error.response.data.message;
    }
}
</script>

<template>
    <Modal
        title="Depositar"
        maxWidth="md"
        :show="show"
        @close="closeModal"
    >
        <div class="flex flex-col gap-4 w-full">
            <InputWrapper
                v-model="form.amount"
                class="w-full"
                placeholder="R$ 0,00"
                label="Quantia"
                type="text"
                :errors="form.errors.amount"
                currency
                @unformatted-value="unformattedAmount = $event"
            />
            <PrimaryButton
                class="font-medium"
                block
                @click="onSubmit"
            >
                Adicionar
            </PrimaryButton>
        </div>
    </Modal>
</template>
