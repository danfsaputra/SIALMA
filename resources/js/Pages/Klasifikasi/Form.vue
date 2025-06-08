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
    nm_klasifikasi: "",
    retensi_aktif: "",
    retensi_inaktif: "",
    penyusutan_akhir: "",
    hak_akses: "",
    klas_keamanan: "",
    status: "",
};

const errors = ref({});
const hakAksesOptions = ref([]);
const keamananOptions = ref([]);
const penyusutanOptions = ref([]);
const formData = reactive({ 
    id: "",
    nm_klasifikasi: "",
    retensi_aktif: "",
    retensi_inaktif: "",
    penyusutan_akhir: "",
    hak_akses: "",
    klas_keamanan: "",
    status: "",
});

const fetchHakAkses = async () => {
    try {
        const res = await axios.get("/api/getHakakses");
        hakAksesOptions.value = res.data; 
    } catch (error) {
        console.error("Error fetching Hak Akses:", error);
    }
};

const fetchKeamanan = async () => {
    try {
        const res = await axios.get("/api/getKeamanan");
        keamananOptions.value = res.data;
    } catch (error) {
        console.error("Error fetching Keamanan:", error);
    }
};

const fetchPenyusutan = async () => {
    try {
        const res = await axios.get("/api/getPenyusutan");
        penyusutanOptions.value = res.data; 
    } catch (error) {
        console.error("Error fetching Penyusutan:", error);
    }
};

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/klasifikasi/store", data)
            .then((res) => {
                if (res.data.success == true) {
                    Swal("", res.data.message, "success").then(() => {
                        Object.assign(formData, formState);
                        return router.visit("/klasifikasi", { method: "get", data: { id: res.data.id } });
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

const jenisStatus = ref([
    { name: "Aktif", id: "Aktif" },
    { name: "Tidak Aktif", id: "Tidak Aktif" },
]);

const fetchData = () => {
    if (props.id) {
        axios
            .get(`/api/klasifikasi/getById/${props.id}`) 
            .then((res) => {
                formData.id = res.data.id;
                formData.nm_klasifikasi = res.data.nm_klasifikasi;
                formData.retensi_aktif = res.data.retensi_aktif;
                formData.retensi_inaktif = res.data.retensi_inaktif;
                formData.penyusutan_akhir = res.data.penyusutan_akhir;
                formData.hak_akses = res.data.hak_akses;
                formData.klas_keamanan = res.data.klas_keamanan;
                formData.status = res.data.status;
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
    fetchHakAkses();
    fetchKeamanan();
    fetchPenyusutan();
});
</script>

<template>
    <app-layout>
        <div class="card">
            <form @submit.prevent="submitForm(formData)">
                <h5 class="text-blue-600 uppercase">Informasi Klasifikasi Arsip</h5>
                <hr />

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Nama Klasifikasi</label>
                            <InputText
                                v-model="formData.nm_klasifikasi"
                                :invalid="errors?.nm_klasifikasi ? true : false"
                            />
                            <small v-if="errors?.nm_klasifikasi">{{ errors.nm_klasifikasi[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid mb-3">
                <div class="pb-0 col-12 md:col-4">
                    <div class="flex gap-2 flex-column">
                        <label class="font-semibold required">Penyusutan Akhir</label>
                        <Dropdown
                        v-model="formData.penyusutan_akhir"
                        :options="penyusutanOptions"
                        filter
                        optionLabel="nm_penyusutan_akhir" 
                        optionValue="id"
                        placeholder="Pilih Penyusutan Akhir"
                        class="w-auto"
                    />
                    <small v-if="errors?.penyusutan_akhir">{{ errors.penyusutan_akhir[0] }}</small>
                    </div>
                </div>

                <div class="pb-0 col-12 md:col-4">
                    <div class="flex gap-2 flex-column">
                        <label class="font-semibold required">Hak Akses</label>
                        <Dropdown
                        v-model="formData.hak_akses"
                        :options="hakAksesOptions"
                        filter
                        optionLabel="hak_akses" 
                        optionValue="id"
                        placeholder="Pilih Hak Akses"
                        class="w-auto"
                    />
                    <small v-if="errors?.hak_akses">{{ errors.hak_akses[0] }}</small>
                    </div>
                </div>

                <div class="pb-0 col-12 md:col-4">
                    <div class="flex gap-2 flex-column">
                        <label class="font-semibold required">Klasifikasi Keamanan</label>
                        <Dropdown
                        v-model="formData.klas_keamanan"
                        :options="keamananOptions"
                        filter
                        optionLabel="klas_keamanan" 
                        optionValue="id"
                        placeholder="Pilih Klasifikasi Keamanan"
                        class="w-auto"
                    />
                    <small v-if="errors?.klas_keamanan">{{ errors.klas_keamanan[0] }}</small>
                    </div>
                </div>

                    <div class="pb-0 col-12 md:col-4">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Retensi Aktif</label>
                            <InputText
                                v-model="formData.retensi_aktif"
                                :invalid="errors?.retensi_aktif ? true : false"
                            />
                            <small v-if="errors?.retensi_aktif">{{ errors.retensi_aktif[0] }}</small>
                        </div>
                    </div>

                    <div class="pb-0 col-12 md:col-4">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Retensi Inaktif</label>
                            <InputText
                                v-model="formData.retensi_inaktif"
                                :invalid="errors?.retensi_inaktif ? true : false"
                            />
                            <small v-if="errors?.retensi_inaktif">{{ errors.retensi_inaktif[0] }}</small>
                        </div>
                    </div>

                    <div class="pb-0 col-12 md:col-4">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Status</label>
                            <Dropdown
                                v-model="formData.status"
                                :options="jenisStatus"
                                filter optionLabel="name"
                                optionValue="id"
                                placeholder="Pilih Status"
                                class="w-auto"
                            />
                            <small v-if="errors?.status">{{ errors.status[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <Link :href="route('klasifikasi')">
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