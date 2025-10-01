<script setup lang="ts">
import type {
  ColumnDef,
  ColumnFiltersState,
  SortingState,
  VisibilityState,
} from "@tanstack/vue-table"
import {
  FlexRender,
  getCoreRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  useVueTable,
} from "@tanstack/vue-table"
import { ArrowUpDown, ChevronDown, Pen, Trash } from "lucide-vue-next"
import { ref, h } from "vue"
import { valueUpdater, getVisiblePages } from "@/lib/utils"
import { Category } from "@/types"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Badge } from '@/components/ui/badge';
import { colorMap } from '@/constants/colors';
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { useModal } from '@/composables/useModal';
import CategorySheet from './CategorySheet.vue';
import CategoryDeleteDialog from './CategoryDeleteDialog.vue';

const props = defineProps<{
  categories: Category[];
}>();


const isSheetOpen = ref(false);
const editingCategory = ref<Category | null>(null);
const { openModal, modalProps } = useModal<'delete-category', Category>();

const openEditSheet = (category: Category) => {
    editingCategory.value = category;
    isSheetOpen.value = true;
};

const openDeleteModal = (category: Category) => {
    openModal('delete-category', category);
};

const columns: ColumnDef<Category>[] = [
  {
    accessorKey: "name",
    header: ({ column }) => {
      return h(Button, {
        variant: "ghost",
        onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
      }, () => ["Name", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })])
    },
    cell: ({ row }) => h("div", { class: "font-medium" }, row.getValue("name")),
  },
  {
    accessorKey: "color",
    header: "Color",
    cell: ({ row }) => {
      const colorValue = row.getValue("color") as string;
      return h("div", {}, [
        h(Badge, { 
          style: {
            backgroundColor: colorMap[colorValue]?.bg || '#f3f4f6',
            color: colorMap[colorValue]?.text || '#1f2937',
            borderColor: colorMap[colorValue]?.border || '#e5e7eb'
          },
          variant: "secondary" 
        }, colorValue)
      ])
    },
  },
  {
    accessorKey: "created_at",
    header: ({ column }) => {
      return h(Button, {
        variant: "ghost",
        onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
      }, () => ["Created", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })])
    },
    cell: ({ row }) => {
      const date = new Date(row.getValue("created_at"))
      return h("div", { class: "text-sm" }, date.toLocaleDateString())
    },
  },
  {
    id: "actions",
    enableHiding: false,
    cell: ({ row }) => {
      const category = row.original

      return h("div", { class: "flex justify-end gap-2" }, [
        h(Button, {
          size: "sm",
          variant: "ghost",
          onClick: () => openEditSheet(category)
        }, () => [
          h(Pen, { class: "h-4 w-4" })
        ]),
        h(Button, {
          size: "sm",
          variant: "ghost",
          onClick: () => openDeleteModal(category)
        }, () => [
          h(Trash, { class: "h-4 w-4" })
        ])
      ])
    },
  },
]


const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})

const table = useVueTable({
  get data() { return props.categories; },
  columns,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
  onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
  onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
  state: {
    get sorting() { return sorting.value },
    get columnFilters() { return columnFilters.value },
    get columnVisibility() { return columnVisibility.value },
  },
  initialState: {
    pagination: {
      pageSize: 10,
    },
  },
})

</script>

<template>
  <div class="w-full">
    <div class="flex items-center py-4 gap-4">
      <Input
        class="max-w-sm"
        placeholder="Filter categories..."
        :model-value="table.getColumn('name')?.getFilterValue() as string"
        @update:model-value="table.getColumn('name')?.setFilterValue($event)"
      />
      
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
              <FlexRender 
                v-if="!header.isPlaceholder" 
                :render="header.column.columnDef.header" 
                :props="header.getContext()" 
              />
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <template v-if="table.getRowModel().rows?.length">
            <TableRow
              v-for="row in table.getRowModel().rows"
              :key="row.id"
              :data-state="row.getIsSelected() && 'selected'"
            >
              <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
              </TableCell>
            </TableRow>
          </template>
          
          <TableRow v-else>
            <TableCell :colspan="columns.length" class="h-24 text-center">
              No categories found.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
    
    <div class="flex items-center justify-between py-4">
      <div class="text-sm text-muted-foreground">
        {{ table.getFilteredRowModel().rows.length }} total categories
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
              'px-3 py-2 text-xs rounded-md transition-colors',
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
    <CategorySheet
      v-model:is-open="isSheetOpen"
      :category="editingCategory"
    />
    <CategoryDeleteDialog
      v-bind="modalProps('delete-category', 'category')"
    />
  </div>
</template>

