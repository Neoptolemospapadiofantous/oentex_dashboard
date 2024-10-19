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
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <form @submit.prevent="fetchDocuments" class="grid gap-4 md:grid-cols-2">
                                <!-- Document Type Filter -->
                                <div>
                                    <label class="block text-gray-700">Document Type:</label>
                                    <select v-model="documentType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
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
                                    <input v-model="includeTags" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Comma separated tags">
                                </div>

                                <!-- Exclude Tags -->
                                <div>
                                    <label class="block text-gray-700">Exclude Tags:</label>
                                    <input v-model="excludeTags" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Comma separated tags">
                                </div>

                                <!-- Include Non-Tagged and Tagged Options -->
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" v-model="includeAllNonTagged" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                                        <span class="ml-2 text-gray-700">Include Non-Tagged</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" v-model="includeAllTagged" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                                        <span class="ml-2 text-gray-700">Include All Tagged</span>
                                    </label>
                                </div>

                                <!-- Search Button -->
                                <div class="md:col-span-2">
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                        Filter Documents
                                    </button>
                                </div>
                            </form>

                            <hr class="my-6 border-gray-300" />

                            <!-- Document List -->
                            <ul>
                                <li v-for="doc in documents.data" :key="doc.documentID" class="border-b py-2">
                                    <strong class="text-gray-800">{{ doc.data.name }}</strong><br>
                                    <span class="text-gray-600">Type: {{ doc.data.type }}</span><br>
                                    <span class="text-gray-600">Status: {{ doc.status.type }}</span><br>
                                    <span class="text-gray-600">Updated At: {{ new Date(doc.updatedAt).toLocaleString() }}</span><br>
                                    <div class="flex space-x-4 mt-2">
                                        <button @click="showReplaceModal(doc.documentID)" class="text-blue-600 hover:underline">Replace</button>
                                        <button @click="openDeleteModal(doc.documentID)" class="text-red-600 hover:underline">Delete</button>
                                        <button @click="getDocumentChunk(doc.documentID)" class="text-green-600 hover:underline">Get Chunk</button>
                                    </div>
                                </li>
                            </ul>
                            <p v-if="documents.total === 0" class="mt-4 text-gray-600">No documents found.</p>

                            <!-- Pagination -->
                            <div v-if="documents.total > 0" class="mt-6 flex justify-center space-x-2">
                                <button @click="changePage(page.value - 1)" :disabled="page.value <= 1" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg disabled:opacity-50">
                                    Previous
                                </button>
                                <button @click="changePage(page.value + 1)" :disabled="page.value * limit >= documents.total" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg disabled:opacity-50">
                                    Next
                                </button>
                            </div>

                            <!-- Upload Document Section -->
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold">Upload Document</h3>
                                <form @submit.prevent="uploadDocument">
                                    <input type="file" @change="onFileChange" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" />
                                    <button type="submit" class="mt-2 w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">
                                        Upload Document
                                    </button>
                                    <p v-if="uploadStatus" class="mt-2 text-gray-700">{{ uploadStatus }}</p>
                                </form>
                            </div>

                            <!-- Replace Document Modal -->
                            <div v-if="showReplaceModalFlag" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white rounded-lg p-6 shadow-lg w-96 relative">
                                    <button 
                                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-xl" 
                                        @click="showReplaceModalFlag = false"
                                        aria-label="Close modal"
                                    >
                                        &times;
                                    </button>
                                    
                                    <h2 class="text-lg font-semibold">Replace Document</h2>
                                    <input 
                                        type="file" 
                                        @change="onReplaceFileChange" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                                    />
                                    <button 
                                        @click="replaceDocument(selectedDocumentID)" 
                                        class="mt-4 w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-md"
                                    >
                                        Replace Document
                                    </button>
                                </div>
                            </div>

                            <!-- Delete Document Modal -->
                            <div v-if="showDeleteModalFlag" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white rounded-lg p-6 shadow-lg w-96 relative">
                                    <button 
                                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-xl" 
                                        @click="showDeleteModalFlag = false"
                                        aria-label="Close modal"
                                    >
                                        &times;
                                    </button>
                                    
                                    <h2 class="text-lg font-semibold">Delete Document</h2>
                                    <p class="mt-2">Are you sure you want to delete this document? This action cannot be undone.</p>
                                    <div class="flex justify-end mt-4 space-x-2">
                                        <button @click="showDeleteModalFlag = false" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-md">
                                            Cancel
                                        </button>
                                        <button 
                                            @click="confirmDelete(selectedDocumentID)" 
                                            class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
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
const selectedReplaceFile = ref(null);
const selectedDocumentID = ref(null);
const showReplaceModalFlag = ref(false);
const showDeleteModalFlag = ref(false);

