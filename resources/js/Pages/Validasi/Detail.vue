<script setup>
import { ref, reactive, onMounted, inject, watchEffect } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import AppLayout from "@/primevue/layout/AppLayout.vue";
import Button from "primevue/button";


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
    file_arsip: "",
};

// const photoSource = ref('/app/alihmedia/$file');

const pdfUrl = ref('');

const fetchPdfUrl = async (file) => {
    try {
        const response = await fetch(`/validasi/pdf/preview/${file}`);
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

// const submitForm = async (data) => {
//     try {
//         await axios.get("/sanctum/csrf-cookie");

//         axios
//             .post("/api/alihmedia/store", data)
//             .then((res) => {
//                 if (res.data.success == true) {
//                     Swal("", res.data.message, "success").then(() => {
//                         return router.visit("/alihmedia", { method: "get", data: { id: res.data.id } });
//                     });
//                 }
//             })
//             .catch((err) => {
//                 console.log(err);
//                 if (err.response.status === 422) {
//                     errors.value = err.response.data.errors;
//                 }
//             });
//     } catch (err) {
//         console.log(err);
//     }
// };

const editForm = (id) => {
    router.visit("/validasi-form", { method: "get", data: { id: id } });
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
            // formData.file_arsip = res.data.file_arsip;
            formData.created_at = res.data.created_at;
            formData.updated_at = res.data.updated_at;
            //pdfUrl.value = "/api/getImage/" + res.data.file_arsip;
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
            <div class="flex flex-row align-items-end justify-content-between">
                <h5 class="mb-0 text-blue-600 uppercase">Informasi Arsip</h5>
                <Button
                    type="button"
                    label="Verifikasi Data"
                    severity="success"
                    class="w-full md:w-auto"
                    icon="pi pi-verified"
                    inlined
                    @click="editForm(formData.id)"
                />
            </div>
            <hr />

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">OPD</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.opd }}</h6>
                    </div>
                </div>
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Jenis Arsip </label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.jenis_arsip }}</h6>
                    </div>
                </div>
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Tanggal Arsip</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.tgl_arsip }}</h6>
                    </div>
                </div>
            </div>

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Nomor Arsip</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.no_arsip }}</h6>
                    </div>
                </div>
            </div>

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Uraian Arsip</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.uraian }}</h6>
                    </div>
                </div>
            </div>

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Keterangan</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.keterangan }}</h6>
                    </div>
                </div>
            </div>

            <h5 class="text-blue-600 uppercase">Informasi Klasifikasi</h5>
            <hr />

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Klasifikasi</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.klasifikasi_arsip }}</h6>
                    </div>
                </div>
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Nomor Boks</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.no_box }}</h6>
                    </div>
                </div>
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Nomor Berkas</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.no_berkas }}</h6>
                    </div>
                </div>
            </div>

            <h5 class="text-blue-600 uppercase">File Arsip</h5>
            <hr />

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                            <iframe class="flex gap-3 p-3 mb-0 items-right card flex-column" :src="pdfUrl" width="100%" height="700vh"></iframe>
                    </div>
                </div>
            </div>

            <h5 class="text-blue-600 uppercase">Informasi Metadata</h5>
            <hr />

            <div class="grid">
                <div class="col-6">
                    <div class="grid">
                        <div class="pb-0 col-12">
                            <div class="flex flex-row gap-2">
                                <label class="w-5 font-normal">Dibuat pada</label>
                                <h6 class="w-10 m-0 font-semibold">: {{ formData.created_at }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="grid">
                        <div class="pb-0 col-12">
                            <div class="flex flex-row gap-2">
                                <label class="w-5 font-normal">Diubah terakhir pada</label>
                                <h6 class="w-10 m-0 font-semibold">: {{ formData.updated_at }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<style lang="postcss" scoped></style>
