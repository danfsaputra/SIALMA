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
                        :value="kasandra"
                        v-model:selection="selectedkasandra"
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
                        currentPageReportTemplate="Menampilkan {first} dari {last} total {totalRecords} Data kasandra"
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
                            field="urusan_pemerintahan"
                            sortable
                            header="Urusan Pemerintahan"
                        ></Column>
                        <Column
                            field="jenis_tertib"
                            header="Jenis Tertib"
                        ></Column>
                        <!-- <Column field="refmodul.ref_jenis" header="Tanggal Penindakan"></Column> -->
                        <Column field="perda" header="Perda"></Column>
                        <Column
                            field="pasal_kewajiban"
                            header="Pasal Kewajiban"
                        ></Column>
                        <Column field="kewajiban" header="Kewajiban"></Column>
                        <Column
                            field="pasal_sanksi_adm"
                            header="Pasal Sanksi Adm"
                        ></Column>
                        <Column field="sanksi_adm" header="Sanksi Adm"></Column>
                        <Column
                            field="pasal_sanksi_pidana"
                            header="Pasal Sanksi Pidana"
                        ></Column>
                        <Column
                            field="sanksi_pidana"
                            header="Sanksi Pidana"
                        ></Column>
                        <Column header="Action">
                            <template #body="slotProps">
                                <Button
                                    icon="pi pi-pencil"
                                    class="mr-2"
                                    severity="info"
                                    rounded
                                    outlined
                                    @click="editkasandra(slotProps.data)"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    class="mt-2"
                                    severity="danger"
                                    rounded
                                    outlined
                                    @click="
                                        confirmDeletekasandra(slotProps.data)
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

const kasandra = ref([]);
const perPage = ref(10);
const totalItems = ref(0);
let currentPage = 1;

const kasandraDialog = ref(false);
const deletekasandraDialog = ref(false);
const selectedkasandra = ref(null);

const onPageChange = (event) => {
    currentPage = event.page + 1;
    fetchData();
};

const clearFilter = () => {
    initFilters();
};

const editkasandra = (editkasandra) => {
    kasandra.value = { ...editkasandra };
    kasandraDialog.value = true;
};

const confirmDeletekasandra = (editkasandra) => {
    kasandra.value = editkasandra;
    deletekasandraDialog.value = true;
};

const fetchData = () => {
    axios
        .get(`/api/kasandra?page=${currentPage}&perPage=${perPage.value}`)
        .then((response) => {
            kasandra.value = response.data.data;
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
