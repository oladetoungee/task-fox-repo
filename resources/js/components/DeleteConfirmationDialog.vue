<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Task } from '@/types';
import tasks from '@/routes/tasks';

interface Props {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  task?: Task;
}

const props = defineProps<Props>();
const deleteForm = useForm({});

const handleDelete = () => {
  if (props.task) {
    deleteForm.delete(tasks.delete(props.task).url, {
      onSuccess: () => {
        props.onOpenChange(false);
      },
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
          Are you sure you want to delete "<strong>{{ task?.title }}</strong>"? This action cannot be undone.
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