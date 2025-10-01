
import type { ColumnDef } from "@tanstack/vue-table"
import { ArrowUpDown, MoreHorizontal } from "lucide-vue-next"
import { h } from "vue"
import { Task, Category } from "@/types"
import { colorMap } from '@/constants/colors'
import { Button } from "@/components/ui/button"
import { Checkbox } from "@/components/ui/checkbox"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuTrigger,
  DropdownMenuItem,
} from "@/components/ui/dropdown-menu"

interface TaskActions {
  viewTask: (task: Task) => void;
  editTask: (task: Task) => void;
  deleteTask: (task: Task) => void;
}
export const createTaskColumns = (actions: TaskActions): ColumnDef<Task>[] => [
  {
    id: "select",
    header: ({ table }) => h(Checkbox, {
      "modelValue": table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && "indeterminate"),
      "onUpdate:modelValue": value => table.toggleAllPageRowsSelected(!!value),
      "ariaLabel": "Select all",
    }),
    cell: ({ row }) => h(Checkbox, {
      "modelValue": row.getIsSelected(),
      "onUpdate:modelValue": value => row.toggleSelected(!!value),
      "ariaLabel": "Select row",
    }),
    enableSorting: false,
    enableHiding: false,
  },
  {
    accessorKey: "title",
    header: ({ column }) => {
      return h(Button, {
        variant: "ghost",
        onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
      }, () => ["Title", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })])
    },
    cell: ({ row }) => h("div", { class: "font-medium" }, row.getValue("title")),
  },
  {
    accessorKey: "description",
    header: "Description",
    cell: ({ row }) => {
      const description = row.getValue("description") as string
      return h("div", { class: "max-w-[200px] truncate" }, description || "No description")
    },
  },
  {
    accessorKey: "due_date",
    header: ({ column }) => {
      return h(Button, {
        variant: "ghost",
        onClick: () => column.toggleSorting(column.getIsSorted() === "asc"),
      }, () => ["Due Date", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })])
    },
    cell: ({ row }) => {
      const dueDate = row.getValue("due_date") as string | null
      if (!dueDate) return h("div", { class: "text-muted-foreground" }, "No due date")
      const date = new Date(dueDate)
      return h("div", { class: "text-sm" }, date.toLocaleDateString())
    },
  },
  {
    accessorKey: "categories",
    header: "Categories",
    filterFn: (row, columnId, filterValue) => {
      if (!filterValue || filterValue.length === 0) return true
      
      const taskCategories = row.getValue('categories') as Category[] || []
      const taskCategoryIds = taskCategories.map((cat: Category) => cat.id)
      
      return filterValue.some((selectedId: number) => taskCategoryIds.includes(selectedId))
    },
    cell: ({ row }) => {
      const categories = row.getValue("categories") as any[] | null
      
      if (!categories?.length) {
        return h("div", { class: "text-muted-foreground" }, "No categories")
      }
      
      return h("div", { class: "flex flex-wrap gap-1" }, 
        categories.map(category => h("span", { 
          style: {
            backgroundColor: colorMap[category.color]?.bg || '#f3f4f6',
            color: colorMap[category.color]?.text || '#1f2937',
            fontSize: '8px',
            padding: '0.25rem',
            borderRadius: '0.5rem'
          }
        }, category.name))
      )
    },
  },
  {
    accessorKey: "status",
    header: "Status",
    filterFn: (row, columnId, filterValue) => {
      if (!filterValue) return true
      const status = row.getValue(columnId) as string
      return status === filterValue
    },
    cell: ({ row }) => {
      const status = row.getValue("status") as string
      const isComplete = status === 'complete'
      return h("div", { class: "flex items-center space-x-2" }, [
        h("div", {
          class: `w-2 h-2 rounded-full ${isComplete ? 'bg-green-500' : 'bg-yellow-500'}`
        }),
        h("span", { class: "text-sm capitalize" }, status)
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
      const task = row.original

      return h("div", { class: "flex items-center justify-center" }, [
        h(DropdownMenu, {}, {
          default: () => [
            h(DropdownMenuTrigger, { asChild: true }, {
              default: () => h(Button, {
                variant: "ghost",
                size: "sm",
                class: "h-8 w-8 p-0"
              }, {
                default: () => h(MoreHorizontal, { class: "h-4 w-4" })
              })
            }),
            h(DropdownMenuContent, { align: "end" }, {
              default: () => [
                h(DropdownMenuItem, {
                  onClick: () => actions.viewTask(task)
                }, "View"),
                h(DropdownMenuItem, {
                  onClick: () => actions.editTask(task)
                }, "Update"),
                h(DropdownMenuItem, {
                  onClick: () => actions.deleteTask(task),
                  class: "text-red-600 focus:text-red-600"
                }, "Delete")
              ]
            })
          ]
        })
      ])
    },
  },
]
