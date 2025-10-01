import { ref } from 'vue'

export function useCSVExport() {
  const isExporting = ref(false)

  const exportToCSV = (data: any[], filename: string, headers: string[], mapper: (item: any) => string[]) => {
    isExporting.value = true
    
    try {
      const csvContent = [
        headers.join(','),
        ...data.map(item => mapper(item))
      ].join('\n')
      
      const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' })
      const link = document.createElement('a')
      const url = URL.createObjectURL(blob)
      link.setAttribute('href', url)
      link.setAttribute('download', filename)
      link.style.visibility = 'hidden'
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
      URL.revokeObjectURL(url)
    } catch (error) {
      console.error('CSV export failed:', error)
    } finally {
      isExporting.value = false
    }
  }

  const exportTasksToCSV = (tasks: any[], filename?: string) => {
    const headers = ['Title', 'Description', 'Due Date', 'Status', 'Categories', 'Created At']
    const defaultFilename = `tasks-${new Date().toISOString().split('T')[0]}.csv`
    
    const mapper = (task: any) => {
      const categories = task.categories?.map((cat: any) => cat.name || cat.label).join('; ') || 'None'
      const dueDate = task.due_date ? new Date(task.due_date).toLocaleDateString() : 'No due date'
      const createdDate = new Date(task.created_at).toLocaleDateString()
      
      return [
        `"${task.title}"`,
        `"${task.description || 'No description'}"`,
        `"${dueDate}"`,
        `"${task.status}"`,
        `"${categories}"`,
        `"${createdDate}"`
      ]
    }
    
    exportToCSV(tasks, filename || defaultFilename, headers, mapper)
  }

  return {
    isExporting,
    exportToCSV,
    exportTasksToCSV
  }
}
