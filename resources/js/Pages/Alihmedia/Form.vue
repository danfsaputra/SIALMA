<script setup>
import { ref, reactive, onMounted, inject, watchEffect } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import AppLayout from "@/primevue/layout/AppLayout.vue";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import FileUpload from 'primevue/fileupload';

const Swal = inject("$swal");

const photoSource = ref(null);

const onFileSelect = (event) => {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        photoSource.value = e.target.result;
        formData.file_arsip = e.target.result.split(",")[1];
        formData.photo_ext = file.name.split(".").pop();
    };

    reader.readAsDataURL(file);
};


const props = defineProps({
    id: String,
});

const formState = {
    id: "",
    opd: "",
    tgl_arsip: "",
    no_arsip: "",
    jenis_arsip: "",
    klasifikasi_arsip: "",
    uraian: "",
    no_box: "",
    no_berkas: "",
    keterangan: "",
    status: "",
    file_arsip: "",
    photo_ext: "",
};

const errors = ref({});
const formData = reactive({ ...formState });

const klasifikasi = ref([]);
const OPD = ref([]);

const fetchKlasifikasi = async () => {
    axios.get("api/getKlasifikasi").then((res) => {
        klasifikasi.value = res.data;
    });
};

const fetchOPD = async () => {
    axios.get("api/getOPD").then((res) => {
        OPD.value = res.data;
    });
};

const jenisArsip = ref([
    { name: "Arsip Tekstual", id: "Arsip Tekstual" },
    // { name: "Arsip Foto", id: "Arsip Foto" },
    // { name: "Arsip kartografi dan kearsitekturan", id: "Arsip kartografi dan kearsitekturan" },
    // { name: "Arsip Video", id: "Arsip Video" },
    // { name: "Arsip Rekaman Suara", id: "Arsip Rekaman Suara" },
    // { name: "Arsip Poster", id: "Arsip Poster" },
    // { name: "Arsip suara", id: "Arsip suara" },
]);

const jenisStatus = ref([
    { name: "Dikirim", id: "Dikirim" },
    { name: "Belum Dikirim", id: "Belum Dikirim" },
]);

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/alihmedia/store", data)
            .then((res) => {
                if (res.data.success == true) {
                    Swal("", res.data.message, "success").then(() => {
                        Object.assign(formData, formState);
                        photoSource.value = null;
                        return router.visit("/alihmedia", { method: "get", data: { id: res.data.id } });
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
    axios
        .get(`/api/alihmedia/getById/${props.id}`)
        .then((res) => {
            const tgl_arsip = new Date(res.data.tgl_arsip); // Mengonversi ke format JavaScript Date

            formData.id = res.data.id;
            formData.opd = res.data.opd;
            formData.jenis_arsip = res.data.jenis_arsip;
            formData.tgl_arsip = res.data.tgl_arsip
            formData.no_arsip = res.data.no_arsip;
            formData.uraian = res.data.uraian;
            formData.keterangan = res.data.keterangan;
            formData.klasifikasi_arsip = res.data.klasifikasi_arsip;
            formData.no_box = res.data.no_box;
            formData.no_berkas = res.data.no_berkas;
            formData.status = res.data.status;
            formData.file_arsip = res.data.file_arsip;
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
};


onMounted(() => {
    if (props.id) fetchData();
    fetchKlasifikasi();
    fetchOPD();
});
</script>

<template>
    <app-layout>
        <div class="card">
            <form @submit.prevent="submitForm(formData)">
                <h5 class="text-blue-600 uppercase">Informasi Arsip</h5>
                <hr />

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">OPD</label>
                            <Dropdown
                                v-model="formData.opd"
                                :options="OPD"
                                filter optionLabel="name"
                                optionValue="name"
                                placeholder="Pilih OPD"
                                class="w-full"
                            />
                            <small v-if="errors?.opd">{{ errors.opd[0] }}</small>
                    </div>
                </div>

                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Jenis Arsip</label>
                            <Dropdown
                                v-model="formData.jenis_arsip"
                                :options="jenisArsip"
                                filter optionLabel="name"
                                optionValue="id"
                                placeholder="Pilih Jenis Arsip"
                                class="w-auto"
                            />
                            <small v-if="errors?.jenis_arsip">{{ errors.jenis_arsip[0] }}</small>
                        </div>
                    </div>

                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Tanggal Arsip</label>
                            <Calendar
                            v-model="formData.tgl_arsip"
                            dateFormat="yy-mm-dd"  
                            iconDisplay="input"
                            showIcon
                            :invalid="errors?.tgl_arsip ? true : false"
                        />

                            <small v-if="errors?.tgl_arsip">{{ errors.tgl_arsip[0] }}</small>
                        </div>
                    </div>
                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Nomor Arsip</label>
                            <InputText
                                v-model="formData.no_arsip"
                                :invalid="errors?.no_arsip ? true : false"
                            />
                            <small v-if="errors?.no_arsip">{{ errors.no_arsip[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Uraian Arsip</label>
                            <Textarea
                                v-model="formData.uraian"
                                rows="3"
                                :invalid="errors?.uraian ? true : false"
                            />
                            <small v-if="errors?.uraian">{{ errors.uraian[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Keterangan</label>
                            <Textarea
                                v-model="formData.keterangan"
                                rows="3"
                                :invalid="errors?.keterangan ? true : false"
                            />
                            <small v-if="errors?.keterangan">{{ errors.keterangan[0] }}</small>
                        </div>
                    </div>
                </div>

                <h5 class="mt-6 text-blue-600 uppercase">Informasi Klasifikasi</h5>
                <hr />

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Klasifikasi</label>
                            <Dropdown
                                v-model="formData.klasifikasi_arsip"
                                :options="klasifikasi"
                                filter optionLabel="nm_klasifikasi"
                                optionValue="nm_klasifikasi"
                                placeholder="Pilih klasifikasi"
                                class="w-90"
                            />
                            <small v-if="errors?.klasifikasi_arsip">{{ errors.klasifikasi_arsip[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Nomor Boks</label>
                            <InputText
                                v-model="formData.no_box"
                                :invalid="errors?.no_box ? true : false"
                            />
                            <small v-if="errors?.no_box">{{ errors.no_box[0] }}</small>
                        </div>
                    </div>
                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Nomor Berkas</label>
                            <InputText
                                v-model="formData.no_berkas"
                                :invalid="errors?.no_berkas ? true : false"
                            />
                            <small v-if="errors?.no_berkas">{{ errors.no_berkas[0] }}</small>
                        </div>
                    </div>
                    <div class="pb-0 col-12 md:col-3">
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
                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Upload File</label>
                            <div
                                v-if="photoSource"
                                class="flex items-center gap-3 p-3 mb-0 card flex-column"
                            >
                                <Image
                                    :src="photoSource"
                                    alt="Image"
                                    width="300"
                                    class="rounded-xl"
                                />
                            </div>
                            <FileUpload
                                mode="basic"
                                v-model="formData.file_arsip"
                                @select="onFileSelect"
                                customUpload
                                auto
                                :maxFileSize="1000000"
                                accept="application/pdf"
                                chooseLabel="Pilih File"
                                class="w-full px-4 py-2 text-green-500 border-green-600 p-button-outlined md:w-auto"
                            />
                            <small v-if="errors?.file_arsip">{{ errors.file_arsip[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <Link :href="route('alihmedia')">
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
