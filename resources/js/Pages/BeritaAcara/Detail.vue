<script setup>
import { ref, reactive, onMounted, watchEffect } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import AppLayout from "@/primevue/layout/AppLayout.vue";
import Button from "primevue/button";


const props = defineProps({
    id: String,
});

const formState = {
    id: "",
    nomor_surat: "",
    tanggal: "",
    tempat: "",
    jenis_media: "",
    jumlah_arsip: "",
    keterangan_arsip: "",
    proses: "",
    pelaksana: "",
    kepala_dinas: "",
    file_berita: "",
};

const pdfUrl = ref('');

const fetchPdfUrl = async (file) => {
    try {
        const response = await fetch(`/berita/pdf/preview/${file}`);
        const blob = await response.blob();
        pdfUrl.value = URL.createObjectURL(blob);
    } catch (error) {
        console.error('Error fetching PDF:', error);
    }
};

const formData = reactive({ ...formState });

const editForm = (id) => {
    router.visit("/berita-form", { method: "get", data: { id: id } });
};

const fetchData = () => {
    axios
        .get(`/api/berita/getById/${props.id}`)
        .then((res) => {
            const tanggal = new Date(res.data.tanggal);

            formData.id = res.data.id;
            formData.nomor_surat = res.data.nomor_surat;
            formData.tanggal = res.data.tanggal;
            formData.tempat = res.data.tempat;
            formData.jenis_media = res.data.jenis_media;
            formData.jumlah_arsip = res.data.jumlah_arsip;
            formData.keterangan_arsip = res.data.keterangan_arsip;
            formData.proses = res.data.proses;
            formData.pelaksana = res.data.pelaksana;
            formData.kepala_dinas = res.data.kepala_dinas;
            // formData.file_arsip = res.data.file_arsip;
            formData.created_at = res.data.created_at;
            formData.updated_at = res.data.updated_at;
            //pdfUrl.value = "/api/getImage/" + res.data.file_berita;
            fetchPdfUrl(res.data.file_berita);
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
};

onMounted(() => {
    if (props.id) fetchData();
    //fetchKlasifikasi();
    //fetchOPD();
    //fetchPdfUrl(formData.id);
});

</script>

<template>
    <app-layout>
        <div class="card">
            <div class="flex flex-row align-items-end justify-content-between">
                <h5 class="mb-0 text-blue-600 uppercase">Informasi Berita Acara</h5>
                <Button
                    type="button"
                    label="Ubah Data"
                    severity="info"
                    class="w-full md:w-auto"
                    icon="pi pi-pencil"
                    outlined
                    @click="editForm(formData.id)"
                />
            </div>
            <hr />

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">No Surat</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.nomor_surat }}</h6>
                    </div>
                </div>
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Tanggal </label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.tanggal }}</h6>
                    </div>
                </div>
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Jenis Media</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.jenis_media }}</h6>
                    </div>
                </div>
            </div>

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Jumlah Arsip</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.jumlah_arsip }}</h6>
                    </div>
                </div>
            </div>

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Tempat Pelaksanaan</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.tempat }}</h6>
                    </div>
                </div>
            </div>

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Keterangan</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.keterangan_arsip }}</h6>
                    </div>
                </div>
            </div>

            <h5 class="text-blue-600 uppercase">Informasi Proses Alihmedia</h5>
            <hr />

            <div class="grid mb-3">
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Proses Alihmedia</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.proses }}</h6>
                    </div>
                </div>
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Pelaksana</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.pelaksana }}</h6>
                    </div>
                </div>
                <div class="pb-0 col-12">
                    <div class="flex flex-row gap-2">
                        <label class="w-2 font-normal">Kepala Dinas</label>
                        <h6 class="w-10 m-0 font-semibold">: {{ formData.kepala_dinas }}</h6>
                    </div>
                </div>
            </div>

            <h5 class="text-blue-600 uppercase">File Berita Acara</h5>
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
