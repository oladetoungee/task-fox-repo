<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { PenLine, OctagonAlert, FlipVerticalIcon, CheckCircle } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Task } from '@/types';
import * as taskRoutes from '@/routes/tasks';
import TasksTable from '@/components/tasks/TasksTable.vue';
import { getGreeting } from '@/lib/utils';
import DeleteConfirmationDialog from '@/components/DeleteConfirmationDialog.vue';
import TaskSheet from '@/components/tasks/TaskSheet.vue';

const props = defineProps<{ tasks: Task[] }>();

const page = usePage();
const user = page.props.auth.user;

const isTaskSheetOpen = ref(false);
const currentTask = ref<Task | null>(null);
const sheetMode = ref<'create' | 'edit' | 'view'>('create');

const isDeleteDialogOpen = ref(false);
const taskToDelete = ref<Task | null>(null);

const openDeleteModal = (task: Task) => {
  taskToDelete.value = task;
  isDeleteDialogOpen.value = true;
};
const openTaskSheet = (task: Task | null, mode: 'create' | 'edit' | 'view') => {
  currentTask.value = task;
  sheetMode.value = mode;
  isTaskSheetOpen.value = true;
};

const createNewTask = () => {
  currentTask.value = null;
  sheetMode.value = 'create';
  isTaskSheetOpen.value = true;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: taskRoutes.index().url,
    },
];

const dueToday = computed(() => {
    const today = new Date().toDateString();
    return props.tasks.filter(task => {
        if (!task.due_date) return false;
        return new Date(task.due_date).toDateString() === today;
    }).length;
});

const pendingTasks = computed(() => {
    return props.tasks.filter(task => task.status === 'incomplete').length;
});

const completedTasks = computed(() => {
    return props.tasks.filter(task => task.status === 'complete').length;
});


const handleTaskCreated = () => {
  window.location.reload();
};

const handleTaskUpdated = () => {
  window.location.reload();
};
</script>

<template>
    <Head title="Tasks" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">
            <div class="mb-6">
                <h1 class="text-xl font-semibold">{{ getGreeting() }}, {{ user.name }}</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="flex flex-col p-4 bg-border rounded-lg border border-transparent hover:border-dashed hover:border-muted-foreground hover:animate-pulse transition-all duration-300 cursor-pointer">
                    <OctagonAlert class="h-5 w-5 text-orange-500 mb-6" />
                    <p class="text-xs text-muted-foreground">Due Tasks Today</p>
                    <p class="text-2xl font-bold">{{ dueToday }}</p>
                </div>

                <div class="flex flex-col p-4 bg-border rounded-lg border border-transparent hover:border-dashed hover:border-muted-foreground hover:animate-pulse transition-all duration-300 cursor-pointer">
                    <FlipVerticalIcon class="h-5 w-5 text-orange-500 mb-6" />
                    <p class="text-xs text-muted-foreground">Pending Tasks</p>
                    <p class="text-2xl font-bold">{{ pendingTasks }}</p>
                </div>

                <div class="flex flex-col p-4 bg-border rounded-lg border border-transparent hover:border-dashed hover:border-muted-foreground hover:animate-pulse transition-all duration-300 cursor-pointer">
                    <CheckCircle class="h-5 w-5 text-orange-500 mb-6" />
                    <p class="text-xs text-muted-foreground">Completed Tasks</p>
                    <p class="text-xl font-semibold">{{ completedTasks }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-end">
                    <Button @click="createNewTask">
                        <PenLine class="mr-2 h-4 w-4" />
                        New Task
                    </Button>
                </div>
                <TasksTable 
                    :tasks="props.tasks" 
                    :onViewTask="(task) => openTaskSheet(task, 'view')"
                    :onEditTask="(task) => openTaskSheet(task, 'edit')"
                    :onDeleteTask="openDeleteModal"
                />
            </div>
        </div>
        <TaskSheet
            v-model:is-open="isTaskSheetOpen"
            :task="currentTask"
            :mode="sheetMode"
            @task-created="handleTaskCreated"
            @task-updated="handleTaskUpdated"
        />
        <DeleteConfirmationDialog 
            v-if="isDeleteDialogOpen && taskToDelete" 
            :open="isDeleteDialogOpen"
            :onOpenChange="(open) => { if (!open) isDeleteDialogOpen = false }"
            :task="taskToDelete"
        />
    </AppLayout>
</template>
