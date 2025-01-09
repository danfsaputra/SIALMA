<script setup>
import { ref, onMounted, inject } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import AppLayout from "@/primevue/layout/AppLayout.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";

const fetchedData = ref([]);
const perPage = ref(10);
const totalItems = ref(0);
const sortField = ref("id");
const sortOrder = ref(-1);
const search = ref("");

const Swal = inject("$swal");
const isVisible = ref(false);
const items = ref();

let currentPage = 1;

const onPageChange = (event) => {
    perPage.value = event.rows;
    currentPage = event.page + 1;
    fetchData();
};

const onSort = (event) => {
    sortField.value = event.sortField;
    sortOrder.value = event.sortOrder;
    fetchData();
};

// const openForm = () => {
//     isVisible.value = true;
// };

const closeForm = () => {
    isVisible.value = false;
    fetchData();
};

const viewDetail = (id) => {
    router.visit("/validasi-detail", { method: "get", data: { id: id } });
};

const editForm = (id) => {
    router.visit("/alihmedia-form", { method: "get", data: { id: id } });
};

const deleteData = (id) => {
    Swal({
        icon: "question",
        text: "Anda yakin menghapus data ini ?",
        showCancelButton: true,
        cancelButtonText: "Batal",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                await axios.get("/sanctum/csrf-cookie");

                axios
                    .post("/api/alihmedia/destroy/" + id)
                    .then((res) => {
                        Swal("", res.data.message, "success");
                    })
                    .finally(() => fetchData());
            } catch (err) {
                console.log(err);
            }
        }
    });
};

// const fetchKlasifikasi = async () => {
//     axios.get("api/getKlasifikasi").then((res) => {
//         klasifikasi.value = res.data;
//     });
// };

const fetchData = () => {
    axios
        .get(
            `/api/validasidata?page=${currentPage}&perPage=${perPage.value}&sortField=${sortField.value}&sortOrder=${sortOrder.value}&search=${search.value}`
        )
        .then((response) => {
            fetchedData.value = response.data.data;
            totalItems.value = response.data.total;
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
};

onMounted(() => {
    fetchData();
});
</script>

<template>
    <app-layout>
        <div class="grid">
            <div class="col-12">
                <div class="card">
                    <div class="flex flex-wrap mb-4 md:flex-nowrap">
                        <!-- <div class="w-full mb-3 md:mb-0">
                            <Link :href="route('alihmedia-form')">
                                <Button
                                    type="button"
                                    label="Tambah"
                                    class="w-full md:w-auto"
                                    icon="pi pi-plus"
                                    outlined
                                />
                            </Link>
                        </div> -->
                        <div class="w-full">
                            <IconField>
                                <InputIcon class="pi pi-search pe-1" />
                                <InputText
                                    v-model="search"
                                    class="w-full"
                                    placeholder="Ketikkan kata kunci ..."
                                    @keypress.enter="fetchData"
                                />
                            </IconField>
                        </div>
                    </div>

                    <DataTable
                        :value="fetchedData"
                        :paginator="true"
                        :rows="perPage"
                        :totalRecords="totalItems"
                        @page="onPageChange"
                        @sort="onSort"
                        scrollable
                        ref="dt"
                        dataKey="id"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        :rowsPerPageOptions="[5, 10, 25, 50]"
                        currentPageReportTemplate="Menampilkan {first} sampai {last} dari {totalRecords} data"
                        :lazy="true"
                        stripedRows
                        :sortable="true"
                        filterDisplay="menu"
                    >
                        <template #empty>
                            <p class="text-center">Data tidak ditemukan</p>
                        </template>
                        <template #paginatorstart>
                            <Button
                                label="Export Data"
                                type="button"
                                icon="pi pi-download"
                                severity="success"
                                text
                            />
                        </template>
                        <Column
                            field="opd"
                            header="OPD"
                            class="w-25"
                            sortable
                        >
                        </Column>
                        <Column
                            field="tgl_arsip"
                            header="Tanggal Arsip"
                            class="w-25"
                            sortable
                            dateFormat="dd/mm/yy"
                        >
                        </Column>
                        <Column
                            field="no_arsip"
                            header="Nomor Arsip"
                        ></Column>
                        <Column
                            field="jenis_arsip"
                            header="Jenis Arsip"
                        ></Column>
                        <Column
                            field="klasifikasi_arsip"
                            header="Klasifikasi Arsip"
                        ></Column>
                        <!-- <Column
                            field="uraian"
                            header="Uraian Arsip"
                        ></Column> -->
                        <!-- <Column
                            field="no_box"
                            header="Nomor Box"
                            sortable
                        ></Column>
                        <Column
                            field="no_berkas"
                            header="Nomor Berkas"
                            sortable
                        ></Column>
                        <Column
                            field="keterangan"
                            header="Keterangan"
                        ></Column> -->
                        <Column header="Aksi">
                            <template #body="slotProps">
                                <!-- <Button
                                    icon="pi pi-pencil"
                                    severity="info"
                                    rounded
                                    outlined
                                    @click="editForm(slotProps.data.id)"
                                /> -->
                                <Button
                                    icon="pi pi-file"
                                    severity="info"
                                    label="Preview"
                                    rounded
                                    outlined
                                    @click="viewDetail(slotProps.data.id)"
                                />
                                <!-- <Button
                                    icon="pi pi-trash"
                                    severity="danger"
                                    rounded
                                    outlined
                                    @click="deleteData(slotProps.data.id)"
                                /> -->
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </app-layout>

    <Form
        :isVisible="isVisible"
        :items="items"
        @form-close="closeForm"
    />
</template>
