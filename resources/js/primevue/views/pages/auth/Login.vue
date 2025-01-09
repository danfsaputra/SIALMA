<script setup>
import { useLayout } from "@/layout/composables/layout";
import { ref, computed } from "vue";
import AppConfig from "@/layout/AppConfig.vue";

const { layoutConfig } = useLayout();
const email = ref("");
const password = ref("");
const checked = ref(false);

const logoUrl = computed(() => {
    return `layout/images/${
        layoutConfig.darkTheme.value ? "logo-white" : "logo-dark"
    }.svg`;
});
</script>

<template>
    <div
        class="flex min-h-screen overflow-hidden surface-ground align-items-center justify-content-center min-w-screen"
    >
        <div class="flex flex-column align-items-center justify-content-center">
            <img
                :src="logoUrl"
                alt="Sakai logo"
                class="flex-shrink-0 mb-5 w-6rem"
            />
            <div
                style="
                    border-radius: 56px;
                    padding: 0.3rem;
                    background: linear-gradient(
                        180deg,
                        var(--primary-color) 10%,
                        rgba(33, 150, 243, 0) 30%
                    );
                "
            >
                <div
                    class="w-full px-5 py-8 surface-card sm:px-8"
                    style="border-radius: 53px"
                >
                    <div class="mb-5 text-center">
                        <img
                            src="/demo/images/login/avatar.png"
                            alt="Image"
                            height="50"
                            class="mb-3"
                        />
                        <div class="mb-3 text-3xl font-medium text-900">
                            Welcome, Isabel!
                        </div>
                        <span class="font-medium text-600"
                            >Sign in to continue</span
                        >
                    </div>

                    <div>
                        <label
                            for="email1"
                            class="block mb-2 text-xl font-medium text-900"
                            >Email</label
                        >
                        <InputText
                            id="email1"
                            type="text"
                            placeholder="Email address"
                            class="w-full mb-5 md:w-30rem"
                            style="padding: 1rem"
                            v-model="email"
                        />

                        <label
                            for="password1"
                            class="block mb-2 text-xl font-medium text-900"
                            >Password</label
                        >
                        <Password
                            id="password1"
                            v-model="password"
                            placeholder="Password"
                            :toggleMask="true"
                            class="w-full mb-3"
                            inputClass="w-full"
                            :inputStyle="{ padding: '1rem' }"
                        ></Password>

                        <div
                            class="flex gap-5 mb-5 align-items-center justify-content-between"
                        >
                            <div class="flex align-items-center">
                                <Checkbox
                                    v-model="checked"
                                    id="rememberme1"
                                    binary
                                    class="mr-2"
                                ></Checkbox>
                                <label for="rememberme1">Remember me</label>
                            </div>
                            <a
                                class="ml-2 font-medium text-right no-underline cursor-pointer"
                                style="color: var(--primary-color)"
                                >Forgot password?</a
                            >
                        </div>
                        <Button
                            label="Sign In"
                            class="w-full p-3 text-xl"
                        ></Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AppConfig simple />
</template>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}
</style>
