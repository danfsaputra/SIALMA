<script setup>
import { onMounted, ref } from "vue";

defineProps({
    label: {
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
    <div class="flex flex-auto items-center gap-5">
        <label class="font-semibold w-3" :class="[required ? 'required' : '']">
            {{ label }}
        </label>

        <div class="flex flex-column flex-1">
            <input
                class="flex-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-2"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                ref="input"
            />

            <span class="text-xs font-medium text-slate-400">{{ hint }}</span>
        </div>
    </div>
</template>
