<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const model = defineModel();

defineProps({
    label: {
        type: String,
        default: 'Label',
    },
    type: {
        type: String,
        default: 'text',
    },
    required: {
        type: Boolean,
        required: false,
    },
    autofocus: {
        type: Boolean,
        required: false,
    },
    autocomplete: {
        type: String,
        required: false,
    },
    errors: {
        type: String,
        required: false,
    },
});
</script>

<template>
    <div>
        <InputLabel :value="label"/>
        <TextInput
            v-model="model"
            v-bind="$attrs"
            class="mt-1 block w-full"
            :type="type"
            :required="required"
            :autofocus="autofocus"
            :autocomplete="autocomplete"
        />
        <InputError
            class="mt-2"
            :message="errors"
        />
    </div>
</template>
