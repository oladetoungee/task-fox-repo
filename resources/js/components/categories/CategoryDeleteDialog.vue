<script setup lang="ts">
import { 
    Dialog, 
    DialogContent, 
    DialogDescription, 
    DialogFooter, 
    DialogHeader, 
    DialogTitle 
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import { Category } from '@/types';


const props = defineProps<{
    open: boolean;
    onOpenChange: (open: boolean) => void;
    category?: Category | null;
}>();

const deleteForm = useForm({});
const handleDelete = () => {
    if (props.category) {
        deleteForm.delete(`/categories/${props.category.id}`, {
            onSuccess: () => {
                props.onOpenChange(false);
            }
        });
    }
};
</script>

<template>
    <Dialog :open="open" @update:open="onOpenChange">
        <DialogContent class="space-y-6">
            <DialogHeader class="space-y-3">
                <DialogTitle>Delete Confirmation</DialogTitle>
                <DialogDescription>
                    Are you sure you want to delete the category "<strong>{{ category?.name }}</strong>"? This action cannot be undone.
                </DialogDescription>
            </DialogHeader>
            
            <DialogFooter>
                                <Button variant="outline" @click="onOpenChange(false)">
                    Cancel
                </Button>
                <Button variant="destructive" @click="handleDelete" :disabled="deleteForm.processing">
                    {{ deleteForm.processing ? 'Deleting...' : 'Delete' }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>