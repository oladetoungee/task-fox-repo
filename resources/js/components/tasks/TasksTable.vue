<script setup lang="ts">
import type {
  ColumnFiltersState,
  ExpandedState,
  SortingState,
  VisibilityState,
} from "@tanstack/vue-table"
import {
  FlexRender,
  getCoreRowModel,
  getExpandedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  useVueTable,
} from "@tanstack/vue-table"
import { ChevronDown, Filter } from "lucide-vue-next"
import { ref } from "vue"
import { valueUpdater, getVisiblePages } from "@/lib/utils"
import { Task, Category } from "@/types"
import { Button } from "@/components/ui/button"
import { Checkbox } from "@/components/ui/checkbox"
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import { Input } from "@/components/ui/input"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { useModal } from "@/composables/useModal"
import { useCSVExport } from "@/composables/useCSVExport"
import DeleteConfirmationDialog from "@/components/DeleteConfirmationDialog.vue"
import { createTaskColumns } from '@/components/tasks/columns'


const props = defineProps<{ 
  tasks: Task[];
  onViewTask?: (task: Task) => void;
  onEditTask?: (task: Task) => void;
  onDeleteTask?: (task: Task) => void;
}>();

const emit = defineEmits<{
  'view-task': [task: Task];
  'edit-task': [task: Task];
  'delete-task': [task: Task];
}>()

const { openModal, modalProps } = useModal<'delete-task', Task>()
const { exportTasksToCSV } = useCSVExport()
const selectedStatus = ref<'all' | 'complete' | 'incomplete'>('all')
const selectedCategories = ref<number[]>([])
const availableCategories = ref<Category[]>([])
const fetchCategories = async () => {
  try {
    const response = await fetch('/api/categories')
    availableCategories.value = await response.json()
  } catch (error) {
    console.error('Failed to fetch categories:', error)
  }
}

fetchCategories()
const handleViewTask = (task: Task) => {
  if (props.onViewTask) {
    props.onViewTask(task);
  } else {
    emit('view-task', task);
  }
}

const handleEditTask = (task: Task) => {
  if (props.onEditTask) {
    props.onEditTask(task);
  } else {
    emit('edit-task', task);
  }
}

const handleDeleteTask = (task: Task) => {
  if (props.onDeleteTask) {
    props.onDeleteTask(task);
  } else {
    emit('delete-task', task);
    openModal('delete-task', task);
  }
}

const columns = createTaskColumns({
  viewTask: handleViewTask,
  editTask: handleEditTask,
  deleteTask: handleDeleteTask
})

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const expanded = ref<ExpandedState>({})

const table = useVueTable({
  get data() { return props.tasks; },
  columns,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  getExpandedRowModel: getExpandedRowModel(),
  onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
  onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
  onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
  onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
  state: {
    get sorting() { return sorting.value },
    get columnFilters() { return columnFilters.value },
    get columnVisibility() { return columnVisibility.value },
    get expanded() { return expanded.value },
  },
})


const updateCategoryFilter = () => {
  table.getColumn('categories')?.setFilterValue(selectedCategories.value)
}
const updateStatusFilter = () => {
  if (selectedStatus.value === 'all') {
    table.getColumn('status')?.setFilterValue('')
  } else {
    table.getColumn('status')?.setFilterValue(selectedStatus.value)
  }
}

const handleExportCSV = () => {
  const rows = table.getFilteredRowModel().rows
  const tasks = rows.map(row => row.original)
  exportTasksToCSV(tasks)
}
</script>

