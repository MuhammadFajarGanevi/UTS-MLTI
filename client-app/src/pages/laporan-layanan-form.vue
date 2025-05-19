<script setup>
import axios from '@/plugins/axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = ref({
  judul: '',
  deskripsi: '',
  manfaat: '',
  alternatif: '',
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

// Buka dialog saat checkbox diklik
const bukaDialogKodeEtik = () => {
  dialogKodeEtik.value = true
}

// Klik tombol "Setuju" di dialog
const setujuiKodeEtik = () => {
  form.value.setujuKodeEtik = true
  dialogKodeEtik.value = false
}

// Klik tombol "Tolak" di dialog
const tolakKodeEtik = () => {
  form.value.setujuKodeEtik = false
  dialogKodeEtik.value = false
}

// Fungsi kirim laporan
const kirimLaporan = async () => {
  try {
    const getRes = await axios.get('/request-service?length=1000')
    const raw = getRes.data[0]
    const existingData = raw?.data?.data || []
    const maxId = Math.max(...existingData.map(item => item.id || 0))
    const newId = maxId + 1

    const payload = {
      id: newId,
      subject: form.value.judul,
      description: form.value.deskripsi,
      content: form.value.manfaat,
      alternatif: form.value.alternatif,
      category_id: [1], // Ganti sesuai kebutuhan
      timestamp: new Date().toISOString(), // Jika dibutuhkan oleh backend
    }

    const postRes = await axios.post('/request-service', payload)

    console.log('Data berhasil dikirim:', postRes.data)

    router.push('/layanan')
  } catch (err) {
    console.error('Gagal mengirim data:', err)
  }
}
</script>

<template>
  <VContainer>
    <h2 class="mb-6 font-weight-bold">
      Laporan Layanan Form
    </h2>

    <VForm @submit.prevent="kirimLaporan">
      <VRow dense>
        <VCol
          cols="12"
          md="6"
        >
          <div
            class="mb-4"
            style="max-inline-size: 600px;"
          >
            <label class="mb-1 d-block font-weight-medium">Judul</label>
            <VTextField
              v-model="form.judul"
              placeholder="Masukkan judul fitur"
              variant="outlined"
              hide-details
              required
            />
          </div>

          <div
            class="mb-4"
            style="max-inline-size: 600px;"
          >
            <label class="mb-1 d-block font-weight-medium">Deskripsi Fitur</label>
            <VTextarea
              v-model="form.deskripsi"
              placeholder="Jelaskan fitur yang diusulkan"
              variant="outlined"
              rows="3"
              hide-details
              required
            />
          </div>

          <div
            class="mb-4"
            style="max-inline-size: 600px;"
          >
            <label class="mb-1 d-block font-weight-medium">Manfaat</label>
            <VTextarea
              v-model="form.manfaat"
              placeholder="Jelaskan manfaat dari fitur ini"
              variant="outlined"
              rows="3"
              hide-details
              required
            />
          </div>

          <div
            class="mb-4"
            style="max-inline-size: 600px;"
          >
            <label class="mb-1 d-block font-weight-medium">Alternatif yang Dipertimbangkan</label>
            <VTextarea
              v-model="form.alternatif"
              placeholder="Jelaskan alternatif yang telah dipertimbangkan"
              variant="outlined"
              rows="3"
              hide-details
              required
            />
          </div>
        </VCol>


        <VCol cols="12">
          <VCheckbox
            :model-value="form.setujuKodeEtik"
            label="Saya setuju untuk mengikuti Kode Etik proyek ini."
            required
            @click.prevent="bukaDialogKodeEtik"
          />
        </VCol>

        <!-- Dialog Kode Etik -->
        <VDialog
          v-model="dialogKodeEtik"
          max-width="800"
        >
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
                color="error"
                @click="tolakKodeEtik"
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

        <!-- Tombol Aksi -->
        <VCol
          cols="12"
          class="d-flex justify-end mt-6"
        >
          <VBtn
            text
            color="grey"
            @click="router.back()"
          >
            Batal
          </VBtn>
          <VBtn
            type="submit"
            color="primary"
            class="ml-2"
          >
            Kirim
          </VBtn>
        </VCol>
      </VRow>
    </VForm>
  </VContainer>
</template>
