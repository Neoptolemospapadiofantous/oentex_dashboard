<template>
    <Head title="Document List" />
    <AuthenticatedLayout>
        <template #header>
            <div class="px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600">
                <h1 class="text-2xl font-bold text-white">Manage Your Documents</h1>
            </div>
        </template>

        <template #main>
            <div class="py-10">
                <div class="max-w-5xl mx-auto px-4">
                    
                    <form @submit.prevent="fetchDocuments" class="bg-white p-6 mb-8 shadow-md rounded-md space-y-4 grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Document Type:</label>
                            <select v-model="documentType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                <option value="">All</option>
                                <option value="url">URL</option>
                                <option value="pdf">PDF</option>
                                <option value="text">Text</option>
                                <option value="docx">DOCX</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Include Tags:</label>
                            <input v-model="includeTags" @input="autocompleteTags" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" placeholder="Comma separated tags" aria-autocomplete="list">
                            <!-- Mockup for tag suggestions -->
                            <ul v-if="tagSuggestions.length" class="absolute bg-white border rounded">
                                <li v-for="suggestion in tagSuggestions" :key="suggestion" @click="selectTagSuggestion(suggestion)" class="p-2 cursor-pointer hover:bg-gray-200">{{ suggestion }}</li>
                            </ul>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Exclude Tags:</label>
                            <input v-model="excludeTags" @input="autocompleteTags('exclude')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" placeholder="Comma separated tags" aria-autocomplete="list">
                        </div>

                        <div class="flex items-center space-x-4 md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" v-model="includeAllNonTagged" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                                <span class="ml-2 text-gray-700">Include Non-Tagged</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" v-model="includeAllTagged" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                                <span class="ml-2 text-gray-700">Include All Tagged</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Range:</label>
                            <input type="date" v-model="startDate" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 mb-2" />
                            <input type="date" v-model="endDate" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-md transition">
                                Filter Documents
                            </button>
                        </div>
                    </form>

                    <ul v-if="documents.data && documents.data.length" class="bg-white p-6 rounded-md shadow-md space-y-4">
                        <li v-for="doc in lazyDocuments" :key="doc.documentID" class="border-b last:border-none py-4 flex justify-between items-start">
                            <div class="space-y-1">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <span class="material-icons">description</span> {{ doc.data.name }}
                                </h3>
                                <p class="text-sm text-gray-600">Type: {{ doc.data.type }} | Status: {{ doc.status.type }}</p>
                                <p class="text-xs text-gray-600">Updated At: {{ new Date(doc.updatedAt).toLocaleString() }}</p>
                            </div>
                            <div class="flex space-x-4">
                                <button @click="showReplaceModal(doc.documentID)" class="text-blue-600 hover:underline">Replace</button>
                                <button @click="openDeleteModal(doc.documentID)" class="text-red-600 hover:underline">Delete</button>
                                <button @click="getDocumentChunk(doc.documentID)" class="text-green-600 hover:underline">Get Chunk</button>
                            </div>
                        </li>
                    </ul>

                    <p v-else class="mt-4 text-center text-gray-500">No documents found.</p>

                    <div v-if="isLoading" class="flex justify-center mt-4">
                        <span class="text-gray-600 animate-spin">Loading...</span>
                    </div>

                    <div v-if="documents.total > 0" class="mt-6 flex justify-center space-x-4">
                        <button @click="changePage(page.value - 1)" :disabled="page.value <= 1" class="px-4 py-2 bg-indigo-300 hover:bg-indigo-400 text-white rounded-lg transition disabled:opacity-50">Previous</button>
                        <button @click="changePage(page.value + 1)" :disabled="page.value * limit >= documents.total" class="px-4 py-2 bg-indigo-300 hover:bg-indigo-400 text-white rounded-lg transition disabled:opacity-50">Next</button>
                    </div>

                    <div class="mt-8 bg-white p-6 rounded-md shadow-md">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload Document</h3>
                        <form @submit.prevent="uploadDocument" class="space-y-4">
                            <input type="file" @change="onFileChange" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-md transition">Upload Document</button>
                            <p v-if="uploadStatus" class="text-gray-500">{{ uploadStatus }}</p>
                        </form>
                    </div>

                    <transition name="modal-scale-fade">
                    <!-- Replace Document Modal -->
                    <div v-if="showReplaceModalFlag" class="fixed inset-0 px-4 sm:px-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-md w-full transition-transform transform" role="dialog" aria-modal="true" aria-labelledby="replace-document-title">
                        <div class="relative px-6 py-4">
                        <button class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 transition-colors" @click="showReplaceModalFlag = false" aria-label="Close modal">
                            &times;
                        </button>
                        <h2 id="replace-document-title" class="text-xl font-semibold text-center">Replace Document</h2>
                        <input type="file" @change="onReplaceFileChange" class="mt-4 block w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition" />
                        <button @click="replaceDocument" class="mt-6 w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-transform transform hover:scale-105">Replace Document</button>
                        <p v-if="uploadStatus" class="mt-2 text-gray-500 text-center">{{ uploadStatus }}</p>
                        </div>
                    </div>
                    </div>
                </transition>

                <transition name="modal-scale-fade">
                    <!-- Delete Document Modal -->
                    <div v-if="showDeleteModalFlag" class="fixed inset-0 px-4 sm:px-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-md w-full transition-transform transform" role="dialog" aria-modal="true" aria-labelledby="delete-document-title">
                        <div class="relative px-6 py-4">
                        <button class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 transition-colors" @click="showDeleteModalFlag = false" aria-label="Close modal">
                            &times;
                        </button>
                        <h2 id="delete-document-title" class="text-xl font-semibold text-center">Delete Document</h2>
                        <p class="mt-2 text-center">Are you sure you want to delete this document? This action cannot be undone.</p>
                        <div class="flex justify-center mt-6 space-x-4">
                            <button @click="showDeleteModalFlag = false" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg transition-colors transform hover:scale-105">Cancel</button>
                            <button @click="confirmDelete(selectedDocumentID)" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors transform hover:scale-105">Delete</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </transition>

                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive, onMounted, watch,computed } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// Optionally, install and import a date picker component library
