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

const formState = {
    nm_penyusutan_akhir: "",
};

const errors = ref({});
const formData = reactive({
    id: "",
    nm_penyusutan_akhir: "",
});

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/penyustan/store", data)
            .then((res) => {
                if (res.data.success == true) {
                    Swal("", res.data.message, "success").then(() => {
                        Object.assign(formData, formState);
                        return router.visit("/skkaad", { method: "get", data: { id: res.data.id } });
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

const fetchData = () => {
    if (props.id) {
        axios
            .get(`/api/penyusutan/getById/${props.id}`)
            .then((res) => {
                formData.id = res.data.id;
                formData.nm_penyusutan_akhir = res.data.nm_penyusutan_akhir;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }
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
                <h5 class="text-blue-600 uppercase">Informasi Penyusutan Arsip</h5>
                <hr />

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Penyusutan Arsip</label>
                            <InputText
                                v-model="formData.nm_penyusutan_akhir"
                                :invalid="errors?.nm_penyusutan_akhir ? true : false"
                            />
                            <small v-if="errors?.nm_penyusutan_akhir">{{ errors.nm_penyusutan_akhir[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <Link :href="route('penyusutan')">
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