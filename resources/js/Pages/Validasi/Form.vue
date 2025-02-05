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

const pdfUrl = ref('');

const fetchPdfUrl = async (file) => {
    try {
        const response = await fetch(`/alihmedia/pdf/preview${file}`);
        const blob = await response.blob();
        pdfUrl.value = URL.createObjectURL(blob);
    } catch (error) {
        console.error('Error fetching PDF:', error);
    }
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
    //{ name: "Arsip Foto", id: "Arsip Foto" },
    //{ name: "Arsip kartografi dan kearsitekturan", id: "Arsip kartografi dan kearsitekturan" },
    //{ name: "Arsip Video", id: "Arsip Video" },
    //{ name: "Arsip Rekaman Suara", id: "Arsip Rekaman Suara" },
    //{ name: "Arsip Poster", id: "Arsip Poster" },
    //{ name: "Arsip suara", id: "Arsip suara" },
]);

const jenisStatus = ref([
    { name: "Disetujui", id: "Disetujui" },
    { name: "Dikembalikan", id: "Belum Dikirim" },
]);

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/validasidata/store", data)
            .then((res) => {
                if (res.data.success == true) {
                    Swal("", res.data.message, "success").then(() => {
                        Object.assign(formData, formState);
                        photoSource.value = null;
                        return router.visit("/validasidata", { method: "get", data: { id: res.data.id } });
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
            const tgl_arsip = new Date(res.data.tgl_arsip);

            formData.id = res.data.id;
            formData.opd = res.data.opd;
            formData.jenis_arsip = res.data.jenis_arsip;
            formData.tgl_arsip = res.data.tgl_arsip;
            formData.no_arsip = res.data.no_arsip;
            formData.uraian = res.data.uraian;
            formData.keterangan = res.data.keterangan;
            formData.klasifikasi_arsip = res.data.klasifikasi_arsip;
            formData.no_box = res.data.no_box;
            formData.no_berkas = res.data.no_berkas;
            formData.status = res.data.status;
            // formData.file_arsip = res.data.file_arsip;
            //pdfUrl.value = "/api/getImage/" + res.data.file_arsip;
            // photoSource.value = "api/alihmedia/image/" + props.data.file_arsip;
            fetchPdfUrl(res.data.file_arsip);
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
};

watchEffect(() => {
    // if (props.items) {
    //     const tgl_arsip = new Date(props.items.tgl_arsip);
    //     formData.id = props.items.id;
    //     formData.opd = props.items.opd;
    //     formData.tgl_arsip = tgl_arsip.toLocaleDateString();
    //     formData.jenis_arsip = props.items.jenis_arsip;
    //     formData.klasifikasi_arsip = props.items.klasifikasi_arsip;
    //     formData.uraian = props.items.uraian;
    //     formData.no_box = props.items.no_box;
    //     formData.no_berkas = props.items.no_berkas;
    //     formData.keterangan = props.items.keterangan;
    // }
});

onMounted(() => {
    if (props.id) fetchData();
    fetchKlasifikasi();
    fetchOPD();
    //fetchPdfUrl(formData.id);
});
</script>

<template>
    <app-layout>
        <div class="card">
            <form @submit.prevent="submitForm(formData)">
                <h5 class="text-blue-600 uppercase">Validasi Data</h5>
                <hr />

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
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

                <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                            <iframe class="flex gap-3 p-3 mb-0 items-right card flex-column" :src="pdfUrl" width="100%" height="700vh"></iframe>
                    </div>
                </div>
            </div>

                <div class="flex justify-end gap-2">
                    <Link :href="route('validasi')">
                        <Button
                            type="button"
                            label="Batal"
                            severity="secondary"
                            outlined
                        />
                    </Link>
                    <Button
                        type="submit"
                        label="Verifikasi"
                        severity="success"
                        icon="pi pi-file"
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