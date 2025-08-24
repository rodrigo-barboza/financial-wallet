<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
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
    account: null,
    agency: null,
    amount: null,
});

const unformattedAmount = ref(null);
const currentError = ref(null);

watch(show, () => {
    if (show.value) {
        form.errors.amount = null;
        form.reset();
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
    form.account = form.account.replace(/\D/g, '');

    try {
        const { data: { message } } = await axios.post(route('transfer'), form.data());

        toast.success(message);
        closeModal();
        router.visit(route('home'));
    } catch (error) {
        console.log(error);
        currentError.value = error.response.data.message;
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
            <InputError :message="currentError" />
            <InputWrapper
                v-model="form.account"
                class="w-full"
                placeholder="00000000"
                label="Número da conta"
                type="text"
                :errors="form.errors.account"
            />
            <InputWrapper
                v-model="form.agency"
                class="w-full"
                placeholder="0000"
                label="Agência"
                type="text"
                :errors="form.errors.agency"
            />
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
                Transferir
            </PrimaryButton>
        </div>
    </Modal>
</template>
