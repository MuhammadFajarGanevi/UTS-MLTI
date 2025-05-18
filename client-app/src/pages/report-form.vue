<template>
  <VContainer>
    <h2 class="mb-6 font-weight-bold">
      Laporan Layanan Form
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
We, as contributors and maintainers of the project, are committed to fostering an open and welcoming environment where all participants feel respected, valued, and supported. This Code of Conduct outlines our expectations for participants' behavior as well as the consequences for unacceptable behavior.

🙏 Our Pledge
In the interest of fostering an open and welcoming environment, we as contributors and maintainers pledge to make participation in our project and our community a harassment-free experience for everyone, regardless of age, body size, disability, ethnicity, gender identity and expression, level of experience, education, socio-economic status, nationality, personal appearance, race, religion, or sexual identity and orientation.

⭐ Our Standards
Examples of behavior that contributes to a positive environment for our community include:
Demonstrating empathy and kindness toward other people
Being respectful of differing opinions, viewpoints, and experiences
Giving and gracefully accepting constructive feedback
Accepting responsibility and apologizing to those affected by our mistakes, and learning from the experience
Focusing on what is best not just for us as individuals, but for the overall community
Examples of unacceptable behavior include:
The use of sexualized language or imagery, and sexual attention or advances of any kind
Trolling, insulting or derogatory comments, and personal or political attacks
Public or private harassment
Publishing others' private information, such as a physical or email address, without their explicit permission
Other conduct which could reasonably be considered inappropriate in a professional setting

🛡️ Our Responsibilities
Project maintainers are responsible for clarifying the standards of acceptable behavior and are expected to take appropriate and fair corrective action in response to any instances of unacceptable behavior.
Maintainers have the right and responsibility to remove, edit, or reject comments, commits, code, wiki edits, issues, and other contributions that are not aligned with this Code of Conduct, or to ban temporarily or permanently any contributor for other behaviors that they deem inappropriate, threatening, offensive, or harmful.

🌍 Scope
This Code of Conduct applies both within project spaces and in public spaces when an individual is representing the project or its community. Examples of representing a project or community include using an official project e-mail address, posting via an official social media account, or acting as an appointed representative at an online or offline event. Representation of a project may be further defined and clarified by project maintainers.
🚨 Enforcement
Instances of abusive, harassing, or otherwise unacceptable behavior may be reported by contacting the project team at [muhamadoskhar@gmail.com]. All complaints will be reviewed and investigated promptly and fairly.
All project maintainers are obligated to respect the privacy and security of the reporter of any incident.

⚖️ Enforcement Guidelines
Project maintainers will follow these Community Impact Guidelines in determining the consequences for any action they deem in violation of this Code of Conduct:
    
    1. Correction
    Community Impact: Use of inappropriate language or other behavior deemed unprofessional or unwelcome in the community.
    Consequence: A private, written warning from project maintainers, providing clarity around the nature of the violation and an explanation of why the behavior was inappropriate. A public apology may be requested.
    2. Warning
    Community Impact: A violation through a single incident or series of actions.
    Consequence: A warning with consequences for continued behavior. No interaction with the people involved, including unsolicited interaction with those enforcing the Code of Conduct, for a specified period of time. This includes avoiding interactions in community spaces as well as external channels like social media. Violating these terms may lead to a temporary or permanent ban.
    3. Temporary Ban
    Community Impact: A serious violation of community standards, including sustained inappropriate behavior.
    Consequence: A temporary ban from any sort of interaction or public communication with the community for a specified period of time. No public or private interaction with the people involved, including unsolicited interaction with those enforcing the Code of Conduct, is allowed during this period. Violating these terms may lead to a permanent ban.
    4. Permanent Ban
    Community Impact: Demonstrating a pattern of violation of community standards, including sustained inappropriate behavior, harassment of an individual, or aggression toward or disparagement of classes of individuals. Consequence: A permanent ban from any sort of public interaction within the community.

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

    router.push('/report')
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
