<script setup>
import { FilterMatchMode } from "primevue/api";
import AppLayout from "@/primevue/layout/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref, onMounted, inject } from "vue";
import axios from "axios";
import Button from "primevue/button";
import Breadcrumb from "primevue/breadcrumb";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import mapboxgl from "mapbox-gl";
import { MapboxMap, MapboxGeolocateControl } from "@studiometa/vue-mapbox-gl";
import { useToast } from "primevue/usetoast";
import Form from "@/Pages/Trantibum/Kasus/Form.vue";

const Swal = inject("$swal");
const isVisible = ref(false);
const items = ref();

const toast = useToast();

const kasus = ref([]);
const perPage = ref(10);
const totalItems = ref(0);
const sortField = ref("nama_pelanggar");
const sortOrder = ref(1);
const search = ref("");
let currentPage = 1;

// const mapCenter = ref([-7.1583190103346475, 111.68846186783094]);
const mapCenter = ref([0, 0]);

const selectedKasus = ref(null);

// Add Kasus

const onPageChange = (event) => {
  perPaga.value = event.rows;
  currentPage = event.page + 1;
  fetchData();
};

const openForm = () => {
    isVisible.value = true;
};

const closeForm = () => {
    isVisible.value = false;
    fetchData();
};

const onSort = (event) => {
  sortField.value = event.sortField;
  sortOrder.value = event.sortOrder;
  fetchData();
};

// Edit Kasus
const editForm = (item) => {
  isVisible.value = true;
  items.value = item;
};

// Delete Kasus
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
          .post("/api/kasus/destroy/" + id)
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

// Get Data Index
const fetchData = () => {
  axios
    .get(
      `/api/kasus?page=${currentPage}&perPage=${perPage.value}&sortField=${sortField.value}&sortOrder=${sortOrder.value}&search=${search.value}`
    )
    .then((response) => {
      kasus.value = response.data.data;
      totalItems.value = response.data.total;
    //   toast.add({
    //     severity: "success",
    //     summary: "Data Kasus",
    //     detail: "Berhasil Mengambil Data",
    //     life: 3000,
    //   });

      // console.log(response.data.total)
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
};

onMounted(() => {
  fetchData();

  // console.log(totalItems.value)
});

// Maps

// Function Rupiah
function formatRupiah(value) {
  // console.log(value);
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
  }).format(value);
}
</script>

