<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Modal from '@/Components/Modal.vue'

const showCreateModal = ref(false)
const showEditModal = ref(false)
const currentTask = ref(null)

// Initialize tasks from props with default empty array
const props = defineProps({
    tasks: {
        type: Array,
        default: () => []
    }
})

// Create form
const form = useForm({
    title: '',
    content: '',
    attachment: null,
    status: 'pending'
})

const createTask = () => {
    form.post('/tasks', {
        preserveScroll: true,
        onSuccess: () => {
            closeModal()
            router.reload()
        }
    })
}

// Edit form
const editForm = useForm({
    title: '',
    content: '',
    attachment: null,
    status: ''
})

const editTask = (task) => {
    // Don't allow editing completed tasks
    if (task.status === 'completed') {
        alert('Completed tasks cannot be edited.')
        return
    }
    
    currentTask.value = task
    editForm.title = task.title || ''
    editForm.content = task.content || ''
    editForm.status = task.status || 'pending'
    editForm.attachment = null
    showEditModal.value = true
}

const updateTask = () => {
    if (!currentTask.value || !currentTask.value.id) {
        console.error('No task selected for update')
        return
    }
    const formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('title', editForm.title);
    formData.append('content', editForm.content);
    formData.append('status', editForm.status);
    if (editForm.attachment) {
        formData.append('attachment', editForm.attachment);
    }
    console.log(editForm, formData);

    router.post(`/tasks/${currentTask.value.id}`, formData, {
        preserveScroll: true,
        onSuccess: () => {  
            showEditModal.value = false;
            currentTask.value = null;
            
            // Reset the form
            editForm.reset();
            
            // Reload the tasks
            router.reload({ only: ['tasks'] });
            
        },
        onError: (errors) => {
            console.error('Update errors:', errors);
        }
    });
}

// Toggle task status
const toggleTaskStatus = (task) => {
    // Only allow marking as completed, not changing back
    if (task.status === 'completed') {
        return
    }
    
    router.post(`/tasks/${task.id}/update-status`, {
        status: 'completed'
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // Update the task status locally for immediate feedback
            task.status = 'completed'
        },
        onError: (errors) => {
            console.error('Status update errors:', errors)
        }
    })
}

const deleteTask = (id) => {
    if (!id) {
        console.error('No task ID provided for deletion')
        return
    }
    
       const formData = new FormData();
    formData.append('_method', 'DELETE');
    if (confirm('Are you sure you want to delete this task?')) {
        router.post(`/tasks/${id}`, formData , {
            preserveScroll: true,
            onError: (errors) => {
                console.error('Delete errors:', errors)
            }
        })
    }
}

const openCreateModal = () => {
    showCreateModal.value = true
}

const closeModal = () => {
    form.reset()
    showCreateModal.value = false
}

const closeEditModal = () => {
    showEditModal.value = false
    currentTask.value = null
    editForm.reset()
}

// Get status badge color
const getStatusColor = (status) => {
    switch(status) {
        case 'completed':
            return 'bg-green-100 text-green-800'
        case 'in_progress':
            return 'bg-blue-100 text-blue-800'
        case 'pending':
        default:
            return 'bg-yellow-100 text-yellow-800'
    }
}

// Get status display text
const getStatusText = (status) => {
    switch(status) {
        case 'completed':
            return 'Completed'
        case 'in_progress':
            return 'In Progress'
        case 'pending':
        default:
            return 'Pending'
    }
}

// Check if task is editable
const isTaskEditable = (task) => {
    return task && task.status !== 'completed'
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header - Made responsive -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900">Tasks</h2>
                <button 
                    @click="openCreateModal"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-center"
                >
                    Add New Task
                </button>
            </div>

            <!-- Tasks List - Made responsive with grid -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div v-if="props.tasks.length === 0" class="text-center py-8">
                        <p class="text-gray-500">No tasks found. Create your first task!</p>
                    </div>
                    
                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="task in props.tasks" :key="task.id" 
                            class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200">
                            <div class="p-4 flex flex-col h-full">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-medium text-gray-900 break-words">{{ task.title }}</h3>
                                    <span :class="['text-xs font-semibold px-2.5 py-0.5 rounded-full ml-2', getStatusColor(task.status)]">
                                        {{ getStatusText(task.status) }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-4 flex-grow break-words">{{ task.content }}</p>
                                
                                <div class="flex flex-wrap gap-2 mt-auto">
                                    <button 
                                        v-if="isTaskEditable(task)"
                                        @click="editTask(task)" 
                                        class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors duration-200"
                                    >
                                        Edit
                                    </button>
                                    
                                    <button 
                                        v-if="task.status !== 'completed'"
                                        @click="toggleTaskStatus(task)" 
                                        class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors duration-200"
                                    >
                                        Mark Complete
                                    </button>
                                    
                                    <button 
                                        @click="deleteTask(task.id)" 
                                        class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors duration-200"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Task Modal - Made responsive -->
            <Modal :show="showCreateModal" @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Create New Task
                    </h2>
                    
                    <div class="mt-6">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input 
                                id="title"
                                v-model="form.title" 
                                type="text" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Task title"
                            >
                            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea 
                                id="content"
                                v-model="form.content" 
                                rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Task details"
                            ></textarea>
                            <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">{{ form.errors.content }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select 
                                id="status"
                                v-model="form.status" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                            <div v-if="form.errors.status" class="text-red-500 text-sm mt-1">{{ form.errors.status }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="attachment" class="block text-sm font-medium text-gray-700">Attachment (optional)</label>
                            <input 
                                id="attachment"
                                type="file" 
                                @input="form.attachment = $event.target.files[0]" 
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            >
                            <div v-if="form.errors.attachment" class="text-red-500 text-sm mt-1">{{ form.errors.attachment }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                        <button 
                            type="button" 
                            class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            @click="closeModal"
                        >
                            Cancel
                        </button>
                        <button 
                            type="button" 
                            class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            @click="createTask"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Creating...' : 'Create Task' }}
                        </button>
                    </div>
                </div>
            </Modal>

            <!-- Edit Task Modal - Made responsive -->
            <Modal :show="showEditModal" @close="closeEditModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Edit Task
                    </h2>
                    
                    <div class="mt-6">
                        <div class="mb-4">
                            <label for="edit-title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input 
                                id="edit-title"
                                v-model="editForm.title" 
                                type="text" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Task title"
                            >
                            <div v-if="editForm.errors.title" class="text-red-500 text-sm mt-1">{{ editForm.errors.title }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="edit-content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea 
                                id="edit-content"
                                v-model="editForm.content" 
                                rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Task details"
                            ></textarea>
                            <div v-if="editForm.errors.content" class="text-red-500 text-sm mt-1">{{ editForm.errors.content }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="edit-status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select 
                                id="edit-status"
                                v-model="editForm.status" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                            <div v-if="editForm.errors.status" class="text-red-500 text-sm mt-1">{{ editForm.errors.status }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="edit-attachment" class="block text-sm font-medium text-gray-700">Attachment (optional)</label>
                            <input 
                                id="edit-attachment"
                                type="file" 
                                @input="editForm.attachment = $event.target.files[0]" 
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            >
                            <div v-if="editForm.errors.attachment" class="text-red-500 text-sm mt-1">{{ editForm.errors.attachment }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                        <button 
                            type="button" 
                            class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            @click="closeEditModal"
                        >
                            Cancel
                        </button>
                        <button 
                            type="button" 
                            class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            @click="updateTask"
                            :disabled="editForm.processing"
                        >
                            {{ editForm.processing ? 'Updating...' : 'Update Task' }}
                        </button>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template> 