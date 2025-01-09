<script setup>
import { ref, reactive, inject, watchEffect } from "vue";
import axios from "axios";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";

const convertDate = (date) => {
    const formattedDate = date.getFullYear() + '-' +
                      String(date.getMonth() + 1).padStart(2, '0') + '-' +
                      String(date.getDate()).padStart(2, '0');
    return formattedDate;
}

const props = defineProps({
  isVisible: Boolean,
  items: Object,
});

const Swal = inject("$swal");
const emit = defineEmits(["form-close"]);

const formState = {
  id: "",
  tanggal_kegiatan: "",
  perda: "",
  jenis_pelanggaran: "",
  urusan: "",
  jenis_tertib: "",
  tindak_lanjut: "",
  sanksi: "",
  status_proses: "",
  tanggal_sidang_tipiring: "",
  keterangan: "",
};

const errors = ref({});
const formData = reactive({ ...formState });

const closeForm = () => {
  emit("form-close");
  Object.assign(formData, formState);
};

const jenisPerda = ref([
        {
            name:
            "Peraturan Bupati Bojonegoro Nomor 12 Tahun 2020 tentang Pajak Reklame",
            id: "Peraturan Bupati Bojonegoro Nomor 12 Tahun 2020 tentang Pajak Reklame",
        },
        {
            name:
            "Peraturan Bupati Bojonegoro Nomor 40 Tahun 2020 tentang Pembangunan dan Penataan Menara Telekomunikasi Bersama",
            id:
            "Peraturan Bupati Bojonegoro Nomor 40 Tahun 2020 tentang Pembangunan dan Penataan Menara Telekomunikasi Bersama",
        },
        {
            name:
            "Peraturan Daerah Kabupaten Bojonegoro Nomor 15 Tahun 2015 tentang Penyelenggaraan Ketentraman dan Ketertiban Umum",
            id:
            "Peraturan Daerah Kabupaten Bojonegoro Nomor 15 Tahun 2015 tentang Penyelenggaraan Ketentraman dan Ketertiban Umum",
        },
        {
            name:
            "Peraturan Daerah Kabupaten Bojonegoro Nomor 15 Tahun 2015 tentang Ketentraman dan Ketertiban Umum",
            id:
            "Peraturan Daerah Kabupaten Bojonegoro Nomor 15 Tahun 2015 tentang Ketentraman dan Ketertiban Umum",
        },
        {
            name:
            "Peraturan Daerah Kabupaten Bojonegoro Nomor 1 Tahun 2018 tentang Penyidik Pegawai Negeri Sipil",
            id:
            "Peraturan Daerah Kabupaten Bojonegoro Nomor 1 Tahun 2018 tentang Penyidik Pegawai Negeri Sipil",
        },
]);

const JenisPelanggaran = ref([
        { name: "Reklame", id: "Reklame" },
        { name: "Pedagang Kaki Lima", id: "Pedagang Kaki Lima" },
        {
            name: "Ijin Mendirikan Bangunan dan Gangguan",
            id: "Ijin Mendirikan Bangunan dan Gangguan",
        },
        { name: "Pekerja Seks Komersial", id: "Pekerja Seks Komersial" },
        { name: "Bangunan Liar", id: "Bangunan Liar" },
        { name: "Galian C", id: "Galian C" },
        {
            name: "Penyandang Masalah Kesejahteraan Sosial",
            id: "Penyandang Masalah Kesejahteraan Sosial",
        },
        { name: "Lainnya", id: "Lainnya" },
]);

const jenisTertib = ref([
        { name: "Pengawasan", id: "Pengawasan" },
        { name: "Peran Serta Masyarakat", id: "Peran Serta Masyarakat" },
        ]);

        const jenisUrusan = ref([
        { name: "Pengawasan", id: "Pengawasan" },
        {
            name: "Ketenteraman dan Ketertiban Umum serta Perlindungan Masyarakat",
            id: "Ketenteraman dan Ketertiban Umum serta Perlindungan Masyarakat",
        },
]);

const tindakLanjut = ref([
        { name: "Pembinaan", id: "Pembinaan" },
        { name: "Peringatan", id: "Peringatan" },
        { name: "Pengawasan", id: "Pengawasan" },
        { name: "Lainnya", id: "Lainnya" },
]);

const sanksi = ref([
        { name: "Administrasi", id: "Administrasi" },
        { name: "Pembinaan", id: "Pembinaan" },
        { name: "Denda", id: "Denda" },
        { name: "Lainnya", id: "Lainnya" },
]);

const statusProses = ref([
        { name: "P-21", id: "P-21" },
        { name: "Non Yustisi", id: "Non Yustisi" },
]);

const submitForm = async (data) => {
  try {
    await axios.get("/sanctum/csrf-cookie");

    const body = {...data, tanggal_kegiatan: convertDate(data.tanggal_kegiatan), tanggal_sidang_tipiring: convertDate(data.tanggal_sidang_tipiring)}

    axios
      .post("/api/perda/store", body)
      .then((res) => {
        if (res.data.success == true) {
          emit("form-close");
          Swal("", res.data.message, "success").then(() => {
            Object.assign(formData, formState);
          });
        }
      })
      .catch((err) => {
        if (err.response.status === 422) {
          errors.value = err.response.data.errors;
        }
      });
  } catch (err) {
    console.log(err);
  }
};

