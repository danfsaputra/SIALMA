<script setup>
import AppLayout from "@/primevue/layout/AppLayout.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref, onMounted } from "vue";
import axios from "axios";
import Button from "primevue/button";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";

const pegawaikab = ref([]);
const perPage = ref(10);
const totalItems = ref(0);
const sortField = ref("nama_lengkap");
const sortOrder = ref(1);
const search = ref("");
let currentPage = 1;

const pegawaikabDialog = ref(false);
const deletepegawaikabDialog = ref(false);
const selectedpegawaikab = ref(null);

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

const editpegawaikab = (editpegawaikab) => {
    pegawaikab.value = { ...editpegawaikab };
    pegawaikabDialog.value = true;
};

const confirmDeletepegawaikab = (editpegawaikab) => {
    pegawaikab.value = editpegawaikab;
    deletepegawaikabDialog.value = true;
};

const fetchData = () => {
    axios
        .get(
            `/api/user?page=${currentPage}&perPage=${perPage.value}&sortField=${sortField.value}&sortOrder=${sortOrder.value}&search=${search.value}`
        )
        .then((response) => {
            pegawaikab.value = response.data.data;
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
                    <div class="flex mb-4 justify-left justify-content-between">
                        <Button
                            @click=""
                            type="button"
                            label="Tambah"
                            icon="pi pi-plus"
                            outlined
                        />
                        <IconField>
                            <InputIcon class="pi pi-search pe-1" />
                            <InputText
                                v-model="search"
                                class="w-30rem"
                                placeholder="Ketikkan kata kunci ..."
                                @keypress.enter="fetchData"
                            />
                        </IconField>
                    </div>
                    <DataTable
                        :value="pegawaikab"
                        v-model:selection="selectedpegawaikab"
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
                        <template #paginatorstart>
                            <Button
                                label="Save"
                                type="button"
                                icon="pi pi-download"
                                text
                            />
                        </template>
                        <Column
                            field="nip"
                            style="width: 20%"
                            header="ID Pegawai"
                            sortable
                        >
                            <template #body="slotProps">
                                {{ slotProps.data.nip.replaceAll(" ", "") }}
                            </template>
                        </Column>
                        <Column
                            field="nama_lengkap"
                            style="width: 25%"
                            header="Nama Lengkap"
                            sortable
                        ></Column>
                        <Column
                            field="golongan"
                            style="width: 20%"
                            header="Golongan"
                            sortable
                        ></Column>
                        <Column
                            field="nama_jabatan"
                            header="Nama Jabatan"
                            style="width: 20%"
                            sortable
                        ></Column>
                        <Column header="Action">
                            <template #body="slotProps">
                                <Button
                                    icon="pi pi-pencil"
                                    class="mr-2"
                                    severity="info"
                                    rounded
                                    outlined
                                    @click="editpegawaikab(slotProps.data)"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="mt-2"
                                    severity="danger"
                                    rounded
                                    outlined
                                    @click="
                                        confirmDeletepegawaikab(slotProps.data)
                                    "
                                />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<style scoped lang="scss"></style>
