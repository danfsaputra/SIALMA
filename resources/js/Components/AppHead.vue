<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import Breadcrumb from "primevue/breadcrumb";

const props = defineProps({
    title: String,
    submenu: String,
});

const home = ref({ icon: "pi pi-home" });
const items = ref([{ label: props.submenu }, { label: props.title }]);
</script>

<template>
    <Head :title="title ? `${title}` : ''">
            <slot />
    </Head>

    <div class="flex mb-3 align-items-center justify-content-between">
        <h3 class="m-0">{{ title }}</h3>
        <Breadcrumb :home="home" :model="items" class="hidden md:block" />
    </div>
</template>
