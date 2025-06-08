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
        formData.file_berita = e.target.result.split(",")[1];
        formData.photo_ext = file.name.split(".").pop();
    };

    reader.readAsDataURL(file);
};


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

const errors = ref({});
const formData = reactive({ ...formState });


const jenisArsip = ref([
    { name: "Arsip Tekstual", id: "Arsip Tekstual" },
    // { name: "Arsip Foto", id: "Arsip Foto" },
    // { name: "Arsip kartografi dan kearsitekturan", id: "Arsip kartografi dan kearsitekturan" },
    // { name: "Arsip Video", id: "Arsip Video" },
    // { name: "Arsip Rekaman Suara", id: "Arsip Rekaman Suara" },
    // { name: "Arsip Poster", id: "Arsip Poster" },
    // { name: "Arsip suara", id: "Arsip suara" },
]);

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/berita/store", data)
            .then((res) => {
                if (res.data.success == true) {
                    Swal("", res.data.message, "success").then(() => {
                        Object.assign(formData, formState);
                        photoSource.value = null;
                        return router.visit("/berita", { method: "get", data: { id: res.data.id } });
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
        .get(`/api/berita/getById/${props.id}`)
        .then((res) => {
            const tanggal= new Date(res.data.tanggal);

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
            formData.file_berita = res.data.file_berita;
            formData.photo_ext = "pdf"; 
            photoSource.value = `data:application/pdf;base64,${res.data.file_berita}`;
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
                <h5 class="text-blue-600 uppercase">Informasi Berita Acara</h5>
                <hr />

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Nomor Berita Acara</label>
                            <InputText
                                v-model="formData.nomor_surat"
                                :invalid="errors?.nomor_surat ? true : false"
                            />
                            <small v-if="errors?.nomor_surat">{{ errors.nomor_surat[0] }}</small>
                        </div>
                    </div>

                <div class="pb-0 col-12 md:col-3">
                    <div class="flex gap-2 flex-column">
                        <label class="font-semibold required">Tanggal</label>
                        <Calendar
                            v-model="formData.tanggal"
                            dateFormat="yy/mm/dd"
                            iconDisplay="input"
                            showIcon
                            :invalid="errors?.tanggal ? true : false"
                        />
                        <small v-if="errors?.tanggal">{{ errors.tanggal[0] }}</small>
                    </div>
                </div>

                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Jenis Media</label>
                            <Dropdown
                                v-model="formData.jenis_media"
                                :options="jenisArsip"
                                filter optionLabel="name"
                                optionValue="id"
                                placeholder="Pilih Jenis Arsip"
                                class="w-auto"
                            />
                            <small v-if="errors?.jenis_media">{{ errors.jenis_media[0] }}</small>
                        </div>
                    </div>
                
                    <div class="pb-0 col-12 md:col-3">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Jumlah Arsip</label>
                            <InputText
                                v-model="formData.jumlah_arsip"
                                :invalid="errors?.jumlah_arsip ? true : false"
                            />
                            <small v-if="errors?.jumlah_arsip">{{ errors.jumlah_arsip[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Tempat Pelaksanaan</label>
                            <Textarea
                                v-model="formData.tempat"
                                rows="3"
                                :invalid="errors?.tempat ? true : false"
                            />
                            <small v-if="errors?.tempat">{{ errors.tempat[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Keterangan</label>
                            <Textarea
                                v-model="formData.keterangan_arsip"
                                rows="3"
                                :invalid="errors?.keterangan_arsip ? true : false"
                            />
                            <small v-if="errors?.keterangan_arsip">{{ errors.keterangan_arsip[0] }}</small>
                        </div>
                    </div>
                </div>

                <h5 class="mt-6 text-blue-600 uppercase">Informasi Proses Alihmedia</h5>
                <hr />

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Proses Alihmedia</label>
                            <InputText
                                v-model="formData.proses"
                                :invalid="errors?.proses ? true : false"
                            />
                            <small v-if="errors?.proses">{{ errors.proses[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid mb-3">
                    <div class="pb-0 col-12 md:col-4">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Pelaksana</label>
                            <InputText
                                v-model="formData.pelaksana"
                                :invalid="errors?.pelaksana ? true : false"
                            />
                            <small v-if="errors?.pelaksana">{{ errors.pelaksana[0] }}</small>
                        </div>
                    </div>

                    <div class="pb-0 col-12 md:col-4">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Kepala Dinas</label>
                            <InputText
                                v-model="formData.kepala_dinas"
                                :invalid="errors?.kepala_dinas ? true : false"
                            />
                            <small v-if="errors?.kepala_dinas">{{ errors.kepala_dinas[0] }}</small>
                        </div>
                    </div>

                    <div class="pb-0 col-12 md:col-4">
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
                                v-model="formData.file_berita"
                                @select="onFileSelect"
                                customUpload
                                auto
                                :maxFileSize="1000000"
                                accept="application/pdf"
                                chooseLabel="Pilih File"
                                class="w-full px-4 py-2 text-green-500 border-green-600 p-button-outlined md:w-auto"
                            />
                            <small v-if="errors?.file_berita">{{ errors.file_berita[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <Link :href="route('berita')">
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
