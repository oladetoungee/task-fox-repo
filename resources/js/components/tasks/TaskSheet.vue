<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle } from '@/components/ui/sheet';
import { DatePicker } from '@/components/ui/date-picker';
import { useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import { Task, Category } from '@/types';
import CategorySelector from '@/components/categories/CategorySelector.vue';
import axios from 'axios';

const props = defineProps<{
    isOpen: boolean;
    task?: Task | null;
    mode: 'create' | 'edit' | 'view';
}>();

const emit = defineEmits<{
    'update:is-open': [value: boolean];
    'task-updated': [task: Task];
    'task-created': [task: Task];
}>();


const availableCategories = ref<Category[]>([]);
const selectedCategories = ref<Category[]>([]);


const form = useForm({
    title: '',
    description: '',
    due_date: null as Date | null,
    categories: [] as number[],
    status: 'incomplete' as 'incomplete' | 'complete'
});

const fetchCategories = async () => {
    try {
        const { data } = await axios.get('/api/categories');
    
        availableCategories.value = data;
    } catch (error) {
        console.error('Failed to fetch categories:', error);
    }
};
fetchCategories();

watch(() => props.task, (task) => {
    if (task) {
        form.title = task.title;
        form.description = task.description || '';
        form.due_date = task.due_date ? new Date(task.due_date) : null;
        form.categories = task.categories ? task.categories.map(cat => cat.id) : [];
        selectedCategories.value = task.categories || [];
        form.status = task.status;
    } else {
        form.reset();
        selectedCategories.value = [];
        form.status = 'incomplete';
    }
}, { immediate: true });

const sheetTitle = computed(() => {
    switch (props.mode) {
        case 'create': return 'Create Task';
        case 'edit': return 'Edit Task';
        case 'view': return 'Task Details';
        default: return 'Task';
    }
});

const sheetDescription = computed(() => {
    switch (props.mode) {
        case 'create': return 'Add a new task to your list.';
        case 'edit': return 'Update the details of this task.';
        case 'view': return 'View the details of this task.';
        default: return '';
    }
});

const handleCategoryUpdate = (categories: Category[]) => {
    form.categories = categories.map(cat => cat.id);
};

const submitForm = () => {
    const formData = {
        ...form.data(),
        due_date: form.due_date ? form.due_date.toISOString() : null,
    };

    if (props.mode === 'edit' && props.task) {
        form.transform(() => formData).put(`/tasks/${props.task.id}`, {
            onSuccess: () => {
                emit('update:is-open', false);
                emit('task-updated', props.task!);
            },
            onError: (errors) => {
                console.error('Form submission failed:', errors);
            }
        });
    } else {
        form.transform(() => formData).post('/tasks', {
            onSuccess: () => {
                emit('update:is-open', false);           
                form.reset();
                form.status = 'incomplete';
                emit('task-created', {} as Task); 
            },
            onError: (errors) => {
                console.error('Form submission failed:', errors);
            }
        });
    }
};

const isDisabled = computed(() => props.mode === 'view');
</script>

<template>
    <Sheet :open="isOpen" @update:open="$emit('update:is-open', $event)">
        <SheetContent class="p-4">
            <SheetHeader>
                <SheetTitle>{{ sheetTitle }}</SheetTitle>
                <SheetDescription>
                    {{ sheetDescription }}
                </SheetDescription>
            </SheetHeader>
            <div class="py-4">
                <form @submit.prevent="submitForm" class="space-y-4 p-4">
                    <div class="space-y-2">
                        <Label for="title">Task Title *</Label>
                        <Input
                            id="title"
                            v-model="form.title"
                            type="text"
                            placeholder="Enter task title"
                            :disabled="isDisabled"
                        />
                        <InputError :message="form.errors.title" />
                    </div>

                    <div class="space-y-2">
                        <Label for="description">Task Description</Label>
                        <Textarea
                            id="description"
                            v-model="form.description"
                            type="text"
                            placeholder="Enter task description"
                            :disabled="isDisabled"
                        />
                        <InputError :message="form.errors.description" />
                    </div>

                    <div class="space-y-2">
                        <Label for="due_date">Due Date</Label>
                        <DatePicker
                            :value="form.due_date"
                            @change="(date) => form.due_date = date"
                            placeholder="Pick a date"
                            :disabled="isDisabled"
                        />
                        <InputError :message="form.errors.due_date" />
                    </div>
                    <div class="space-y-2">
                        <Label class="text-base font-medium">Categories</Label>
                        <CategorySelector
                            :selected-categories="selectedCategories"
                            @update="handleCategoryUpdate"
                            :disabled="isDisabled"
                        />
                        <InputError :message="form.errors.categories" />
                    </div>
                    <div v-if="mode !== 'create'" class="space-y-2">
                        <Label for="status">Status</Label>
                        <Select v-model="form.status" :disabled="isDisabled">
                            <SelectTrigger class="w-full">
                                <SelectValue placeholder="Select status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="incomplete">Incomplete</SelectItem>
                                <SelectItem value="complete">Complete</SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.status" />
                    </div>
                    <div v-if="mode !== 'create' && task" class="space-y-2 border-t pt-4 mt-6">
                        <h3 class="text-sm font-medium">Task Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <Label class="text-xs text-muted-foreground">Task ID</Label>
                                <p class="text-sm font-mono">{{ task.id }}</p>
                            </div>
                            <div>
                                <Label class="text-xs text-muted-foreground">Created</Label>
                                <p class="text-sm">{{ new Date(task.created_at).toLocaleDateString() }}</p>
                            </div>
                            <div>
                                <Label class="text-xs text-muted-foreground">Updated</Label>
                                <p class="text-sm">{{ new Date(task.updated_at).toLocaleDateString() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 mt-4 border-t">
                        <Button 
                            type="button" 
                            variant="outline" 
                            @click="$emit('update:is-open', false)"
                        >
                            {{ mode === 'view' ? 'Close' : 'Cancel' }}
                        </Button>
                        <Button 
                            v-if="mode !== 'view'" 
                            type="submit" 
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Saving...' : (mode === 'create' ? 'Create Task' : 'Update Task') }}
                        </Button>
                    </div>
                </form>
            </div>
        </SheetContent>
    </Sheet>
</template>