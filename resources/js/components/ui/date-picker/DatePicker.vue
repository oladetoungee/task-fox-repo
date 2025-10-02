<script setup lang="ts">
import type { DateValue } from "@internationalized/date"
import {
  DateFormatter,
  getLocalTimeZone,
  parseDate,
  today,
  CalendarDate,
} from "@internationalized/date"
import { CalendarIcon } from "lucide-vue-next"

import { ref, watch, computed } from "vue"
import { cn } from "@/lib/utils"
import { Button } from "@/components/ui/button"
import { Calendar } from "@/components/ui/calendar"
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover"

interface Props {
  value?: Date | null;
  onChange?: (date: Date | null) => void;
  placeholder?: string;
  className?: string;
  disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  placeholder: 'Pick a date',
  className: '',
  disabled: false
});

const emit = defineEmits<{
  change: [date: Date | null];
}>();

const df = new DateFormatter("en-US", {
  dateStyle: "long",
})

// Convert Date to DateValue for internal use
const dateValue = ref<DateValue | undefined>(undefined);

// Watch for external value changes
watch(() => props.value, (newValue) => {
  if (newValue) {
    const year = newValue.getFullYear();
    const month = newValue.getMonth() + 1;
    const day = newValue.getDate();
    dateValue.value = parseDate(`${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`);
  } else {
    dateValue.value = undefined;
  }
}, { immediate: true });

// Handle date selection
const handleDateSelect = (selectedDate: DateValue | undefined) => {
  dateValue.value = selectedDate;
  
  if (selectedDate) {
    const date = selectedDate.toDate(getLocalTimeZone());
    emit('change', date);
    if (props.onChange) {
      props.onChange(date);
    }
  } else {
    emit('change', null);
    if (props.onChange) {
      props.onChange(null);
    }
  }
};
</script>

<template>
  <Popover>
    <PopoverTrigger as-child>
      <Button
        variant="outline"
        :class="cn(
          'w-full justify-start text-left font-normal',
          !dateValue && 'text-muted-foreground',
          props.className
        )"
        :disabled="props.disabled"
      >
        <CalendarIcon class="mr-2 h-4 w-4" />
        {{ dateValue ? df.format(dateValue.toDate(getLocalTimeZone())) : props.placeholder }}
      </Button>
    </PopoverTrigger>
    <PopoverContent class="w-auto p-0">
      <Calendar 
        @update:model-value="handleDateSelect"
        initial-focus 
      />
    </PopoverContent>
  </Popover>
</template>