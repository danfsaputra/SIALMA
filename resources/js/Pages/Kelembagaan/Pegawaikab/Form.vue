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
    nip: "",
    nama_lengkap: "",
    tempat_lahir: "",
    tanggal_lahir: "",
    jenis_kelamin: "",
    alamat: "",
    email: "",
    nohp: "",
    status_pegawai: "",
};

const errors = ref({});
const formData = reactive({ ...formState });

const jenisKelamin = ref([
    { name: "Laki - Laki", id: "L" },
    { name: "Perempuan", id: "P" },
]);

const statusPegawai = ref([
    { name: "Pegawai Negeri Sipil (PNS)", id: "PNS" },
    { name: "Pegawai Tidak Tetap dengan Perjanjian Kerja (PTT-PK)", id: "PTT-PK" },
]);

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        const body = {...data, tanggal_lahir: new Intl.DateTimeFormat('id-ID').format(data['tanggal_lahir'])}

        axios
            .post("/api/pegawaikab/store", body)
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
        const tanggal_lahir = new Date(props.items.tanggal_lahir);

        formData.id = props.items.id;
        formData.nip = props.items.nip;
        formData.nama_lengkap = props.items.nama_lengkap;
        formData.tempat_lahir = props.items.tempat_lahir;
        formData.tanggal_lahir = tanggal_lahir.toLocaleDateString('id-ID');
        formData.jenis_kelamin = props.items.jenis_kelamin;
        formData.alamat = props.items.alamat;
        formData.email = props.items.email;
        formData.nohp = props.items.nohp;
        formData.status_pegawai = props.items.status_pegawai;
    }
});

</script>

<template>
    <div>
        <Dialog
            class="w-full md:w-auto"
            :visible="isVisible"
            header="Form Pegawai Kabupaten"
            @update:visible="emit('form-close')"
            modal
        >
            <form @submit.prevent="submitForm(formData)">
                <hr class="mt-0 mb-6" />

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">NIP / ID Pegawai</label>
                        <InputText
                            v-model="formData.nip"
                            :invalid="errors?.nip ? true : false"
                        />
                        <small v-if="errors?.nip">{{ errors.nip[0] }}</small>
                    </div>

                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Nama Lengkap</label>
                        <InputText
                            class="uppercase"
                            v-model="formData.nama_lengkap"
                            :invalid="errors?.nama_lengkap ? true : false"
                        />
                        <small v-if="errors?.nama_lengkap">{{ errors.nama_lengkap[0] }}</small>
                    </div>
                </div>

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Tempat Lahir</label>
                        <InputText
                            v-model="formData.tempat_lahir"
                            :invalid="errors?.tempat_lahir ? true : false"
                        />
                        <small v-if="errors?.tempat_lahir">{{ errors.tempat_lahir[0] }}</small>
                    </div>

                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Tanggal Lahir</label>
                        <Calendar
                            v-model="formData.tanggal_lahir"
                            dateFormat="dd/mm/yy"
                            iconDisplay="input"
                            showIcon
                            :invalid="errors?.tanggal_lahir ? true : false"
                        />
                        <small v-if="errors?.tanggal_lahir">{{ errors.tanggal_lahir[0] }}</small>
                    </div>

                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Jenis Kelamin</label>
                        <Dropdown
                            v-model="formData.jenis_kelamin"
                            :options="jenisKelamin"
                            optionLabel="name"
                            optionValue="id"
                            placeholder="Pilih Jenis Kelamin"
                            :highlightOnSelect="false"
                            checkmark
                            :invalid="errors?.jenis_kelamin ? true : false"
                        />
                        <small v-if="errors?.jenis_kelamin">{{ errors.jenis_kelamin[0] }}</small>
                    </div>
                </div>

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Alamat Lengkap</label>
                        <Textarea
                            v-model="formData.alamat"
                            rows="2"
                            :invalid="errors?.alamat ? true : false"
                        />
                        <small v-if="errors?.alamat">{{ errors.alamat[0] }}</small>
                    </div>
                </div>

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">Email</label>
                        <InputText
                            v-model="formData.email"
                            :invalid="errors?.nohp ? true : false"
                        />
                        <small v-if="errors?.nohp">{{ errors.nohp[0] }}</small>
                    </div>

                    <div class="flex gap-2 flex-column grow">
                        <label class="font-semibold required">No. Telepon</label>
                        <InputText
                            v-model="formData.nohp"
                            :invalid="errors?.nohp ? true : false"
                        />
                        <small v-if="errors?.nohp">{{ errors.nohp[0] }}</small>
                    </div>
                </div>

                <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
                    <div class="flex w-full gap-2 flex-column">
                        <label class="font-semibold required">Status Pegawai</label>
                        <Dropdown
                            v-model="formData.status_pegawai"
                            :options="statusPegawai"
                            optionLabel="name"
                            optionValue="name"
                            placeholder="Pilih Status Pegawai"
                            :highlightOnSelect="false"
                            :invalid="errors?.status_pegawai ? true : false"
                        />
                        <small v-if="errors?.status_pegawai">{{ errors.status_pegawai[0] }}</small>
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
