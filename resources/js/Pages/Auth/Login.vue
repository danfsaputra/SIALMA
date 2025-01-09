<script setup>
import { ref } from "vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import { useForm } from "@inertiajs/vue3";
import useAuth from "@/composables/auth";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const { login, errors, loading } = useAuth();
const form = useForm({
    email: "",
    password: "",
    remember: false,
});
</script>

<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div
                class="w-full bg-white rounded-lg shadow-5 md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
            >
                <div class="space-y-3 md:space-y-6 sm:p-6">
                    <h2 class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
                        Silakan masuk ke akun anda
                    </h2>
                    <form
                        @submit.prevent="login(form)"
                        class="space-y-4 md:space-y-6"
                    >
                        <div>
                            <label class="font-semibold">Email</label>
                            <InputText
                                class="w-full mt-2 h-3rem"
                                v-model="form.email"
                                :invalid="errors?.email ? true : false"
                                autofocus
                            />
                            <small v-if="errors?.email">{{ errors.email[0] }}</small>
                        </div>
                        <div>
                            <label class="font-semibold">Password</label>
                            <InputText
                                type="password"
                                class="w-full mt-2 h-3rem"
                                v-model="form.password"
                                :invalid="errors?.password ? true : false"
                                autofocus
                            />
                            <small v-if="errors?.password">{{ errors.password[0] }}</small>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <label class="flex items-center">
                                    <Checkbox
                                        name="remember"
                                        v-model:checked="form.remember"
                                    />
                                    <span class="text-sm text-gray-600 ms-2">Remember me</span>
                                </label>
                            </div>
                        </div>
                        <Button
                            type="submit"
                            label="Masuk"
                            class="w-full"
                            :loading="loading"
                        />
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style lang="postcss" scoped>
small {
    @apply text-xs font-medium text-red-400;
}
</style>
