<script setup>
import { ref, reactive, onMounted, inject, watchEffect } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import AppLayout from "@/primevue/layout/AppLayout.vue";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";

const Swal = inject("$swal");

const props = defineProps({
    id: String,
});

const formData = reactive({
    id: "",
    hak_akses: "",
});

const formState = {
    hak_akses: "",
};

const errors = ref({});

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/hak/store", data)
            .then((res) => {
                if (res.data.success == true) {
                    Swal("", res.data.message, "success").then(() => {
                        Object.assign(formData, formState);
                        return router.visit("/hak", { method: "get", data: { id: res.data.id } });
                    });
                }
            })
            .catch((err) => {
                console.log(err);
                if (err.response.status === 422) {
                    errors.value = err.response.data.errors;
                }
            });
    } catch (err) {
        console.log(err);
    }
};

const fetchData = (id) => {
    axios
        .get(`/api/hak/getById/${id}`) 
        .then((res) => {
            formData.id = res.data.id;
            formData.hak_akses = res.data.hak_akses;
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
};

onMounted(() => {
    if (props.id) {
        fetchData(props.id); 
    }
});
</script>

<template>
    <app-layout>
        <div class="card">
            <form @submit.prevent="submitForm(formData)">
                <h5 class="text-blue-600 uppercase">Informasi Hak Akses Arsip</h5>
                <hr />

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Hak Akses</label>
                            <InputText
                                v-model="formData.hak_akses"
                                :invalid="errors?.hak_akses ? true : false"
                            />
                            <small v-if="errors?.hak_akses">{{ errors.hak_akses[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <Link :href="route('hak')">
                        <Button
                            type="button"
                            label="Batal"
                            severity="secondary"
                            outlined
                        />
                    </Link>
                    <Button
                        type="submit"
                        label="Simpan"
                        severity="primary"
                    ></Button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<style lang="postcss" scoped>
small {
    @apply text-xs font-medium text-red-400;
}
</style>