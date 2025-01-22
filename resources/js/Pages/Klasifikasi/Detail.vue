<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
import AppLayout from "@/primevue/layout/AppLayout.vue";

const route = useRoute();
const fetchedData = ref([]);
const perPage = ref(10);
const totalItems = ref(0);
const sortField = ref("id");
const sortOrder = ref(-1);
const search = ref("");
const isVisible = ref(false);
const items = ref();

let currentPage = 1;

const fetchDetail = async () => {
    const nm_klasifikasi = route.query.nm_klasifikasi;
    try {
        const response = await axios.get(`/api/klasifikasi/alihmedia`, { params: { nm_klasifikasi } });
        fetchedData.value = response.data.data;
        totalItems.value = response.data.total;
    } catch (error) {
        console.error("Error fetching detail data:", error);
    }
};

const onPageChange = (event) => {
    perPage.value = event.rows;
    currentPage = event.page + 1;
    fetchDetail();
};

const onSort = (event) => {
    sortField.value = event.sortField;
    sortOrder.value = event.sortOrder;
    fetchDetail();
};

const closeForm = () => {
    isVisible.value = false;
    fetchDetail();
};

onMounted(() => {
    fetchDetail();
});
</script>

<template>
    <AppLayout>
        <div>
            <h1>Detail Klasifikasi</h1>
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
                ></Column>
                <Column
                    field="tgl_arsip"
                    header="Tanggal Arsip"
                    class="w-25"
                    sortable
                    dateFormat="dd/mm/yy"
                ></Column>
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
                <Column header="Aksi">
                    <template #body="slotProps">
                        <Button
                            icon="pi pi-file"
                            severity="info"
                            label="Preview"
                            rounded
                            outlined
                            @click="viewDetail(slotProps.data.id)"
                        />
                    </template>
                </Column>
            </DataTable>
        </div>
    </AppLayout>

    <Form
        :isVisible="isVisible"
        :items="items"
        @form-close="closeForm"
    />
</template>