// Helper function to check if task is due/urgent
export const dueTask = (dueDate: string | null) => {
  if (!dueDate) return false
  
  const now = new Date()
  const due = new Date(dueDate)
  const diffInHours = (due.getTime() - now.getTime()) / (1000 * 60 * 60)
  
  if (diffInHours < 0 || diffInHours <= 24 || diffInHours <= 48) return true
  
  return false
}

// Helper function to format dates like "25th Sept 2025"
export const formatDate = (date: Date) => {
  const day = date.getDate()
  const month = date.toLocaleDateString('en-US', { month: 'short' })
  const year = date.getFullYear()
  
  // Add ordinal suffix (st, nd, rd, th)
  const getOrdinalSuffix = (day: number) => {
    if (day > 3 && day < 21) return 'th'
    switch (day % 10) {
      case 1: return 'st'
      case 2: return 'nd'
      case 3: return 'rd'
      default: return 'th'
    }
  }
  
  return `${day}${getOrdinalSuffix(day)} ${month} ${year}`
}