<template>
  <div class="w-full">
    <div class="flex items-center justify-between py-4 border-b">
      <div class="flex space-x-1">
        <button
          v-for="tab in [
            { key: 'all', label: 'All' },
            { key: 'incomplete', label: 'Pending' },
            { key: 'complete', label: 'Completed' }
          ]"
          :key="tab.key"
          @click="selectedStatus = tab.key as typeof selectedStatus; updateStatusFilter()"
          :class="[
            'px-4 py-2 text-sm font-medium transition-colors',
            selectedStatus === tab.key 
              ? 'text-orange-600 underline' 
              : 'text-muted-foreground hover:text-foreground'
          ]"
        >
          {{ tab.label }}
        </button>
      </div>
      <button
        @click="handleExportCSV"
        class="text-muted-foreground hover:text-foreground underline cursor-pointer text-xs"
      >
        Export as CSV
      </button>
    </div>

    <div class="flex items-center py-4 gap-4">
       <Input
         class="max-w-sm py-1"
         placeholder="Filter tasks..."
         :model-value="table.getColumn('title')?.getFilterValue() as string"
         @update:model-value=" table.getColumn('title')?.setFilterValue($event)"
       />
    </div>
    
    <div class="flex items-center py-2 gap-4">
       <DropdownMenu>
         <DropdownMenuTrigger as-child>
           <Button variant="outline" class="flex items-center gap-2">
             <Filter class="h-4 w-4" />
             Categories
             <ChevronDown class="h-4 w-4" />
             <span v-if="selectedCategories.length > 0" class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
               {{ selectedCategories.length }}
             </span>
           </Button>
         </DropdownMenuTrigger>
         <DropdownMenuContent align="start" class="w-80">
           <div class="p-3">
             <div class="text-sm font-medium mb-3">Filter by Categories</div>
             <div class="flex flex-wrap gap-2">
               <label
                 v-for="category in availableCategories"
                 :key="category.id"
                 class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-2 rounded-md"
               >
                 <Checkbox
                   :model-value="selectedCategories.includes(category.id)"
                   @update:model-value="(checked) => {
                     if (checked) {
                       selectedCategories.push(category.id)
                     } else {
                       selectedCategories.splice(selectedCategories.indexOf(category.id), 1)
                     }
                     updateCategoryFilter()
                   }"
                 />
                 <span class="text-sm">{{ category.name }}</span>
               </label>
             </div>
             <div v-if="selectedCategories.length > 0" class="mt-3 pt-3 border-t">
               <Button
                 variant="ghost"
                 size="sm"
                 @click="selectedCategories = []; updateCategoryFilter()"
                 class="text-xs"
               >
                 Clear all
               </Button>
             </div>
           </div>
         </DropdownMenuContent>
       </DropdownMenu>
       
      <DropdownMenu>
        <DropdownMenuTrigger as-child>
          <Button variant="outline" class="ml-auto">
            Columns <ChevronDown class="ml-2 h-4 w-4" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuCheckboxItem
            v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
            :key="column.id"
            class="capitalize"
            :model-value="column.getIsVisible()"
            @update:model-value="(value) => {
              column.toggleVisibility(!!value)
            }"
          >
            {{ column.id }}
          </DropdownMenuCheckboxItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
    <div class="rounded-md border">
      <Table>
        <TableHeader>
          <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
            <TableHead v-for="header in headerGroup.headers" :key="header.id">
              <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody class="text-xs">
          <template v-if="table.getRowModel().rows?.length">
            <template v-for="row in table.getRowModel().rows" :key="row.id">
              <TableRow>
                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                  <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                </TableCell>
              </TableRow>
              <TableRow v-if="row.getIsExpanded()">
                <TableCell :colspan="row.getAllCells().length">
                  {{ JSON.stringify(row.original) }}
                </TableCell>
              </TableRow>
            </template>
          </template>

          <TableRow v-else>
            <TableCell
              :colspan="columns.length"
              class="h-24 text-center"
            >
              No results.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>

    <div class="flex items-center justify-between py-4">
      <div class="text-sm text-muted-foreground">
        Showing {{ table.getFilteredRowModel().rows.length }} task(s).
      </div>
      <div class="flex items-center space-x-1">
        <button
          :disabled="!table.getCanPreviousPage()"
          @click="table.previousPage()"
          class="px-3 py-2 text-sm text-muted-foreground hover:text-foreground disabled:opacity-50 disabled:cursor-not-allowed"
        >
          Previous
        </button>
        <template v-for="page in getVisiblePages(table.getState().pagination.pageIndex + 1, table.getPageCount())" :key="page">
          <button
            v-if="typeof page === 'number'"
            @click="table.setPageIndex(page - 1)"
            :class="[
              'px-3 py-2 text-sm rounded-md transition-colors',
              table.getState().pagination.pageIndex + 1 === page
                ? 'bg-background border border-border text-foreground'
                : 'text-muted-foreground hover:text-foreground'
            ]"
          >
            {{ page }}
          </button>
          <span v-else class="px-3 py-2 text-sm text-muted-foreground">...</span>
        </template>
        <button
          :disabled="!table.getCanNextPage()"
          @click="table.nextPage()"
          class="px-3 py-2 text-sm text-muted-foreground hover:text-foreground disabled:opacity-50 disabled:cursor-not-allowed"
        >
          Next
        </button>
      </div>
    </div>
    <DeleteConfirmationDialog
      v-bind="modalProps('delete-task', 'task')"
    />
  </div>
</template>