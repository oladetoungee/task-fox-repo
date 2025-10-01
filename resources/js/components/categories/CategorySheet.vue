<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Sheet, SheetContent, SheetDescription, SheetHeader, SheetTitle } from '@/components/ui/sheet';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import InputError from '@/components/InputError.vue';
import { colorMap, getColorOptions } from '@/constants/colors';
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';

const props = defineProps<{
    isOpen: boolean;
    category?: { id: number; name: string; color: string; icon: string; created_at: string } | null;
}>();

const emit = defineEmits<{
    'update:is-open': [value: boolean];
}>();

const colorOptions = getColorOptions();
const form = useForm({ 
    name: '', 
    color: 'gray' 
});


watch(() => props.category, (category) => {
    if (category) {
        form.name = category.name;
        form.color = category.color;
    } else {
        form.reset();
    }
}, { immediate: true });

const submitForm = () => {
    if (props.category) {
        form.put(CategoryController.update.url({ category: props.category.id }), {
            onSuccess: () => {
                emit('update:is-open', false);
                form.reset();
            },
        });
    } else {
        form.post(CategoryController.store.url(), {
            onSuccess: () => {
                emit('update:is-open', false);
                form.reset();
            },
        });
    }
};
</script>

<template>
    <Sheet :open="isOpen" @update:open="$emit('update:is-open', $event)">
        <SheetContent class="p-4">
            <SheetHeader>
                <SheetTitle>{{ category ? 'Edit Category' : 'Create Category' }}</SheetTitle>
                <SheetDescription>
                    {{ category ? 'Update this category to reorganize your tasks.' : 'Add a new category to organize your tasks.' }}
                </SheetDescription>
            </SheetHeader>          
            <form @submit.prevent="submitForm" class="p-4 space-y-4">
                <div class="space-y-2">
                    <Label for="name">Category Name</Label>
                    <Input 
                        id="name" 
                        v-model="form.name" 
                        type="text" 
                        placeholder="Enter category name" 
                    />
                    <InputError :message="form.errors.name" /> 
                </div>
                <div class="space-y-2 w-full">
                    <Label for="color">Color</Label>
                    <Select v-model="form.color">
                        <SelectTrigger class="w-full">
                            <SelectValue>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full" :style="{ backgroundColor: colorMap[form.color].hex }"></div>
                                    {{ colorMap[form.color]?.label }}
                                </div>
                            </SelectValue>
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="color in colorOptions" :key="color.value" :value="color.value">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full" :style="{ backgroundColor: colorMap[color.value].hex }"></div>
                                    {{ color.label }}
                                </div>
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors.color" /> 
                </div>
                <Button type="submit" :disabled="form.processing" class="w-full mt-2">
                    {{ form.processing ? 'Saving...' : (category ? 'Update Category' : 'Create Category') }}
                </Button>
            </form>
        </SheetContent>
    </Sheet>
</template>
