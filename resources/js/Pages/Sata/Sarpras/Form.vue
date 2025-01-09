<script setup>
import { ref, reactive, inject, watchEffect } from "vue";
import axios from "axios";
import Button from "primevue/button";
import InputText from "primevue/inputtext";

const props = defineProps({
    isVisible: Boolean,
    items: Object,
});

const Swal = inject("$swal");
const emit = defineEmits(["form-close"]);

const formState = {
    id: "",
    nama: "",
    jumlah: "",
    jumlah_layak: "",
    jumlah_tidak_layak: "",
};

const errors = ref({});
const formData = reactive({ ...formState });

const closeForm = () => {
    emit("form-close");
    Object.assign(formData, formState);
};

const submitForm = async (data) => {
    try {
        await axios.get("/sanctum/csrf-cookie");

        axios
            .post("/api/sarpras/store", data)
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
        formData.id = props.items.id;
        formData.nama = props.items.nama;
        formData.jumlah = props.items.jumlah;
        formData.jumlah_layak = props.items.jumlah_layak;
        formData.jumlah_tidak_layak = props.items.jumlah_tidak_layak;
    }
});
</script>

<template>
    <div>
        <Dialog
            class="w-full md:w-4"
            :visible="isVisible"
            header="Form Sarana Prasarana"
            @update:visible="closeForm()"
            modal
        >
            <form @submit.prevent="submitForm(formData)">
                <hr class="mt-0 mb-5" />

                <div class="grid">
                    <div class="col-12">
                        <div class="flex flex-column gap-2">
                            <label class="font-semibold required">Deskripsi Sarana Prasarana</label>
                            <InputText
                                v-model="formData.nama"
                                :invalid="errors?.nama ? true : false"
                            />
                            <small v-if="errors?.nama">{{ errors.nama[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="col-12 md:col-4 pb-0">
                        <div class="flex flex-column gap-2">
                            <label class="font-semibold required">Jumlah</label>
                            <InputText
                                type="number"
                                v-model="formData.jumlah"
                                :invalid="errors?.jumlah ? true : false"
                            />
                            <small v-if="errors?.jumlah">{{ errors.jumlah[0] }}</small>
                        </div>
                    </div>
                    <div class="col-12 md:col-4 pb-0">
                        <div class="flex flex-column gap-2">
                            <label class="font-semibold">Jumlah Layak</label>
                            <InputText
                                type="number"
                                v-model="formData.jumlah_layak"
                                :invalid="errors?.jumlah_layak ? true : false"
                            />
                            <small v-if="errors?.jumlah_layak">{{ errors.jumlah_layak[0] }}</small>
                        </div>
                    </div>
                    <div class="col-12 md:col-4 pb-0">
                        <div class="flex flex-column gap-2">
                            <label class="font-semibold">Jumlah Tidak Layak</label>
                            <InputText
                                type="number"
                                v-model="formData.jumlah_tidak_layak"
                                :invalid="errors?.jumlah_tidak_layak ? true : false"
                            />
                            <small v-if="errors?.jumlah_tidak_layak">{{ errors.jumlah_tidak_layak[0] }}</small>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-5">
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
