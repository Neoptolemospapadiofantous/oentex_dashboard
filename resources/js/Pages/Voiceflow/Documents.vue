<template>
  <Head title="Document List" />
  <AuthenticatedLayout>
      <template #header>
          <h2 class="text-xl font-semibold leading-tight text-gray-800">
              Document List
          </h2>
      </template>

      <template #main>
          <div class="py-12">
              <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                      <div class="p-6 bg-white border-b border-gray-200">
                          <form @submit.prevent="fetchDocuments" class="grid gap-4 md:grid-cols-2">
                              <!-- Document Type Filter -->
                              <div>
                                  <label class="block text-gray-700">Document Type:</label>
                                  <select v-model="documentType" class="form-select mt-1 block w-full">
                                      <option value="">All</option>
                                      <option value="url">URL</option>
                                      <option value="pdf">PDF</option>
                                      <option value="text">Text</option>
                                      <option value="docx">DOCX</option>
                                  </select>
                              </div>

                              <!-- Include Tags -->
                              <div>
                                  <label class="block text-gray-700">Include Tags:</label>
                                  <input v-model="includeTags" type="text" class="form-input mt-1 block w-full" placeholder="Comma separated tags">
                              </div>

                              <!-- Exclude Tags -->
                              <div>
                                  <label class="block text-gray-700">Exclude Tags:</label>
                                  <input v-model="excludeTags" type="text" class="form-input mt-1 block w-full" placeholder="Comma separated tags">
                              </div>

                              <!-- Include Non-Tagged and Tagged Options -->
                              <div class="flex items-center space-x-4">
                                  <label>
                                      <input type="checkbox" v-model="includeAllNonTagged" /> Include Non-Tagged
                                  </label>
                                  <label>
                                      <input type="checkbox" v-model="includeAllTagged" /> Include All Tagged
                                  </label>
                              </div>

                              <!-- Search Button -->
                              <div class="md:col-span-2">
                                  <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                      Filter Documents
                                  </button>
                              </div>
                          </form>

                          <hr class="my-6" />

                          <!-- Document List -->
                          <ul>
                              <li v-for="doc in documents.data" :key="doc.documentID" class="border-b py-2">
                                  <strong>{{ doc.data.name }}</strong><br>
                                  <span>Type: {{ doc.data.type }}</span><br>
                                  <span>Status: {{ doc.status.type }}</span><br>
                                  <span>Updated At: {{ new Date(doc.updatedAt).toLocaleString() }}</span>
                              </li>
                          </ul>
                          <p v-if="documents.total === 0" class="mt-4">No documents found.</p>

                          <!-- Pagination -->
                          <div v-if="documents.total > 0" class="mt-6 flex justify-center space-x-2">
                              <button @click="changePage(page.value - 1)" :disabled="page.value <= 1" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">
                                  Previous
                              </button>
                              <button @click="changePage(page.value + 1)" :disabled="page.value * limit >= documents.total" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">
                                  Next
                              </button>
                          </div>

                          <!-- Upload Document Section -->
                          <div class="mt-6">
                              <h3 class="text-lg font-semibold">Upload Document</h3>
                              <form @submit.prevent="uploadDocument">
                                  <input type="file" @change="onFileChange" class="form-input mt-1 block w-full" />
                                  <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">
                                      Upload Document
                                  </button>
                              </form>
                              <p v-if="uploadStatus" class="mt-2">{{ uploadStatus }}</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </template>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const documentType = ref('');
const includeTags = ref('');
const excludeTags = ref('');
const includeAllNonTagged = ref(false);
const includeAllTagged = ref(false);
const page = ref(1);
const limit = 10; // Number of documents per page
const documents = reactive({ data: [], total: 0 });
const uploadStatus = ref('');
const selectedFile = ref(null);


const fetchDocuments = async () => {
  const params = {
      documentType: documentType.value,
      includeTags: includeTags.value.split(',').map(tag => tag.trim()),
      excludeTags: excludeTags.value.split(',').map(tag => tag.trim()),
      includeAllNonTagged: includeAllNonTagged.value,
      includeAllTagged: includeAllTagged.value,
      page: page.value,
      limit: limit,
  };

  try {
      const response = await axios.post('/documents/list', params);
      documents.data = response.data.data; // Assuming response has a structure containing 'data'
      documents.total = response.data.total; // Assuming response contains 'total' for pagination
  } catch (error) {
      console.error("Error fetching documents:", error);
  }
};

const onFileChange = (event) => {
    selectedFile.value = event.target.files[0]; // Get the first selected file
};

const uploadDocument = async () => {
    const formData = new FormData();

    if (!selectedFile.value) {
        uploadStatus.value = 'Please select a file to upload.';
        return;
    }

    formData.append('file', selectedFile.value); // Append the file to formData

    try {
        const response = await axios.post('/documents/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        uploadStatus.value = 'Document uploaded successfully!';
        fetchDocuments(); // Refresh the documents list after upload
    } catch (error) {
        console.error("Error uploading document:", error);
        uploadStatus.value = 'Failed to upload document.';
    }
};

const changePage = (newPage) => {
  if (newPage > 0) {
      page.value = newPage;
      fetchDocuments(); // Fetch documents for the new page
  }
};

// Watch for page changes to fetch new documents
watch(page, fetchDocuments);

// Fetch documents on component mount
onMounted(fetchDocuments);
</script>

<style scoped>
/* Add any additional styles you need */
</style>
