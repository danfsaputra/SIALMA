<script setup>
import { ref } from "vue";
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from "@inertiajs/vue3";
import Button from "primevue/button";

const smoothScroll = (id) => {
    document.querySelector(id).scrollIntoView({
        behavior: "smooth",
    });
};
</script>

<template>
    <Head title="Landing Page" />
    <div class="flex surface-0 justify-content-center">
        <div id="home" class="overflow-hidden landing-wrapper">
            <div
                class="relative flex px-4 py-4 mx-0 mb-3 md:mx-6 lg:mx-8 lg:px-8 align-items-center justify-content-between lg:static"
            >
                <a class="flex align-items-center" href="/"
                    ><span
                        class="mr-8 text-2xl font-medium text-900 line-height-3"
                        >SiAlma</span
                    >
                </a>
                <a
                    class="block cursor-pointer lg:hidden text-700 p-ripple"
                    v-ripple
                    v-styleclass="{
                        selector: '@next',
                        enterClass: 'hidden',
                        leaveToClass: 'hidden',
                        hideOnOutsideClick: true,
                    }"
                >
                    <i class="text-4xl pi pi-bars"></i>
                </a>
                <div
                    class="absolute left-0 hidden w-full px-6 align-items-center surface-0 flex-grow-1 justify-content-between lg:flex lg:static lg:px-0 z-2"
                    style="top: 120px"
                >
                    <ul
                        class="flex p-0 m-0 list-none cursor-pointer select-none lg:align-items-center flex-column lg:flex-row"
                    >
                        <li>
                            <a
                                @click="smoothScroll('#hero')"
                                class="flex px-0 py-3 m-0 font-medium md:ml-5 text-900 line-height-3 p-ripple"
                                v-ripple
                            >
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a
                                @click="smoothScroll('#features')"
                                class="flex px-0 py-3 m-0 font-medium md:ml-5 text-900 line-height-3 p-ripple"
                                v-ripple
                            >
                                <span>Fitur Aplikasi</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a @click="smoothScroll('#highlights')" class="flex px-0 py-3 m-0 font-medium md:ml-5 text-900 line-height-3 p-ripple" v-ripple>
                                <span>Peta Rawan Pelanggaran</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a @click="smoothScroll('#pricing')" class="flex px-0 py-3 m-0 font-medium md:ml-5 text-900 line-height-3 p-ripple" v-ripple>
                                <span>Pricing</span>
                            </a>
                        </li> -->
                    </ul>
                    <div
                        class="flex py-3 mt-3 justify-content-between lg:block border-top-1 lg:border-top-none surface-border lg:py-0 lg:mt-0"
                    >
                        <!-- <Button label="Register" class="ml-5 font-light text-white bg-blue-500 border-none p-button-rounded line-height-2"></Button> -->
                        <Link :href="route('login')">
                            <Button label="Login" icon="pi pi-user"></Button>
                        </Link>
                    </div>
                </div>
            </div>

            <div
                id="hero"
                class="flex px-4 pt-4 overflow-hidden flex-column lg:px-8"
                style="
                    background: linear-gradient(
                            0deg,
                            rgba(255, 255, 255, 0.2),
                            rgba(255, 255, 255, 0.2)
                        ),
                        radial-gradient(
                            77.36% 256.97% at 77.36% 57.52%,
                            rgb(238, 239, 175) 0%,
                            rgb(195, 227, 250) 100%
                        );
                    clip-path: ellipse(150% 87% at 93% 13%);
                "
            >
                <div class="mx-4 mt-0 md:mx-8 md:mt-4">
                    <h1 class="text-6xl font-bold text-gray-900 line-height-2">
                        <span class="block font-light"
                            >Pemerintah Kabupaten Bojonegoro</span
                        > SI ALMA
                    </h1>
                    <p
                        class="text-2xl font-normal text-gray-700 line-height-3 md:mt-3"
                    >
                        SISTEM INFORMASI ALIH MEDIA ARSIP
                    </p>
                    <div class="flex justify-content-center md:justify-content-end">
                    <img
                        src="/front/images/landing/landing-1.png"
                        alt="Hero Image"
                        class="w-10 mb:w-auto md:w-auto"
                    />
                </div>
                    <Button
                        label="Get Started"
                        class="px-3 mt-5 text-xl font-normal text-white bg-blue-500 border-none p-button-rounded line-height-3"
                        raised
                    ></Button>
                </div>
            </div>

            <div id="features" class="px-4 py-4 mx-0 mt-5 lg:px-8 lg:mx-8">
                <div class="grid justify-content-center">
                    <div class="mt-8 mb-4 text-center col-12">
                        <h2 class="mb-2 font-normal text-900">
                            Fitur Aplikasi
                        </h2>
                        <!-- <span class="text-2xl text-600">Placerat in egestas erat...</span> -->
                    </div>

                    <div
                        class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg:pr-5 lg:pb-5 lg:mt-0"
                    >
                        <div
                            style="
                                height: 160px;
                                padding: 2px;
                                border-radius: 10px;
                                background: linear-gradient(
                                        90deg,
                                        rgba(253, 228, 165, 0.2),
                                        rgba(187, 199, 205, 0.2)
                                    ),
                                    linear-gradient(
                                        180deg,
                                        rgba(253, 228, 165, 0.2),
                                        rgba(187, 199, 205, 0.2)
                                    );
                            "
                        >
                            <div
                                class="h-full p-3 surface-card"
                                style="border-radius: 8px"
                            >
                                <div
                                    class="flex mb-3 bg-yellow-200 align-items-center justify-content-center"
                                    style="
                                        width: 3.5rem;
                                        height: 3.5rem;
                                        border-radius: 10px;
                                    "
                                >
                                    <i
                                        class="text-2xl text-yellow-700 pi pi-fw pi-eye"
                                    ></i>
                                </div>
                                <h5 class="mb-2 text-900">Peraturan Tentang Kearsipan</h5>
                                <span class="text-600"
                                    >Peraturan Tentang Kearsipan Kabupaten Bojonegoro</span
                                >
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg:pr-5 lg:pb-5 lg:mt-0"
                    >
                        <div
                            style="
                                height: 160px;
                                padding: 2px;
                                border-radius: 10px;
                                background: linear-gradient(
                                        90deg,
                                        rgba(145, 226, 237, 0.2),
                                        rgba(251, 199, 145, 0.2)
                                    ),
                                    linear-gradient(
                                        180deg,
                                        rgba(253, 228, 165, 0.2),
                                        rgba(172, 180, 223, 0.2)
                                    );
                            "
                        >
                            <div
                                class="h-full p-3 surface-card"
                                style="border-radius: 8px"
                            >
                                <div
                                    class="flex mb-3 align-items-center justify-content-center bg-cyan-200"
                                    style="
                                        width: 3.5rem;
                                        height: 3.5rem;
                                        border-radius: 10px;
                                    "
                                >
                                    <i
                                        class="text-2xl pi pi-fw pi-eye text-cyan-700"
                                    ></i>
                                </div>
                                <h5 class="mb-2 text-900">Data Arsip</h5>
                                <span class="text-600">Data Arsip Yang di ALihmediakan</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg:pb-5 lg:mt-0"
                    >
                        <div
                            style="
                                height: 160px;
                                padding: 2px;
                                border-radius: 10px;
                                background: linear-gradient(
                                        90deg,
                                        rgba(145, 226, 237, 0.2),
                                        rgba(172, 180, 223, 0.2)
                                    ),
                                    linear-gradient(
                                        180deg,
                                        rgba(172, 180, 223, 0.2),
                                        rgba(246, 158, 188, 0.2)
                                    );
                            "
                        >
                            <div
                                class="h-full p-3 surface-card"
                                style="border-radius: 8px"
                            >
                                <div
                                    class="flex bg-indigo-200 align-items-center justify-content-center"
                                    style="
                                        width: 3.5rem;
                                        height: 3.5rem;
                                        border-radius: 10px;
                                    "
                                >
                                    <i
                                        class="text-2xl text-indigo-700 pi pi-fw pi-map"
                                    ></i>
                                </div>
                                <h5 class="mb-2 text-900">
                                    Validasi Arsip
                                </h5>
                                <span class="text-600"
                                    >Validasi Arsip Yang di Alih Mediakan</span
                                >
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg:pr-5 lg:pb-5 lg:mt-0"
                    >
                        <div
                            style="
                                height: 160px;
                                padding: 2px;
                                border-radius: 10px;
                                background: linear-gradient(
                                        90deg,
                                        rgba(187, 199, 205, 0.2),
                                        rgba(251, 199, 145, 0.2)
                                    ),
                                    linear-gradient(
                                        180deg,
                                        rgba(253, 228, 165, 0.2),
                                        rgba(145, 210, 204, 0.2)
                                    );
                            "
                        >
                            <div
                                class="h-full p-3 surface-card"
                                style="border-radius: 8px"
                            >
                                <div
                                    class="flex mb-3 align-items-center justify-content-center bg-bluegray-200"
                                    style="
                                        width: 3.5rem;
                                        height: 3.5rem;
                                        border-radius: 10px;
                                    "
                                >
                                    <i
                                        class="text-2xl text-orange-700 pi pi-fw pi-users"
                                    ></i>
                                </div>
                                <h5 class="mb-2 text-900">
                                    Data Petugas Alih Media
                                </h5>
                                <span class="text-600">Petugas Alih Media</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg:pr-5 lg:pb-5 lg:mt-0"
                    >
                        <div
                            style="
                                height: 160px;
                                padding: 2px;
                                border-radius: 10px;
                                background: linear-gradient(
                                        90deg,
                                        rgba(187, 199, 205, 0.2),
                                        rgba(246, 158, 188, 0.2)
                                    ),
                                    linear-gradient(
                                        180deg,
                                        rgba(145, 226, 237, 0.2),
                                        rgba(160, 210, 250, 0.2)
                                    );
                            "
                        >
                            <div
                                class="h-full p-3 surface-card"
                                style="border-radius: 8px"
                            >
                                <div
                                    class="flex mb-3 bg-orange-200 align-items-center justify-content-center"
                                    style="
                                        width: 3.5rem;
                                        height: 3.5rem;
                                        border-radius: 10px;
                                    "
                                >
                                    <i
                                        class="text-2xl text-orange-700 pi pi-fw pi-users"
                                    ></i>
                                </div>
                                <h5 class="mb-2 text-900">Data Arsiparis</h5>
                                <span class="text-600">Data Arsiparis</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg:pb-5 lg:mt-0"
                    >
                        <div
                            style="
                                height: 160px;
                                padding: 2px;
                                border-radius: 10px;
                                background: linear-gradient(
                                        90deg,
                                        rgba(251, 199, 145, 0.2),
                                        rgba(246, 158, 188, 0.2)
                                    ),
                                    linear-gradient(
                                        180deg,
                                        rgba(172, 180, 223, 0.2),
                                        rgba(212, 162, 221, 0.2)
                                    );
                            "
                        >
                            <div
                                class="h-full p-3 surface-card"
                                style="border-radius: 8px"
                            >
                                <div
                                    class="flex mb-3 bg-pink-200 align-items-center justify-content-center"
                                    style="
                                        width: 3.5rem;
                                        height: 3.5rem;
                                        border-radius: 10px;
                                    "
                                >
                                    <i
                                        class="text-2xl text-pink-700 pi pi-fw pi-users"
                                    ></i>
                                </div>
                                <h5 class="mb-2 text-900">Klasifikasi Arsip</h5>
                                <span class="text-600">Klasifikasi Arsip</span>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg:pr-5 lg:mt-0">
                        <div
                            style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(145, 210, 204, 0.2), rgba(160, 210, 250, 0.2)), linear-gradient(180deg, rgba(187, 199, 205, 0.2), rgba(145, 210, 204, 0.2))"
                        >
                            <div class="h-full p-3 surface-card" style="border-radius: 8px">
                                <div class="flex mb-3 bg-teal-200 align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem; border-radius: 10px">
                                    <i class="text-2xl text-teal-700 pi pi-fw pi-shopping-cart"></i>
                                </div>
                                <h5 class="mb-2 text-900">Ready to Use</h5>
                                <span class="text-600">Mauris sit amet massa vitae.</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg:pr-5 lg:mt-0">
                        <div
                            style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(145, 210, 204, 0.2), rgba(212, 162, 221, 0.2)), linear-gradient(180deg, rgba(251, 199, 145, 0.2), rgba(160, 210, 250, 0.2))"
                        >
                            <div class="h-full p-3 surface-card" style="border-radius: 8px">
                                <div class="flex mb-3 bg-blue-200 align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem; border-radius: 10px">
                                    <i class="text-2xl text-blue-700 pi pi-fw pi-globe"></i>
                                </div>
                                <h5 class="mb-2 text-900">Modern Practices</h5>
                                <span class="text-600">Elementum nibh tellus molestie nunc non.</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-0 mt-4 col-12 md:col-12 lg:col-4 lg-4 lg:mt-0">
                        <div
                            style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(160, 210, 250, 0.2), rgba(212, 162, 221, 0.2)), linear-gradient(180deg, rgba(246, 158, 188, 0.2), rgba(212, 162, 221, 0.2))"
                        >
                            <div class="h-full p-3 surface-card" style="border-radius: 8px">
                                <div class="flex mb-3 bg-purple-200 align-items-center justify-content-center" style="width: 3.5rem; height: 3.5rem; border-radius: 10px">
                                    <i class="text-2xl text-purple-700 pi pi-fw pi-eye"></i>
                                </div>
                                <h5 class="mb-2 text-900">Privacy</h5>
                                <span class="text-600">Neque egestas congue quisque.</span>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div
                        class="p-2 mt-8 mb-8 col-12 md:p-8"
                        style="border-radius: 20px; background: linear-gradient(0deg, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6)), radial-gradient(77.36% 256.97% at 77.36% 57.52%, #efe1af 0%, #c3dcfa 100%)"
                    >
                        <div class="flex px-3 py-3 text-center flex-column justify-content-center align-items-center md:py-0">
                            <h3 class="mb-2 text-gray-900">Joséphine Miller</h3>
                            <span class="text-2xl text-gray-600">Peak Interactive</span>
                            <p class="mt-4 text-2xl text-gray-900 sm:line-height-2 md:line-height-4" style="max-width: 800px">
                                “Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.”
                            </p>
                            <img src="/demo/images/landing/peak-logo.svg" class="mt-4" alt="Company logo" />
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- <div id="highlights" class="px-4 py-4 mx-0 my-6 lg:px-8 lg:mx-8">
                <div class="text-center">
                    <h2 class="mb-2 font-normal text-900">Powerful Everywhere</h2>
                    <span class="text-2xl text-600">Amet consectetur adipiscing elit...</span>
                </div>

                <div class="grid pb-2 mt-8 md:pb-8">
                    <div class="flex p-0 bg-purple-100 justify-content-center col-12 lg:col-6 flex-order-1 lg:flex-order-0" style="border-radius: 8px">
                        <img src="/demo/images/landing/mockup.svg" class="w-11" alt="mockup mobile" />
                    </div>

                    <div class="flex my-auto text-center col-12 lg:col-6 flex-column lg:align-items-end lg:text-right">
                        <div class="flex bg-purple-200 align-items-center justify-content-center align-self-center lg:align-self-end" style="width: 4.2rem; height: 4.2rem; border-radius: 10px">
                            <i class="text-5xl text-purple-700 pi pi-fw pi-mobile"></i>
                        </div>
                        <h2 class="text-4xl font-normal line-height-1 text-900">Congue Quisque Egestas</h2>
                        <span class="ml-0 text-2xl text-700 line-height-3 md:ml-2" style="max-width: 650px"
                            >Lectus arcu bibendum at varius vel pharetra vel turpis nunc. Eget aliquet nibh praesent tristique magna sit amet purus gravida. Sit amet mattis vulputate enim nulla aliquet.</span
                        >
                    </div>
                </div>

                <div class="grid pt-2 my-8 md:pt-8">
                    <div class="flex my-auto text-center col-12 lg:col-6 flex-column lg:text-left lg:align-items-start">
                        <div class="flex bg-yellow-200 align-items-center justify-content-center align-self-center lg:align-self-start" style="width: 4.2rem; height: 4.2rem; border-radius: 10px">
                            <i class="text-5xl text-yellow-700 pi pi-fw pi-desktop"></i>
                        </div>
                        <h2 class="text-4xl font-normal line-height-1 text-900">Celerisque Eu Ultrices</h2>
                        <span class="mr-0 text-2xl text-700 line-height-3 md:mr-2" style="max-width: 650px"
                            >Adipiscing commodo elit at imperdiet dui. Viverra nibh cras pulvinar mattis nunc sed blandit libero. Suspendisse in est ante in. Mauris pharetra et ultrices neque ornare aenean euismod elementum nisi.</span
                        >
                    </div>

                    <div class="flex p-0 bg-yellow-100 justify-content-end flex-order-1 sm:flex-order-2 col-12 lg:col-6" style="border-radius: 8px">
                        <img src="/demo/images/landing/mockup-desktop.svg" class="w-11" alt="mockup" />
                    </div>
                </div>
            </div> -->

            <!-- <div id="pricing" class="px-4 py-4 my-2 lg:px-8 md:my-4">
                <div class="text-center">
                    <h2 class="mb-2 font-normal text-900">Matchless Pricing</h2>
                    <span class="text-2xl text-600">Amet consectetur adipiscing elit...</span>
                </div>

                <div class="grid mt-8 justify-content-between md:mt-0">
                    <div class="p-0 col-12 lg:col-4 md:p-3">
                        <div class="flex p-3 transition-all border-2 cursor-pointer flex-column border-200 pricing-card hover:border-primary transition-duration-300" style="border-radius: 10px">
                            <h3 class="my-5 text-center text-900">Free</h3>
                            <img src="/demo/images/landing/free.svg" class="w-10 h-10 mx-auto" alt="free" />
                            <div class="my-5 text-center">
                                <span class="mr-2 text-5xl font-bold text-900">$0</span>
                                <span class="text-600">per month</span>
                                <Button label="Get Started" class="block mx-auto mt-4 ml-3 font-light text-white bg-blue-500 border-none p-button-rounded line-height-2"></Button>
                            </div>
                            <Divider class="w-full bg-surface-200"></Divider>
                            <ul class="flex p-0 my-5 list-none text-900 flex-column">
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Responsive Layout</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Unlimited Push Messages</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">50 Support Ticket</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Free Shipping</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-0 mt-4 col-12 lg:col-4 md:p-3 md:mt-0">
                        <div class="flex p-3 transition-all border-2 cursor-pointer flex-column border-200 pricing-card hover:border-primary transition-duration-300" style="border-radius: 10px">
                            <h3 class="my-5 text-center text-900">Startup</h3>
                            <img src="/demo/images/landing/startup.svg" class="w-10 h-10 mx-auto" alt="startup" />
                            <div class="my-5 text-center">
                                <span class="mr-2 text-5xl font-bold text-900">$1</span>
                                <span class="text-600">per month</span>
                                <Button label="Try Free" class="block mx-auto mt-4 ml-3 font-light text-white bg-blue-500 border-none p-button-rounded line-height-2"></Button>
                            </div>
                            <Divider class="w-full bg-surface-200"></Divider>
                            <ul class="flex p-0 my-5 list-none text-900 flex-column">
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Responsive Layout</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Unlimited Push Messages</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">50 Support Ticket</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Free Shipping</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-0 mt-4 col-12 lg:col-4 md:p-3 md:mt-0">
                        <div class="flex p-3 transition-all border-2 cursor-pointer flex-column border-200 pricing-card hover:border-primary transition-duration-300" style="border-radius: 10px">
                            <h3 class="my-5 text-center text-900">Enterprise</h3>
                            <img src="/demo/images/landing/enterprise.svg" class="w-10 h-10 mx-auto" alt="enterprise" />
                            <div class="my-5 text-center">
                                <span class="mr-2 text-5xl font-bold text-900">$999</span>
                                <span class="text-600">per month</span>
                                <Button label="Get a Quote" class="block mx-auto mt-4 ml-3 font-light text-white bg-blue-500 border-none p-button-rounded line-height-2"></Button>
                            </div>
                            <Divider class="w-full bg-surface-200"></Divider>
                            <ul class="flex p-0 my-5 list-none text-900 flex-column">
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Responsive Layout</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Unlimited Push Messages</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">50 Support Ticket</span>
                                </li>
                                <li class="py-2">
                                    <i class="mr-2 text-xl pi pi-fw pi-check text-cyan-500"></i>
                                    <span class="text-xl line-height-3">Free Shipping</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="px-4 py-4 mx-0 mt-8 lg:mx-8">
                <div class="grid justify-content-between">
                    <div class="col-12 md:col-2" style="margin-top: -1.5rem">
                        <a
                            @click="smoothScroll('#home')"
                            class="flex flex-wrap mb-3 cursor-pointer align-items-center justify-content-center md:justify-content-start md:mb-0"
                        >
                            <!-- <img :src="logoUrl" alt="footer sections" width="50" height="50" class="mr-2" /> -->
                            <h5 class="text-3xl font-medium text-900">
                                ALIH MEDIA ARSIP
                            </h5>
                        </a>
                    </div>

                    <!-- <div class="col-12 md:col-10 lg:col-7">
                        <div class="grid text-center md:text-left">
                            <div class="col-12 md:col-3">
                                <h4
                                    class="mb-3 text-2xl font-medium line-height-3 text-900"
                                >
                                    Satpol PP
                                </h4>
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Perda</a
                                >
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Data Pelanggaran</a
                                >
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Peta Rawan Pelanggaran<img
                                        src="/front/images/landing/new-badge.svg"
                                        class="ml-2"
                                /></a>
                            </div>

                            <div class="mt-4 col-12 md:col-3 md:mt-0">
                                <h4
                                    class="mb-3 text-2xl font-medium line-height-3 text-900"
                                >
                                    Kelembagaan
                                </h4>
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Petugas Penjaga</a
                                >
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Data Satlinmas</a
                                >
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Data Pos Jaga</a
                                >
                            </div>

                            <div class="mt-4 col-12 md:col-3 md:mt-0">
                                <h4
                                    class="mb-3 text-2xl font-medium line-height-3 text-900"
                                >
                                    Trantibum
                                </h4>
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Ketentraman</a
                                >
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Ketertiban Umum</a
                                >
                            </div>

                            <div class="mt-4 col-12 md:col-3 md:mt-0">
                                <h4
                                    class="mb-3 text-2xl font-medium line-height-3 text-900"
                                >
                                    Tentang
                                </h4>
                                <a
                                    class="block mb-2 text-xl cursor-pointer line-height-3 text-700"
                                    >Pemkab Bojonegoro</a
                                >
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- <AppConfig simple /> -->
</template>

<style scoped>
#hero {
    background: linear-gradient(0deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.2)), radial-gradient(77.36% 256.97% at 77.36% 57.52%, #eeefaf 0%, #c3e3fa 100%);
    height: 700px;
    overflow: hidden;
}

@media screen and (min-width: 768px) {
    #hero {
        -webkit-clip-path: ellipse(150% 87% at 93% 13%);
        clip-path: ellipse(150% 87% at 93% 13%);
        height: 530px;
    }
}

@media screen and (min-width: 1300px) {
    #hero > img {
        position: absolute;
    }

    #hero > div > p {
        max-width: 450px;
    }
}

@media screen and (max-width: 1300px) {
    #hero {
        height: 600px;
    }

    #hero > img {
        position: static;
        transform: scale(1);
        margin-left: auto;
    }

    #hero > div {
        width: 100%;
    }

    #hero > div > p {
        width: 100%;
        max-width: 100%;
    }
}
</style>
