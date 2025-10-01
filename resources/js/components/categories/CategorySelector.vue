<script setup lang="ts">
import { ref, onMounted, watch, computed } from 'vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button'; // New import
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'; // New imports
import { ChevronDown } from 'lucide-vue-next'; // New import
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
const open = ref(false); 

watch(selectedCategories, (newCategories) => {
    props.onUpdate(newCategories);
}, { deep: true });


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
};

const isSelected = (category: Category) => {
  return selectedCategories.value.some(c => c.id === category.id);
};

const getTriggerText = computed(() => {
    if (selectedCategories.value.length === 0) {
        return 'Select categories...';
    }
    const count = selectedCategories.value.length;
    const names = selectedCategories.value.slice(0, 2).map(c => c.name).join(', ');
    return count > 2 ? `${names}, +${count - 2} more` : names;
});
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

    <Popover v-model:open="open">
      <PopoverTrigger as-child>
        <Button variant="outline" class="w-full justify-between">
          {{ getTriggerText }}
          <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
        </Button>
      </PopoverTrigger>
      
      <PopoverContent class="w-[200px] p-1 max-h-[300px] overflow-y-auto">
        <div class="space-y-1">
            <div v-for="category in availableCategories" :key="category.id"
                class="flex items-center space-x-2 p-1 text-xs border rounded-lg cursor-pointer transition-all duration-100 ease-in-out" 
                :class="{ 'opacity-50': isSelected(category) }"
                :style="{
                    backgroundColor: isSelected(category) ? (colorMap[category.color]?.bg || '#f3f4f6') : 'transparent',
                    color: colorMap[category.color]?.text || '#1f2937',
                    borderColor: colorMap[category.color]?.border || '#e5e7eb',
                }" 
                @click="toggleCategory(category)">
                <span class="font-medium">{{ category.name }}</span>
            </div>
        </div>
      </PopoverContent>
    </Popover>
  </div>
</template>