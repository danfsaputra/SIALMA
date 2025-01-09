<script setup>
import { ref, reactive, inject, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/primevue/layout/AppLayout.vue";
import Button from "primevue/button";
import InputText from "primevue/inputtext";

const props = defineProps({
    items: Object,
});

const Swal = inject("$swal");

const formData = reactive({
    id: "",
    password: "",
    password_confirmation: "",
});

const name = ref();
const email = ref();
const errors = ref({});

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/users/changePassword", data)
            .then((res) => {
                if (res.data.success == true) {
                    Swal({
                        html: res.data.message,
                        icon: "success",
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch((err) => {
                if (err.response.status === 422) {
                    errors.value = err.response.data.errors;
                }
            });
    } catch (err) {
        console.log(err);
    }
};

onMounted(() => {
    name.value = props.items.name;
    email.value = props.items.email;
});
</script>

<template>
    <app-layout>
        <div class="grid">
            <div class="col-12 md:col-6">
                <div class="card">
                    <form @submit.prevent="submitForm(formData)">
                        <div class="grid">
                            <div class="pb-0 col-12">
                                <div class="flex gap-2 flex-column">
                                    <label class="font-semibold required">Nama Lengkap</label>
                                    <InputText
                                        v-model="name"
                                        variant="filled"
                                        readonly
                                    />
                                </div>
                            </div>
                            <div class="pb-0 col-12">
                                <div class="flex gap-2 flex-column">
                                    <label class="font-semibold required">Alamat Email</label>
                                    <InputText
                                        v-model="email"
                                        variant="filled"
                                        readonly
                                    />
                                </div>
                            </div>
                            <div class="pb-0 col-12">
                                <div class="flex gap-2 flex-column">
                                    <label class="font-semibold required">Password (Baru)</label>
                                    <InputText
                                        type="password"
                                        v-model="formData.password"
                                        :invalid="errors?.password ? true : false"
                                    />
                                    <small v-if="errors?.password">{{ errors.password[0] }}</small>
                                </div>
                            </div>
                            <div class="pb-0 col-12">
                                <div class="flex gap-2 flex-column">
                                    <label class="font-semibold required">Konfirmasi Password</label>
                                    <InputText
                                        type="password"
                                        v-model="formData.password_confirmation"
                                        :invalid="errors?.password_confirmation ? true : false"
                                    />
                                    <small v-if="errors?.password_confirmation">{{
                                        errors.password_confirmation[0]
                                    }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-5">
                            <Button
                                type="submit"
                                label="Simpan"
                            ></Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<style lang="postcss" scoped>
small {
    @apply text-xs font-medium text-red-400;
}
</style>
