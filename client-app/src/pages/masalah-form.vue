<template>
  <VContainer>
    <h2 class="mb-6 font-weight-bold">
      Laporan Layanan
    </h2>

    <VForm @submit.prevent="kirimLaporan">
      <!-- Form Input -->
      <div
        class="mb-4"
        style="max-inline-size: 600px;"
      >
        <label class="mb-1 d-block font-weight-medium">Subject</label>
        <VTextField
          v-model="form.subject"
          placeholder="Masukkan judul insiden"
          variant="outlined"
          hide-details
          required
        />
      </div>

      <div
        class="mb-4"
        style="max-inline-size: 600px;"
      >
        <label class="mb-1 d-block font-weight-medium">Deskripsi</label>
        <VTextField
          v-model="form.description"
          placeholder="Masukkan deskripsi kesalahan"
          variant="outlined"
          hide-details
          required
        />
      </div>

      <!-- Kategori -->
      <div
        class="mb-4"
        style="max-inline-size: 600px;"
      >
        <label class="mb-1 d-block font-weight-medium">Kategori Insiden</label>
        <VSelect
          v-model="form.category_id"
          label="Kategori kesalahan"
          :items="[
            { label: 'App Not Responding', value: 1 },
            { label: 'Slow Network', value: 2 },
            { label: 'Password Reset Request', value: 3 },
            { label: 'Data Entry Error', value: 4 },
            { label: 'Feature Request', value: 5 },
          ]"
          item-title="label"
          item-value="value"
          required
        />
      </div>

      <!-- Tanggal -->
      <!--
        <div
        class="mb-4"
        style="max-inline-size: 600px;"
        >
        <label class="mb-1 d-block font-weight-medium">Tanggal</label>
        <VTextField
        v-model="form.tanggal"
        type="date"
        label="Pilih tanggal"
        variant="outlined"
        hide-details
        required
        />
        </div> 
      -->

      <!-- Kode Etik -->
      <div
        class="mb-4"
        style="max-inline-size: 600px;"
      >
        <label class="mb-2 d-block font-weight-medium">Kode Etik</label>
        <label style="color: #666; font-size: 0.9rem; font-weight: 300;">
          Dengan mengirimkan masalah ini, Anda setuju untuk mematuhi Kode Etik proyek.
        </label>
        <VDialog
          v-model="dialogKodeEtik"
          max-width="800"
        >
          <template #activator="{ props }">
            <VCheckbox
              v-bind="props"
              v-model="form.setujuKodeEtik"
              label="Saya setuju untuk mengikuti Kode Etik proyek ini."
              required
            />
          </template>
          <VCard>
            <VCardTitle class="text-h6">
              Kode Etik
            </VCardTitle>
            <VCardText style="max-block-size: 60vh; overflow-y: auto; white-space: pre-line;">
              {{ kodeEtikText }}
            </VCardText>
            <VCardActions>
              <VSpacer />
              <VBtn
                text
                @click="dialogKodeEtik = false"
              >
                Tolak
              </VBtn>
              <VBtn
                color="primary"
                @click="setujuiKodeEtik"
              >
                Setuju
              </VBtn>
            </VCardActions>
          </VCard>
        </VDialog>
      </div>

      <!-- Tombol -->
      <div class="d-flex justify-end mt-6">
        <VBtn
          text
          color="white"
          @click="router.back()"
        >
          Batal
        </VBtn>
        <VBtn
          type="submit"
          color="primary"
        >
          Kirim
        </VBtn>
      </div>
    </VForm>
  </VContainer>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Data form
const form = ref({
  subject: '',
  description: '',
  category_id: [],
  setujuKodeEtik: false,
})

const dialogKodeEtik = ref(false)

const kodeEtikText = `Contributor Covenant Code of Conduct

📝 Introduction
Kami berkomitmen untuk menciptakan lingkungan yang terbuka dan ramah...

... (potong jika terlalu panjang, bisa isi ulang saat dibutuhkan)
`

const setujuiKodeEtik = () => {
  form.value.setujuKodeEtik = true
  dialogKodeEtik.value = false
}

// Fungsi mengirim laporan
const kirimLaporan = async () => {
  try {
    console.log('Cek isi form sebelum dikirim:', form.value)

    const isFormKosong =
      !form.value.subject ||
      !form.value.description ||
      form.value.category_id.length === 0 ||
      !form.value.setujuKodeEtik

    if (isFormKosong) {
      console.warn('Form belum lengkap:', form.value)
      alert('Harap lengkapi semua field wajib sebelum mengirim.')
      
      return
    }

    const dataToSend = {
      subject: form.value.subject,
      description: form.value.description,
      reporter_id: 1,
      resolver_id: null,

      // category_id: Array.isArray(form.value.categories)
      //   ? form.value.categories
      //   : [form.value.categories],
      category_id: [form.value.category_id],
    }

    console.log('Cek isi form sebelum dikirim:', dataToSend)

    const token = localStorage.getItem('token')

    const response = await axios.post('https://www.kuliah-oskhar.my.id/api/v1/incident', dataToSend,
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      },
    )

    console.log('Laporan berhasil dikirim:', response.data)

    // Reset form
    form.value = {
      subject: '',
      description: '',
      category_id: '',
      setujuKodeEtik: false,
    }

    router.push('/masalah')
  } catch (error) {
    console.error('Gagal mengirim laporan:', error)
    alert('Terjadi kesalahan saat mengirim laporan.')
  }
}
</script>

<style scoped>
label {
  display: block;
}
</style>
