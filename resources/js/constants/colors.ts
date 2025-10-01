// Define our color map with all needed properties
export const colorMap: Record<string, { 
  label: string, 
  hex: string, 
  bg: string, 
  text: string, 
  border: string 
}> = {
    gray: { 
      label: 'Gray',
      hex: '#6b7280', 
      bg: '#f3f4f6', 
      text: '#1f2937', 
      border: '#e5e7eb' 
    },
    red: { 
      label: 'Red',
      hex: '#ef4444', 
      bg: '#fee2e2', 
      text: '#991b1b', 
      border: '#fecaca' 
    },
    orange: { 
      label: 'Orange',
      hex: '#f97316', 
      bg: '#ffedd5', 
      text: '#9a3412', 
      border: '#fed7aa' 
    },
    yellow: { 
      label: 'Yellow',
      hex: '#eab308', 
      bg: '#fef9c3', 
      text: '#854d0e', 
      border: '#fef08a' 
    },
    green: { 
      label: 'Green',
      hex: '#22c55e', 
      bg: '#dcfce7', 
      text: '#166534', 
      border: '#bbf7d0' 
    },
    blue: { 
      label: 'Blue',
      hex: '#3b82f6', 
      bg: '#dbeafe', 
      text: '#1e40af', 
      border: '#bfdbfe' 
    },
    purple: { 
      label: 'Purple',
      hex: '#a855f7', 
      bg: '#f3e8ff', 
      text: '#6b21a8', 
      border: '#e9d5ff' 
    },
    pink: { 
      label: 'Pink',
      hex: '#ec4899', 
      bg: '#fce7f3', 
      text: '#9d174d', 
      border: '#fbcfe8' 
    },
    cyan: { 
      label: 'Cyan',
      hex: '#06b6d4', 
      bg: '#cffafe', 
      text: '#155e75', 
      border: '#a5f3fc' 
    },
};

// Helper method to get an array of color options for dropdowns
export const getColorOptions = () => Object.entries(colorMap).map(([value, data]) => ({
  value,
  ...data
}));

// Type for color keys (e.g., 'red', 'blue', etc.)
export type ColorValue = keyof typeof colorMap;
