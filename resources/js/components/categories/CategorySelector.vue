<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Category } from '@/types';
import axios from 'axios';
import { colorMap } from '@/constants/colors';

interface Props {
  selectedCategories?: Category[] | null;
  onUpdate: (categories: Category[]) => void;
}

const props = defineProps<Props>();

const availableCategories = ref<Category[]>([]);
const selectedCategories = ref<Category[]>(props.selectedCategories || []);

onMounted(async () => {
  try {
    const response = await axios.get('/api/categories');
    availableCategories.value = response.data;
  } catch (error) {
    console.error('Failed to fetch categories:', error);
  }
});

const toggleCategory = (category: Category) => {
  const index = selectedCategories.value.findIndex(c => c.id === category.id);
  if (index > -1) {
    selectedCategories.value.splice(index, 1);
  } else {
    selectedCategories.value.push(category);
  }
  props.onUpdate(selectedCategories.value);
};

const isSelected = (category: Category) => {
  return selectedCategories.value.some(c => c.id === category.id);
};


</script>

<template>
  <div class="space-y-4">
    <div v-if="selectedCategories.length > 0" class="flex flex-wrap gap-2">
      <Badge v-for="category in selectedCategories" :key="category.id" variant="secondary" :style="{
        backgroundColor: colorMap[category.color]?.bg || '#f3f4f6',
        color: colorMap[category.color]?.text || '#1f2937',
        borderColor: colorMap[category.color]?.border || '#e5e7eb'
      }">
        {{ category.name }}
      </Badge>
    </div>

    <div v-for="category in availableCategories" :key="category.id"
      class="flex items-center space-x-2 p-1 text-xs border rounded-lg cursor-pointer hover:opacity-80" :style="{
        backgroundColor: colorMap[category.color]?.bg || '#f3f4f6',
        color: colorMap[category.color]?.text || '#1f2937',
        borderColor: colorMap[category.color]?.border || '#e5e7eb',
        opacity: isSelected(category) ? '0.5' : '1'

      }" @click="toggleCategory(category)">
      <span>{{ category.name }}</span>
    </div>


  </div>
</template>