watchEffect(() => {
  if (props.items) {
    const tanggal_kegiatan = new Date(props.items.tanggal_kegiatan);
    const tanggal_sidang_tipiring = new Date(props.items.tanggal_sidang_tipiring);


    formData.id = props.items.id;
    formData.tanggal_kegiatan = tanggal_kegiatan.toLocaleDateString('id-ID');
    formData.perda = props.items.perda;
    formData.jenis_pelanggaran = props.items.jenis_pelanggaran;
    formData.urusan = props.items.urusan;
    formData.jenis_tertib = props.items.jenis_tertib;
    formData.tindak_lanjut = props.items.tindak_lanjut;
    formData.sanksi = props.items.sanksi;
    formData.status_proses = props.items.status_proses;
    formData.tanggal_sidang_tipiring = tanggal_sidang_tipiring.toLocaleDateString('id-ID');
    formData.keterangan = props.items.keterangan;
  }

  console.log(props.items)
  console.log(formData)
});



</script>

<template>
  <div>
    <Dialog
      class="w-full md:w-auto"
      :visible="isVisible"
      header="Form Perda"
      @update:visible="closeForm()"
      modal
    >
      <form @submit.prevent="submitForm(formData)">
        <hr class="mt-0 mb-6" />

        <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Tanggal Kegiatan</label>
            <Calendar
              v-model="formData.tanggal_kegiatan"
              dateFormat="dd/mm/yy"
              iconDisplay="input"
              showIcon
              :invalid="errors?.tanggal_kegiatan ? true : false"
            />
            <small v-if="errors?.tanggal_kegiatan">{{
              errors.tanggal_kegiatan[0]
            }}</small>
          </div>

          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Tanggal SDT</label>
            <Calendar
              v-model="formData.tanggal_sidang_tipiring"
              dateFormat="dd/mm/yy"
              iconDisplay="input"
              showIcon
              :invalid="errors?.tanggal_sidang_tipiring ? true : false"
            />
            <small v-if="errors?.tanggal_sidang_tipiring">{{
              errors.tanggal_sidang_tipiring[0]
            }}</small>
          </div>
        </div>

        <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Jenis Pelanggaran</label>
            <Dropdown
              v-model="formData.jenis_pelanggaran"
              :options="JenisPelanggaran"
              optionLabel="name"
              optionValue="id"
              placeholder="Pilih Jenis Pelanggaran"
              :highlightOnSelect="false"
              checkmark
              :invalid="errors?.jenis_pelanggaran ? true : false"
            />
            <small v-if="errors?.jenis_pelanggaran">{{
              errors.jenis_pelanggaran[0]
            }}</small>
          </div>
        </div>

        <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Perda</label>
            <Dropdown
              v-model="formData.perda"
              :options="jenisPerda"
              optionLabel="name"
              optionValue="id"
              placeholder="Pilih Perda"
              :highlightOnSelect="false"
              checkmark
              :invalid="errors?.perda ? true : false"
            />
            <small v-if="errors?.perda">{{ errors.perda[0] }}</small>
          </div>
        </div>

        <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Jenis Ketertiban</label>
            <Dropdown
              v-model="formData.jenis_tertib"
              :options="jenisTertib"
              optionLabel="name"
              optionValue="id"
              placeholder="Pilih Jenis Ketertiban"
              :highlightOnSelect="false"
              checkmark
              :invalid="errors?.jenis_tertib ? true : false"
              class="w-full"
            />
          </div>

          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Urusan</label>
            <Dropdown
              v-model="formData.urusan"
              :options="jenisUrusan"
              optionLabel="name"
              optionValue="id"
              placeholder="Pilih Urusan"
              :highlightOnSelect="false"
              checkmark
              :invalid="errors?.urusan ? true : false"
              class="w-full"
            />
            <small v-if="errors?.urusan">{{ errors.urusan[0] }}</small>
          </div>
        </div>

        <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Tindak Lanjut</label>
            <Dropdown
              v-model="formData.tindak_lanjut"
              :options="tindakLanjut"
              optionLabel="name"
              optionValue="id"
              placeholder="Pilih Tindak Lanjut"
              :highlightOnSelect="false"
              checkmark
              :invalid="errors?.tindak_lanjut ? true : false"
              class="w-full"
            />
            <small v-if="errors?.tindak_lanjut">{{ errors.tindak_lanjut[0] }}</small>
          </div>

          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Sanksi</label>
            <Dropdown
              v-model="formData.sanksi"
              :options="sanksi"
              optionLabel="name"
              optionValue="id"
              placeholder="Pilih Sanksi"
              :highlightOnSelect="false"
              checkmark
              :invalid="errors?.sanksi ? true : false"
              class="w-full"
            />
            <small v-if="errors?.sanksi">{{ errors.sanksi[0] }}</small>
          </div>
        </div>

        <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
          <div class="flex w-full gap-2 flex-column">
            <label class="font-semibold required">Status Proses</label>
            <Dropdown
              v-model="formData.status_proses"
              :options="statusProses"
              optionLabel="name"
              optionValue="name"
              placeholder="Pilih Status Pegawai"
              :highlightOnSelect="false"
              :invalid="errors?.status_proses ? true : false"
            />
            <small v-if="errors?.status_proses">{{
              errors.status_proses[0]
            }}</small>
          </div>
        </div>

        <div class="grid mx-0 mb-5 gap-y-3 gap-x-5">
          <div class="flex gap-2 flex-column grow">
            <label class="font-semibold required">Keterangan</label>
            <Textarea
              v-model="formData.keterangan"
              rows="2"
              :invalid="errors?.keterangan ? true : false"
            />
            <small v-if="errors?.keterangan">{{ errors.keterangan[0] }}</small>
          </div>
        </div>

        <div class="flex justify-end gap-2">
          <Button
            type="button"
            label="Batal"
            severity="secondary"
            outlined
            @click.stop="closeForm()"
          ></Button>
          <Button type="submit" label="Simpan"></Button>
        </div>
      </form>
    </Dialog>
  </div>
  <Toast />
</template>

<style lang="postcss" scoped>
small {
  @apply text-xs font-medium text-red-400;
}
</style>
