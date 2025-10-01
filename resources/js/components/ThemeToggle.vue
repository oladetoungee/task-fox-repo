<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Moon, Sun } from 'lucide-vue-next';
import { useAppearance } from '@/composables/useAppearance';

const { appearance, updateAppearance } = useAppearance();

const toggleTheme = () => {
    const newTheme = appearance.value === 'dark' ? 'light' : 'dark';
    updateAppearance(newTheme);
};
</script>

<template>
    <Button
        variant="ghost"
        size="icon"
        @click="toggleTheme"
        class="h-9 w-9"
    >
        <Sun class="h-4 w-4 rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
        <Moon class="absolute h-4 w-4 rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" />
        <span class="sr-only">Toggle theme</span>
    </Button>
</template>