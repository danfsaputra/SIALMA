<template>
    <app-layout>
        <div class="grid">
            <div class="col-12">
                <div class="card">
                    <div class="flex mb-4 justify-left justify-content-between">
                        <Button
                            @click="addPegawaikab"
                            type="button"
                            label="Tambah"
                            icon="pi pi-pencil"
                            outlined
                        />
                        <Button
                            @click="addkasus"
                            type="button"
                            label="Print"
                            icon="pi pi-print"
                            outlined
                        />
                    </div>
                    <DataTable
                        :value="pelanggaran"
                        v-model:selection="selectedPelanggaran"
                        :paginator="true"
                        :rows="perPage"
                        :totalRecords="totalItems"
                        @page="onPageChange"
                        tableStyle="min-width: 50rem"
                        scrollable
                        scrollHeight="500px"
                        ref="dt"
                        dataKey="id"
                        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                        :rowsPerPageOptions="[5, 10, 25, 50]"
                        currentPageReportTemplate="Menampilkan {first} dari {last} total {totalRecords} Data Pelanggaran"
                        :lazy="true"
                        stripedRows
                        :sortable="true"
                        filterDisplay="menu"
                    >
                        <template #paginatorstart>
                            <Button
                                label="Refresh"
                                type="button"
                                icon="pi pi-refresh"
                                text
                            />
                        </template>
                        <template #paginatorend>
                            <Button
                                label="Save"
                                type="button"
                                icon="pi pi-download"
                                text
                            />
                        </template>
                        <!-- <Column field="plg_id" sortable style="width: 25%" header="ID"></Column> -->
                        <Column
                            field="plg_tanggal"
                            sortable
                            header="Tanggal Pelanggaran"
                        ></Column>
                        <Column
                            field="plg_lokasi"
                            header="Lokasi Pelanggaran"
                        ></Column>
                        <!-- <Column field="refmodul.ref_jenis" header="Tanggal Penindakan"></Column> -->
                        <Column
                            field="refmodul.ref_nama"
                            header="Jenis Pelanggaran"
                        ></Column>
                        <Column
                            field="plg_jumlah"
                            header="Jumlah Pelanggaran"
                        ></Column>
                        <Column header="Action">
                            <template #body="slotProps">
                                <Button
                                    icon="pi pi-pencil"
                                    class="mr-2"
                                    severity="info"
                                    rounded
                                    outlined
                                    @click="editPelanggaran(slotProps.data)"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="mt-2"
                                    severity="danger"
                                    rounded
                                    outlined
                                    @click="
                                        confirmDeletePelanggaran(slotProps.data)
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

<script setup>
import AppLayout from "@/primevue/layout/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref, onMounted } from "vue";
import axios from "axios";
import Button from "primevue/button";
import Breadcrumb from "primevue/breadcrumb";

const pelanggaran = ref([]);
const perPage = ref(10);
const totalItems = ref(0);
let currentPage = 1;

const pelanggaranDialog = ref(false);
const deletepelanggaranDialog = ref(false);
const selectedPelanggaran = ref(null);

const onPageChange = (event) => {
    currentPage = event.page + 1;
    fetchData();
};

const clearFilter = () => {
    initFilters();
};

const editPelanggaran = (editPelanggaran) => {
    pelanggaran.value = { ...editPelanggaran };
    pelanggaranDialog.value = true;
};

const confirmDeletePelanggaran = (editPelanggaran) => {
    pelanggaran.value = editPelanggaran;
    deletepelanggaranDialog.value = true;
};

const fetchData = () => {
    axios
        .get(`/api/pelanggaran?page=${currentPage}&perPage=${perPage.value}`)
        .then((response) => {
            pelanggaran.value = response.data.data;
            totalItems.value = response.data.total;

            // console.log(response.data.total)
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
};

onMounted(() => {
    fetchData();
});
</script>

<style scoped lang="scss"></style>