// Fetch documents based on filters and pagination
const fetchDocuments = async () => {
    const params = {
        documentType: documentType.value,
        includeTags: includeTags.value.split(',').map(tag => tag.trim()).filter(tag => tag),
        excludeTags: excludeTags.value.split(',').map(tag => tag.trim()).filter(tag => tag),
        includeAllNonTagged: includeAllNonTagged.value,
        includeAllTagged: includeAllTagged.value,
        page: page.value,
        limit: limit,
    };

    try {
        const response = await axios.post('/documents/list', params);
        documents.data = response.data.data;
        documents.total = response.data.total;
    } catch (error) {
        console.error("Error fetching documents:", error);
        alert('Failed to fetch documents. Please try again.');
    }
};

// Handle file selection for upload
const onFileChange = (event) => {
    selectedFile.value = event.target.files[0]; // Get the first selected file
};

// Upload document
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
        uploadStatus.value = 'Failed to upload document. Please try again.';
    }
};

// Change pagination page
const changePage = (newPage) => {
    if (newPage > 0) {
        page.value = newPage;
    }
};

// Open Delete Modal Function
const openDeleteModal = (documentID) => {
    selectedDocumentID.value = documentID; // Store the document ID for deletion
    showDeleteModalFlag.value = true; // Show the delete modal
};

// Confirm Delete Function
const confirmDelete = async (documentID) => {
    try {
        await axios.delete(`/api/documents/${documentID}`);
        showDeleteModalFlag.value = false; // Hide the modal after deletion
        fetchDocuments(); // Refresh the document list
    } catch (error) {
        console.error('Error deleting document:', error);
        // Handle the error (e.g., display a notification)
    }
};

const getDocumentChunk = async (documentID) => {
    try {
        // Fetch the document chunk from the API
        const response = await axios.get(`/documents/chunk/${documentID}`);
        
        // Ensure response data exists before formatting
        if (!response.data) {
            throw new Error("No data returned from the server.");
        }

        // Convert the response data to a human-readable book-like format
        let formattedData = '';

        // Iterate over the keys of the response data object
        for (const [key, value] of Object.entries(response.data)) {
            // Format each key-value pair in a book-like way
            formattedData += `${key.toUpperCase()}\n`; // Key in uppercase for emphasis
            formattedData += `-------------------------------------\n`; // Underline
            
            // Format the value appropriately
            formattedData += formatValue(value);
            formattedData += `\n`; // Add extra line break for spacing
        }

        // Create a Blob from the formatted string
        const blob = new Blob([formattedData], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);

        // Create a link element for downloading the Blob
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `document_chunk_${documentID}.txt`); // Set download filename

        // Append the link to the body
        document.body.appendChild(link);
        link.click(); // Trigger the download
        link.remove(); // Remove the link from the DOM

        // Release the Blob URL to free up memory
        URL.revokeObjectURL(url);
    } catch (error) {
        console.error("Error fetching document chunk:", error);
        alert('Failed to fetch document chunk. Please try again.');
    }
};

// Function to format values in a readable way without braces
const formatValue = (value) => {
    if (Array.isArray(value)) {
        // Handle arrays by formatting each element
        return value.map((item, index) => `${index}: ${formatValue(item)}`).join('\n');
    } else if (typeof value === 'object' && value !== null) {
        // Handle objects by formatting each key-value pair
        return formatObject(value);
    } else {
        // Handle other types (strings, numbers, booleans)
        return `${value}`; // Convert value to string
    }
};

// Function to format objects in a more readable way without braces
const formatObject = (obj) => {
    let result = '';
    for (const [key, value] of Object.entries(obj)) {
        result += `${key}: ${formatValue(value)}\n`; // Format key-value pair
    }
    return result;
};



// Show replace modal
const showReplaceModal = (documentID) => {
    selectedDocumentID.value = documentID;
    showReplaceModalFlag.value = true; // Show the modal for replacing
};

// Handle file selection for replacement
const onReplaceFileChange = (event) => {
    selectedReplaceFile.value = event.target.files[0]; // Get the first selected file for replacement
};

// Replace document
const replaceDocument = async (documentID) => {
    const formData = new FormData();
    formData.append('file', selectedReplaceFile.value); // Append the file for replacement

    try {
        await axios.post(`/documents/replace/${documentID}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        uploadStatus.value = 'Document replaced successfully!';
        fetchDocuments(); // Refresh the documents list after replacing
        showReplaceModalFlag.value = false; // Close the modal
    } catch (error) {
        console.error("Error replacing document:", error);
        uploadStatus.value = 'Failed to replace document. Please try again.';
    }
};

// Watch for page changes to fetch new documents
watch(page, fetchDocuments);

// Fetch documents on component mount
onMounted(fetchDocuments);
</script>
