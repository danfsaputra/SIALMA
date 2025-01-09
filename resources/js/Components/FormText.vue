<script setup>
import { onMounted, ref } from "vue";

defineProps({
    label: {
        type: String,
    },
    type: {
        type: String,
    },
    required: {
        type: Boolean,
    },
    hint: {
        type: String,
    },
    modelValue: {
        type: String,
        required: true,
    },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="flex flex-1 flex-column gap-2">
        <label
            class="font-semibold"
            :class="[required ? 'required' : '']"
        >
            {{ label }}
        </label>
        <input
            :type="type"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-{50em}"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
        />
        <span class="text-xs font-medium text-slate-400">{{ hint }}</span>
    </div>
</template>
