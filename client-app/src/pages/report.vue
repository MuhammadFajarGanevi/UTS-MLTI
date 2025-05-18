<template>
  <VContainer>
    <VCard>
      <VCardTitle>
        Laporan Insiden User
        <VSpacer />
        <VBtn
          color="primary"
          @click="showDialog = true"
        >
          Tambah Insiden
        </VBtn>
      </VCardTitle>

      <VTextField
        v-model="search"
        label="Cari insiden..."
        prepend-inner-icon="bx-search"
        class="mx-4 mt-2"
        clearable
      />-

      <VDataTable
        :headers="headers"
        :items="filteredIncidents"
        class="elevation-1"
      >
        <template #item.actions="{ item }">
          <VBtn
            icon
            @click="viewIncident(item)"
          >
            <VIcon>
              bx-pencil
            </VIcon>
          </VBtn>
        </template>
      </VDataTable>
    </VCard>

    <!-- Dialog Tambah / Detail Insiden -->
    <VDialog
      v-model="showDialog"
      max-width="600px"
    >
      <VCard>
        <VCardTitle>{{ selectedIncident ? 'Detail Insiden' : 'Tambah Insiden' }}</VCardTitle>
        <VCardText>
          <VForm @submit.prevent="saveIncident">
            <VTextField
              v-model="form.title"
              label="Judul Insiden"
              required
              :readonly="!!selectedIncident"
            />
            <VTextarea
              v-model="form.description"
              class="mt-4"
              label="Deskripsi"
              rows="3"
              auto-grow
              :readonly="!!selectedIncident"
            />
            <VTextField
              v-model="form.date"
              class="mt-4"
              label="Tanggal Kejadian"
              type="date"
              required
              :readonly="!!selectedIncident"
            />
          </VForm>
        </VCardText>
        <VCardActions>
          <VSpacer />
          <VBtn
            text
            @click="closeDialog"
          >
            Tutup
          </VBtn>
          <VBtn
            v-if="!selectedIncident"
            color="primary"
            @click="saveIncident"
          >
            Simpan
          </VBtn>
        </VCardActions>
      </VCard>
    </VDialog>
  </VContainer>
</template>

<script setup>
import { computed, ref } from 'vue'

const search = ref('')
const showDialog = ref(false)
const selectedIncident = ref(null)

const form = ref({
  title: '',
  description: '',
  date: '',
})

const incidents = ref([
  {
    title: 'Kebakaran Ringan',
    description: 'Kebakaran kecil di gudang B.',
    date: '2025-05-10',
  },
  {
    title: 'Tumpahan Bahan Kimia',
    description: 'Tumpahan di area lab lantai 2.',
    date: '2025-05-09',
  },
])

const headers = [
  { title: 'Judul', key: 'title' },
  { title: 'Tanggal', key: 'date' },
  { title: 'Aksi', key: 'actions', sortable: false },
]

const filteredIncidents = computed(() => {
  return incidents.value.filter(i =>
    i.title.toLowerCase().includes(search.value.toLowerCase()),
  )
})

function saveIncident() {
  if (!form.value.title || !form.value.date) return
  incidents.value.push({ ...form.value })
  resetForm()
  showDialog.value = false
}

function viewIncident(item) {
  selectedIncident.value = item
  form.value = { ...item }
  showDialog.value = true
}

function closeDialog() {
  showDialog.value = false
  resetForm()
}

function resetForm() {
  form.value = { title: '', description: '', date: '' }
  selectedIncident.value = null
}
</script>

<style scoped>
.v-data-table {
  margin-block-start: 16px;
}
</style>
