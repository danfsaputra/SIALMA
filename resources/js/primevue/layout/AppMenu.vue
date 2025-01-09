<script setup>
import { ref } from "vue";
import AppMenuItem from "./AppMenuItem.vue";

const model = ref([
    {
        label: "Beranda",
        items: [
            {
                label: "Dashboard",
                icon: "pi pi-fw pi-chart-bar",
                to: "/dashboard",
            },
        ],
    },
    {
        label: "Alih Media",
        items: [
            {
                label: "Entry Data Alih Media",
                icon: "pi pi-file-edit",
                to: "/alihmedia",
            },
        ],
    },
    {
        label: "Validasi dan Autentikasi",
        items: [
            {
                label: "Validasi Data Alih Media",
                icon: "pi pi-verified",
                to: "/validasidata",
            },
            {
                label: "Autentikasi Data Alih Media",
                icon: "pi pi-verified",
                to: "/autentikasidata",
            },
        ],
    },
    {
        label: "Master Data",
        items: [
            {
                label: "Klasifikasi Arsip",
                icon: "pi pi-folder",
                to: "/klasifikasi",
            },
            {
                label: "Hak Akses",
                icon: "pi pi-folder",
                to: "/hak",
            },
            {
                label: "Klasifikasi Keamanan",
                icon: "pi pi-folder",
                to: "/skkaad",
            },
            {
                label: "Penyusutan Akhir",
                icon: "pi pi-folder",
                to: "/penyusutan",
            },
            {
                label: "Jenis Arsip",
                icon: "pi pi-folder",
                to: "/jenis",
            },
        ],
    },
    // {
    //     label: "Pengawasan",
    //     items: [
    //         {
    //             label: "Entry Data Pengawasan",
    //             icon: "pi pi-fw pi-verified",
    //             to: "/satlinmas",
    //         },
    //         {
    //             label: "Laporan Pengawasan",
    //             icon: "pi pi-fw pi-verified",
    //             to: "/pegawaikab",
    //         },
    //         // {
    //         //     label: "Profil Lembaga",
    //         //     icon: "pi pi-fw pi-verified",
    //         //     to: "/lembaga",
    //         // },
    //     ],
    // },
    {
        label: "Pengaturan",
        items: [
            {
                 label: "Managemen Akun",
                 icon: "pi pi-fw pi-users",
                 to: "/akun",
            },
            {
                label: "Ganti Password",
                icon: "pi pi-fw pi-user-edit",
                to: "/ganti-password",
            },
        ],
    },
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item
                v-if="!item.separator"
                :item="item"
                :index="i"
            ></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
