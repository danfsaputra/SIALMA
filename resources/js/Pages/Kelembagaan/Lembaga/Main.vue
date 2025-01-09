<script setup>
import AppLayout from "@/primevue/layout/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios";
import Breadcrumb from "primevue/breadcrumb";
import Divider from "primevue/divider";
import Tag from 'primevue/tag';

const lembaga = ref([]);

const fetchData = () => {
    axios
        .get(`/api/lembaga`)
        .then((response) => {
            lembaga.value = response.data.data;

            // console.log(response.data.data);
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
        });
};

onMounted(() => {
    fetchData();

    // console.log(totalItems.value)
});

function formatRupiah(value) {
    // console.log(value);
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};

</script>

<template>
    <app-layout>
        <div class="card">
            <p class="m-0" v-for="lembaga in lembaga" :key="lembaga.id">
                {{ lembaga.nama_kepala_satuan }} <Tag value="Kepala Satuan Polisi Pamong Praja"></Tag>
            </p>

            <Divider />

            <p class="m-0" v-for="lembaga in lembaga" :key="lembaga.id">
                {{ lembaga.golongan }}
            </p>

            <Divider />

            <p class="m-0" v-for="lembaga in lembaga" :key="lembaga.id">
                {{ lembaga.alamat_kantor }}
            </p>

            <Divider />

            <p class="m-0" v-for="lembaga in lembaga" :key="lembaga.id">
                {{ formatRupiah(lembaga.anggaran) }}
            </p>
        </div>
    </app-layout>
</template>