// Optionally, install and import a toast notification library
import { useToast } from 'vue-toastification';
import 'vue-toastification/dist/index.css';

const toast = useToast();

const documentType = ref('');
const includeTags = ref('');
const excludeTags = ref('');
const startDate = ref('');
const endDate = ref('');
const includeAllNonTagged = ref(false);
const includeAllTagged = ref(false);
const page = ref(1);
const limit = 10;
const documents = reactive({ data: [], total: 0 });
const uploadStatus = ref('');
const selectedFile = ref(null);
const selectedReplaceFile = ref(null);
const selectedDocumentID = ref(null);
const showReplaceModalFlag = ref(false);
const showDeleteModalFlag = ref(false);
const tagSuggestions = ref([]);
const isLoading = ref(false);

const fetchDocuments = async () => {
    isLoading.value = true;
    const params = {
        documentType: documentType.value,
        includeTags: includeTags.value.split(',').map(tag => tag.trim()).filter(tag => tag),
        excludeTags: excludeTags.value.split(',').map(tag => tag.trim()).filter(tag => tag),
        includeAllNonTagged: includeAllNonTagged.value,
        includeAllTagged: includeAllTagged.value,
        startDate: startDate.value,
        endDate: endDate.value,
        page: page.value,
        limit: limit,
    };

    try {
        const response = await axios.post('/documents/list', params);
        documents.data = response.data.data;
        documents.total = response.data.total;
        toast.success('Documents fetched successfully!');
    } catch (error) {
        console.error("Error fetching documents:", error);
        toast.error('Failed to fetch documents. Please try again.');
    } finally {
        isLoading.value = false;
    }
};

const onFileChange = (event) => {
    selectedFile.value = event.target.files[0];
};

