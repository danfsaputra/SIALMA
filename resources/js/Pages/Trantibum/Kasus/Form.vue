<script setup>
import { ref, reactive, inject, watchEffect } from "vue";
import axios from "axios";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";

const props = defineProps({
    isVisible: Boolean,
    items: Object,
});

const Swal = inject("$swal");
const emit = defineEmits(["form-close"]);

const formState = {
    id: "",
    nama_pelanggar: "",
    nik_pelanggar: "",
    waktu_kejadian: "",
    sumber_informasi: "",
    nomor_surat_link: "",
    potensi_pad: "",
    koordinat: "",
    opd_pengampu: "",
};

const errors = ref({});
const formData = reactive({ ...formState });

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/kasus/store", data)
            .then((res) => {
                if (res.data.success == true) {
                    emit("form-close");
                    Swal("", res.data.message, "success").then(() => {
                        Object.assign(formData, formState);
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

watchEffect(() => {
    if (props.items) {
        const waktu_kejadian = new Date(props.items.waktu_kejadian);

        formData.id = props.items.id;
        formData.nama_pelanggar = props.items.nama_pelanggar;
        formData.nik_pelanggar = props.items.nik_pelanggar;
        formData.waktu_kejadian = waktu_kejadian.toLocaleDateString();
        formData.sumber_informasi = props.items.sumber_informasi;
        formData.nomor_surat_link = props.items.nomor_surat_link;
        formData.potensi_pad = props.items.potensi_pad;
        formData.koordinat = props.items.koordinat;
        formData.opd_pengampu = props.items.opd_pengampu;
    }
});
</script>

<template>
    <div>
        <Dialog
            class="w-full md:w-auto"
            :visible="isVisible"
            header="Form Kasus"
            @update:visible="emit('form-close')"
            modal
        >
            <form @submit.prevent="submitForm(formData)">
                <hr class="mt-0 mb-6" />

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Nama Pelanggar</label>
                        <InputText
                            v-model="formData.nama_pelanggar"
                            :invalid="errors?.nama_pelanggar ? true : false"
                        />
                        <small v-if="errors?.nama_pelanggar">{{ errors.nama_pelanggar[0] }}</small>
                    </div>

                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">NIK Pelanggar</label>
                        <InputText
                            class="uppercase"
                            v-model="formData.nik_pelanggar"
                            :invalid="errors?.nik_pelanggar ? true : false"
                        />
                        <small v-if="errors?.nik_pelanggar">{{ errors.nik_pelanggar[0] }}</small>
                    </div>
                </div>
                    <div class="flex gap-2 mb-5 flex-column grow">
                        <label class="font-semibold required">Waktu Kejadian</label>
                        <Calendar
                            v-model="formData.waktu_kejadian"
                            dateFormat="dd/mm/yy"
                            iconDisplay="input"
                            showIcon
                            :invalid="errors?.waktu_kejadian ? true : false"
                        />
                        <small v-if="errors?.waktu_kejadian">{{ errors.waktu_kejadian[0] }}</small>
                    </div>

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Sumber Informasi</label>
                        <Textarea
                            v-model="formData.sumber_informasi"
                            rows="2"
                            :invalid="errors?.sumber_informasi ? true : false"
                        />
                        <small v-if="errors?.sumber_informasi">{{ errors.sumber_informasi[0] }}</small>
                    </div>
                </div>

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Potensi PAD</label>
                        <InputText v-model="formData.potensi_pad" />
                        <small v-if="errors?.potensi_pad">{{ errors.potensi_pad[0] }}</small>
                    </div>

                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Nomor Surat</label>
                        <InputText
                            v-model="formData.nomor_surat_link"
                            :invalid="errors?.nomor_surat_link ? true : false"
                        />
                        <small v-if="errors?.nomor_surat_link">{{ errors.nomor_surat_link[0] }}</small>
                    </div>
                </div>

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Koordinat</label>
                        <InputText
                            disabled
                            v-model="formData.koordinat"
                            rows="2"
                            :invalid="errors?.koordinat ? true : false"
                        />
                        <small v-if="errors?.koordinat">{{ errors.koordinat[0] }}</small>
                    </div>
                </div>

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">OPD Pengampu</label>
                        <InputText
                            v-model="formData.opd_pengampu"
                            rows="2"
                            :invalid="errors?.opd_pengampu ? true : false"
                        />
                        <small v-if="errors?.opd_pengampu">{{ errors.opd_pengampu[0] }}</small>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <Button
                        type="button"
                        label="Batal"
                        severity="secondary"
                        outlined
                        @click.stop="emit('form-close')"
                    ></Button>
                    <Button
                        type="submit"
                        label="Simpan"
                    ></Button>
                </div>
            </form>
        </Dialog>
    </div>
    <Toast />
</template>

<style lang="postcss" scoped>
small {
    @apply text-xs font-medium text-red-400;
}
</style>
