<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { PenLine } from 'lucide-vue-next';
import { ref } from 'vue';
import CategoryTable from '@/components/categories/CategoryTable.vue';
import CategorySheet from '@/components/categories/CategorySheet.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

defineProps<{
    categories: Array<{
        id: number;
        name: string;
        color: string;
        icon: string;
        created_at: string;
    }>;
}>();

const isSheetOpen = ref(false);

</script>

<template>
    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">Categories</h1>
                    <p class="text-muted-foreground text-sm">Manage your task categories</p>
                </div>
                <Button @click="isSheetOpen = true" class="flex items-center gap-2">
                 <PenLine class="mr-2 h-4 w-4" />
                    New Category
                </Button>
            </div>
            <div v-if="categories.length === 0" class="text-center py-12">
                <p class="text-gray-500 mb-4">No categories yet</p>
               
            </div>
            <CategoryTable 
                v-else
                :categories="categories"       
            />
        </div>
        <CategorySheet
            v-model:is-open="isSheetOpen"
        />
    </AppLayout>
</template>