const uploadDocument = async () => {
    const formData = new FormData();

    if (!selectedFile.value) {
        uploadStatus.value = 'Please select a file to upload.';
        return;
    }

    formData.append('file', selectedFile.value);

    try {
        const response = await axios.post('/documents/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        uploadStatus.value = 'Document uploaded successfully!';
        toast.success('Document uploaded successfully!');
        fetchDocuments();
    } catch (error) {
        console.error("Error uploading document:", error);
        uploadStatus.value = 'Failed to upload document. Please try again.';
        toast.error('Failed to upload document.');
    }
};

const changePage = (newPage) => {
    if (newPage > 0) {
        page.value = newPage;
    }
};

// Mockup of tag autocomplete
const autocompleteTags = (type) => {
    const input = type === 'exclude' ? excludeTags.value : includeTags.value;
    if (input.includes(',')) {
        input.split(',').map(tag => tag.trim()).filter(tag => tag && !tagSuggestions.value.includes(tag)).forEach(tag => tagSuggestions.value.push(tag));
    } else {
        tagSuggestions.value = ['ExampleTag1', 'ExampleTag2'];
    }
};

const selectTagSuggestion = (tag) => {
    if (!includeTags.value.split(',').includes(tag)) {
        includeTags.value += includeTags.value ? `, ${tag}` : tag;
    }
    tagSuggestions.value = [];
};

const openDeleteModal = (documentID) => {
    selectedDocumentID.value = documentID;
    showDeleteModalFlag.value = true;
};

const confirmDelete = async (documentID) => {
    try {
        await axios.delete(`/api/documents/${documentID}`);
        showDeleteModalFlag.value = false;
        fetchDocuments();
        toast.success('Document deleted successfully!');
    } catch (error) {
        console.error('Error deleting document:', error);
        toast.error('Failed to delete document.');
    }
};

const getDocumentChunk = async (documentID) => {
    try {
        const response = await axios.get(`/documents/chunk/${documentID}`);
        if (!response.data) {
            throw new Error("No data returned from the server.");
        }

        let formattedData = '';
        for (const [key, value] of Object.entries(response.data)) {
            formattedData += `${key.toUpperCase()}\n`;
            formattedData += `-------------------------------------\n`;
            formattedData += formatValue(value);
            formattedData += `\n`;
        }

        const blob = new Blob([formattedData], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `document_chunk_${documentID}.txt`);

        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(url);
    } catch (error) {
        console.error("Error fetching document chunk:", error);
        alert('Failed to fetch document chunk. Please try again.');
    }
};

const formatValue = (value) => {
    if (Array.isArray(value)) {
        return value.map((item, index) => `${index}: ${formatValue(item)}`).join('\n');
    } else if (typeof value === 'object' && value !== null) {
        return formatObject(value);
    } else {
        return `${value}`;
    }
};

const formatObject = (obj) => {
    let result = '';
    for (const [key, value] of Object.entries(obj)) {
        result += `${key}: ${formatValue(value)}\n`;
    }
    return result;
};

const showReplaceModal = (documentID) => {
    selectedDocumentID.value = documentID;
    showReplaceModalFlag.value = true;
};

const onReplaceFileChange = (event) => {
    selectedReplaceFile.value = event.target.files[0];
};

const replaceDocument = async () => {
    if (!selectedReplaceFile.value) {
        uploadStatus.value = 'Please select a file to replace.';
        return;
    }

    const formData = new FormData();
    formData.append('file', selectedReplaceFile.value);

    try {
        const response = await axios.post(`/documents/replace/${selectedDocumentID.value}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        uploadStatus.value = 'Document replaced successfully!';
        fetchDocuments();
        showReplaceModalFlag.value = false;
        toast.success('Document replaced successfully!');
    } catch (error) {
        console.error("Error replacing document:", error);
        uploadStatus.value = 'Failed to replace document. Please try again.';
        toast.error('Failed to replace document.');
    }
};

// Lazy load documents by chunks
const lazyDocuments = computed(() => {
    return documents.data.slice(0, page.value * limit);
});

watch(page, fetchDocuments);

onMounted(fetchDocuments);
</script>

<style>
/* Modal transitions */
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.3s ease;
}
.modal-enter, .modal-leave-to {
    opacity: 0;
}

.modal-fade-enter-active, .modal-fade-leave-active {
    transition: opacity 0.5s;
}
.modal-fade-enter, .modal-fade-leave-to {
    opacity: 0;
}
</style>