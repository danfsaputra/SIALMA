<script setup>
import { ref, reactive, inject, watchEffect } from "vue";
import axios from "axios";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import FileUpload from "primevue/fileupload";
import Image from "primevue/image";

const props = defineProps({
    isVisible: Boolean,
    items: Object,
});

const Swal = inject("$swal");
const emit = defineEmits(["form-close"]);

const formState = {
    id: "",
    tanggal_kegiatan: "",
    waktu_kegiatan: "",
    jenis_kegiatan: "",
    keterangan: "",
    photo: "",
    photo_ext: "",
};

const errors = ref({});
const formData = reactive({ ...formState });
const photoSource = ref(null);

const waktuKegiatan = ref([{ name: "Pagi" }, { name: "Siang" }, { name: "Malam" }]);

const closeForm = () => {
    emit("form-close");
    Object.assign(formData, formState);
    photoSource.value = null;
};

const onFileSelect = (event) => {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        photoSource.value = e.target.result;
        formData.photo = e.target.result.split(",")[1];
        formData.photo_ext = file.name.split(".").pop();
    };

    reader.readAsDataURL(file);
};

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/kegiatan/store", data)
            .then((res) => {
                if (res.data.success == true) {
                    emit("form-close");
                    Swal("", res.data.message, "success").then(() => {
                        Object.assign(formData, formState);
                        photoSource.value = null;
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
        const tanggal_kegiatan = new Date(props.items.tanggal_kegiatan);

        formData.id = props.items.id;
        formData.tanggal_kegiatan = tanggal_kegiatan.toLocaleDateString();
        formData.waktu_kegiatan = props.items.waktu_kegiatan;
        formData.jenis_kegiatan = props.items.jenis_kegiatan;
        formData.keterangan = props.items.keterangan;
        formData.photo = props.items.photo;
        photoSource.value = "api/kegiatan/image/" + props.items.photo;
    }
});
</script>

<template>
    <div>
        <Dialog
            class="w-full md:w-4"
            :visible="isVisible"
            header="Form Kegiatan"
            @update:visible="closeForm()"
            modal
        >
            <form @submit.prevent="submitForm(formData)">
                <hr class="mt-0 mb-5" />

                <div class="grid">
                    <div class="pb-0 col-12 md:col-6">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Tanggal Kegiatan</label>
                            <Calendar
                                v-model="formData.tanggal_kegiatan"
                                dateFormat="dd/mm/yy"
                                iconDisplay="input"
                                showIcon
                                :invalid="errors?.tanggal_kegiatan ? true : false"
                            />
                            <small v-if="errors?.tanggal_kegiatan">{{ errors.tanggal_kegiatan[0] }}</small>
                        </div>
                    </div>
                    <div class="col-12 md:col-6">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Waktu Kegiatan</label>
                            <Dropdown
                                v-model="formData.waktu_kegiatan"
                                :options="waktuKegiatan"
                                optionLabel="name"
                                optionValue="name"
                                placeholder="Pilih Waktu Kegiatan"
                                :highlightOnSelect="false"
                                :invalid="errors?.waktu_kegiatan ? true : false"
                            />
                            <small v-if="errors?.waktu_kegiatan">{{ errors.waktu_kegiatan[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Jenis Kegiatan</label>
                            <InputText
                                v-model="formData.jenis_kegiatan"
                                :invalid="errors?.jenis_kegiatan ? true : false"
                            />
                            <small v-if="errors?.jenis_kegiatan">{{ errors.jenis_kegiatan[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="col-12">
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

                <div class="grid">
                    <div class="col-12">
                        <div class="flex gap-2 flex-column">
                            <label class="font-semibold required">Foto Kegiatan</label>
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
                                v-model="formData.photo"
                                @select="onFileSelect"
                                customUpload
                                auto
                                :maxFileSize="1000000"
                                accept="image/*"
                                chooseLabel="Pilih File"
                                class="w-full px-4 py-2 text-green-500 border-green-600 p-button-outlined md:w-auto"
                            />
                            <small v-if="errors?.photo">{{ errors.photo[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-3">
                    <Button
                        type="button"
                        label="Batal"
                        severity="secondary"
                        outlined
                        @click.stop="closeForm()"
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