<template>
  <app-layout>
    <div class="grid">
      <div class="col-12">
        <div class="card">
          <div class="flex flex-wrap mb-4 md:flex-nowrap">
            <div class="w-full mb-3 md:mb-0">
              <Button
                @click="openForm"
                type="button"
                label="Tambah"
                class="w-full md:w-auto"
                icon="pi pi-plus"
                outlined
              />
            </div>
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
            :value="kasus"
            v-model:selection="selectedKasus"
            :paginator="true"
            :rows="perPage"
            :totalRecords="totalItems"
            @page="onPageChange"
            @sort="onSort"
            tableStyle="min-width: 50rem"
            scrollable
            scrollHeight="500px"
            ref="dt"
            dataKey="id"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25, 50]"
            currentPageReportTemplate="Menampilkan {first} dari {last} total {totalRecords} Data Kasus"
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
            <!-- <Column field="plg_id" sortable style="width: 25%" header="ID"></Column> -->
            <!-- <Column
                            field="opd_pengampu"
                            sortable
                            header="OPD Pengampu"
                            style="width: 20%"
                            @click="showkasus"
                        ></Column> -->
            <Column
              field="nama_pelanggar"
              header="Nama Pelanggar"
              sortable
            ></Column>
            <!-- <Column
                            field="nik_pelanggar"
                            header="NIK Pelanggar"
                            sortable
                        ></Column> -->
            <Column
              field="waktu_kejadian"
              header="Waktu Kejadian"
              sortable
            ></Column>
            <Column field="kota_nama" header="Kabupaten" sortable></Column>
            <Column field="kec_nama" header="Kecamatan" sortable></Column>
            <Column field="kel_nama" header="Desa" sortable></Column>
            <Column
              field="lokasi_kejadian"
              header="Lokasi Kejadian"
              sortable
            ></Column>
            <Column field="judul" header="Judul"></Column>
            <Column
              field="nomor_surat_link"
              header="No Surat"
              sortable
            ></Column>
            <Column field="potensi_pad" header="Potensi PAD" sortable>
              <template #body="slotProps">
                {{ formatRupiah(slotProps.data.potensi_pad) }}
              </template>
            </Column>
            <Column header="Action" style="width: 15%;">
              <template #body="slotProps">
                <Button
                  icon="pi pi-pencil"
                  class="mr-2"
                  severity="info"
                  rounded
                  outlined
                  @click="editForm(slotProps.data)"
                />
                <Dialog
                  v-model:visible="showEditDialog"
                  header="Edit Kasus"
                  :style="{ width: '70rem' }"
                >
                  <div class="flex items-center gap-4 mb-4">
                    <label class="w-24 font-semibold" for="no_surat_link"
                      >Nomor Surat</label
                    >
                    <InputText
                      v-model="editedKasus.nomor_surat_link"
                      class="flex-auto"
                      autocomplete="off"
                    />
                  </div>
                  <div class="flex items-center gap-4 mb-4">
                    <label class="w-24 font-semibold" for="judul">Judul</label>
                    <InputText
                      v-model="editedKasus.judul"
                      class="flex-auto"
                      autocomplete="off"
                    />
                  </div>
                  <div class="flex items-center gap-4 mb-4">
                    <label class="w-24 font-semibold" for="koordinat"
                      >Koordinat</label
                    >
                    <InputText
                      v-model="editedKasus.koordinat"
                      class="flex-auto"
                      autocomplete="off"
                      disabled
                    />
                  </div>
                  <div class="flex items-center gap-4 mb-8">
                    <MapboxMap
                      style="height: 400px; width: 1200px;"
                      access-token="pk.eyJ1IjoienVocml3aWppYW50byIsImEiOiJja3d3Z3I1bWswM2d4Mm9xMTh5NHJyeGg5In0.icvBOqiaiRT1f9bzjVFiMw"
                      map-style="mapbox://styles/mapbox/dark-v11"
                      :center="mapCenter"
                      :zoom="1"
                    >
                      <MapboxGeolocateControl />
                    </MapboxMap>
                  </div>
                  <div class="flex items-center gap-4 mb-4">
                    <label class="w-24 font-semibold" for="jenis_trantib"
                      >Jenis Trantib</label
                    >
                    <InputText
                      v-model="editedKasus.jenis_trantib"
                      class="flex-auto"
                      autocomplete="off"
                    />
                  </div>
                  <div class="flex justify-end gap-2">
                    <Button
                      type="button"
                      label="Batal"
                      severity="secondary"
                      @click="Batal = false"
                    ></Button>
                    <Button
                      type="button"
                      label="Simpan"
                      @click="showEditDialog = false"
                    ></Button>
                  </div>
                </Dialog>
                <Button
                  icon="pi pi-trash"
                  class="mt-2"
                  severity="danger"
                  rounded
                  outlined
                  @click="deleteData(slotProps.data.id)"
                />
              </template>
            </Column>
          </DataTable>
          <Dialog
            v-model:visible="addKasusDialog"
            header="Edit Kasus"
            :style="{ width: '70rem' }"
          >
            <form @submit.prevent="addKasus">
              <div>
                <InputText
                  v-model="addItemKasus.nama_pelanggar"
                  placeholder="Nama Pelanggar"
                />
              </div>
              <div>
                <InputText
                  v-model="addItemKasus.nik_pelanggar"
                  placeholder="NIK"
                />
              </div>
              <Button type="submit" label="Save" />
            </form>
          </Dialog>
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

<style scoped lang="scss"></style>
