# Task Fox - Project Documentation

## Table of Contents

1. [Project Overview](#project-overview)
2. [System Architecture](#system-architecture)
3. [Technical Stack](#technical-stack)
4. [System Decisions](#system-decisions)
5. [Technical Decisions](#technical-decisions)
6. [Database Schema](#database-schema)
7. [API Endpoints](#api-endpoints)
8. [Development Setup](#development-setup)
9. [Project Structure](#project-structure)

---

## Project Overview

**Task Fox** is a modern, full-stack task management application built with Laravel and Vue.js. The application provides users with a comprehensive solution for organizing, categorizing, and tracking their tasks with an intuitive and responsive user interface.

### Core Features

- **Task Management**: Create, read, update, and delete tasks with comprehensive details
- **Category System**: Sophisticated categorization with color coding and visual indicators
- **Due Date Tracking**: Visual urgency indicators for overdue and upcoming tasks
- **User Authentication**: Secure user registration, login, and session management
- **Responsive Design**: Mobile-first approach with modern UI components
- **Data Export**: CSV export functionality for task data
- **Advanced Filtering**: Multi-criteria filtering and sorting capabilities
- **Real-time Interface**: Dynamic, reactive UI with instant updates
- **SEO Optimized**: Comprehensive meta tags for search engines and social media sharing

### SEO Implementation

Task Fox includes comprehensive SEO optimization to improve search engine visibility and social media sharing:

#### Meta Tags Included:
- **Basic SEO**: Title, description, keywords, author, robots directives
- **Open Graph Protocol**: Facebook and social media sharing optimization
- **Twitter Cards**: Enhanced Twitter sharing with large image previews
- **Mobile Optimization**: Theme colors, app capability tags, and responsive viewport settings
- **Canonical URLs**: Proper URL canonicalization for SEO

#### Social Media Features:
- Rich previews when sharing on Facebook, Twitter, and LinkedIn
- Optimized descriptions and imagery for social platforms
- Proper site attribution and branding

#### Technical SEO:
- Semantic HTML structure with proper heading hierarchy
- Mobile-first responsive design
- Fast loading times with Vite optimization
- Progressive Web App capabilities

### Target Users

- Individual professionals managing personal and work tasks
- Users seeking a modern, intuitive alternative to traditional task management tools

---

## System Architecture

Task Fox follows a modern full-stack architecture pattern with clear separation of concerns:

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend       │    │   Database      │
│   (Vue.js)      │◄──►│   (Laravel)     │◄──►│   (SQLite)      │
│                 │    │                 │    │                 │
│ • Vue 3         │    │ • Laravel 12    │    │ • Migrations    │
│ • TypeScript    │    │ • Inertia.js    │    │ • Seeders       │
│ • Tailwind CSS  │    │ • Fortify Auth  │    │ • Relationships │
│ • Tanstack Table│    │ • Eloquent ORM  │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

### Architecture Layers

#### 1. Presentation Layer (Frontend)
- **Vue.js 3 Components**: Reactive, composable UI components
- **TypeScript**: Type-safe development with enhanced IDE support
- **Inertia.js**: Server-side rendering with SPA-like experience
- **Tailwind CSS**: Utility-first styling framework
- **Tanstack Vue Table**: Advanced data table functionality

#### 2. Application Layer (Backend)
- **Laravel Controllers**: Request handling and business logic
- **Eloquent Models**: Object-relational mapping and data relationships
- **Middleware**: Authentication, authorization, and request filtering
- **Policies**: Fine-grained authorization controls
- **Form Requests**: Input validation and sanitization

#### 3. Data Layer
- **SQLite Database**: Lightweight, file-based database solution
- **Eloquent Relationships**: Many-to-many task-category associations
- **Migration System**: Version-controlled database schema changes
- **Database Seeders**: Sample data generation and initial setup

### Communication Flow

1. **User Interaction**: User interacts with Vue.js components
2. **Inertia Request**: Frontend sends requests through Inertia.js
3. **Laravel Processing**: Controllers handle requests, validate data, and interact with models
4. **Database Operations**: Eloquent ORM manages database interactions
5. **Response Rendering**: Inertia.js renders responses back to Vue components

---

## Technical Stack

### Backend Technologies

#### Core Framework
- **Laravel 12.0**: Latest PHP framework with advanced features
- **PHP 8.2+**: Modern PHP with improved performance and syntax

#### Authentication & Authorization
- **Laravel Fortify 1.30**: Headless authentication backend
- **Laravel Policies**: Model-based authorization system
- **Session-based Authentication**: Secure user session management

#### Database & ORM
- **SQLite**: Lightweight, embedded database
- **Eloquent ORM**: Laravel's built-in object-relational mapping
- **Database Migrations**: Version-controlled schema management
- **Model Relationships**: Many-to-many associations between tasks and categories

#### Additional Laravel Packages
- **Laravel Tinker**: Interactive REPL for debugging
- **Laravel Wayfinder**: Route management and generation
- **Inertia.js Laravel Adapter**: Server-side integration

### Frontend Technologies

#### Core Framework
- **Vue.js 3.5.13**: Progressive JavaScript framework with Composition API
- **TypeScript 5.2.2**: Static type checking and enhanced development experience
- **Inertia.js**: Modern monolith architecture for SPAs

#### UI Framework & Styling
- **Tailwind CSS 4.1.1**: Utility-first CSS framework
- **Reka UI 2.5.1**: Vue component library for modern interfaces
- **Lucide Vue Next**: Icon library with Vue 3 support
- **Class Variance Authority**: Dynamic class name generation

#### Data Management & Tables
- **Tanstack Vue Table 8.21.3**: Powerful data table solution
- **VueUse Core 12.8.2**: Vue composition utilities
- **Zod 4.1.11**: TypeScript-first schema validation

#### Development Tools
- **Vite 7.0.4**: Fast build tool and dev server
- **Vue TSC**: TypeScript checker for Vue components
- **ESLint**: Code linting and formatting
- **Prettier**: Code formatting and style consistency

#### Additional Libraries
- **Date-fns 4.1.0**: Modern date utility library
- **Clsx & Tailwind Merge**: Dynamic class name utilities
- **Axios**: HTTP client for API requests

### Development & Build Tools

#### Build System
- **Vite**: Lightning-fast build tool with HMR
- **Laravel Vite Plugin**: Laravel integration for Vite
- **TypeScript Compiler**: Type checking and compilation

#### Code Quality
- **ESLint with TypeScript**: Linting for TypeScript and Vue
- **Prettier**: Consistent code formatting
- **PHP CS Fixer (Pint)**: PHP code style fixing

#### Testing Framework
- **Pest PHP**: Modern PHP testing framework
- **Pest Laravel Plugin**: Laravel-specific testing utilities
- **Mockery**: PHP mocking framework

---

## System Decisions

### 1. Monolithic Architecture with Modern Frontend

**Decision**: Use Laravel as a monolithic backend with Vue.js frontend connected via Inertia.js

**Rationale**:
- Simplified deployment and development workflow
- Leverages Laravel's mature ecosystem and conventions
- Inertia.js provides SPA experience without API complexity
- Single codebase for easier maintenance

**Trade-offs**:
- Less flexibility for future microservices architecture
- Frontend and backend are more tightly coupled
- Requires full-stack developers familiar with both technologies

### 2. SQLite Database Choice

**Decision**: Use SQLite as the primary database

**Rationale**:
- Zero-configuration setup for development
- Sufficient for single-user or small-team applications
- File-based storage simplifies backup and deployment
- Excellent for prototyping and development phases

**Trade-offs**:
- Limited concurrent write capabilities
- May require migration to PostgreSQL/MySQL for high-scale production
- Fewer advanced database features compared to full RDBMS

### 3. Many-to-Many Category Relationship

**Decision**: Implement categories as a separate entity with many-to-many relationship to tasks

**Rationale**:
- Enables sophisticated categorization with multiple categories per task
- Allows for category-specific metadata (colors, icons, user ownership)
- Supports advanced filtering and organization features
- Provides foundation for future category analytics

**Implementation**:
- Separate `categories` table with user ownership
- Pivot table `task_categories` for relationships
- Migration system to handle data evolution from simple to complex categorization

### 4. Server-Side Rendering with Inertia.js

**Decision**: Use Inertia.js for server-side rendering instead of traditional API + SPA approach

**Rationale**:
- Maintains Laravel's routing and controller patterns
- Reduces complexity of maintaining separate API endpoints
- Provides better SEO and initial page load performance
- Simplifies authentication and CSRF protection

**Benefits**:
- Single application structure
- Shared validation rules between frontend and backend
- Simplified state management

---

## Technical Decisions

### 1. TypeScript Implementation

**Decision**: Full TypeScript adoption for frontend development

**Implementation**:
```typescript
// Type-safe interfaces for core entities
export interface Task {
    id: number;
    title: string;
    description: string;
    due_date: string | null;
    categories: Category[] | null;
    status: 'incomplete' | 'complete';
    created_at: string;
    updated_at: string;
}

export interface Category {
    id: number;
    name: string;
    color: string;
    icon: string;
    created_at: string;
    updated_at?: string;
}
```

**Benefits**:
- Compile-time error detection
- Enhanced IDE support with autocomplete
- Better refactoring capabilities
- Documentation through type definitions

### 2. Component-Based UI Architecture

**Decision**: Atomic design principles with reusable Vue components

**Structure**:
```
components/
├── ui/                  # Base UI components (buttons, inputs, etc.)
├── tasks/              # Task-specific components
│   ├── TasksTable.vue
│   ├── TaskSheet.vue
│   └── columns.ts
├── categories/         # Category management components
└── layouts/           # Page layout components
```

**Rationale**:
- Promotes code reusability and consistency
- Easier testing and maintenance
- Clear separation of concerns
- Scalable component hierarchy

### 3. Advanced Table Implementation

**Decision**: Use Tanstack Vue Table for data display and manipulation

**Features Implemented**:
- Column-based filtering (status, categories)
- Multi-column sorting
- Pagination with customizable page sizes
- Column visibility controls
- Export functionality (CSV)

**Implementation Highlights**:
```typescript
// Dynamic column definitions with actions
export const createTaskColumns = (actions: TaskActions): ColumnDef<Task>[] => [
  // Urgency indicator column
  {
    id: "urgency",
    header: "",
    cell: ({ row }) => {
      const dueDate = row.getValue("due_date") as string | null
      if (dueTask(dueDate)) {
        return h("div", { 
          class: "w-3 h-3 bg-red-500 rounded-full animate-pulse",
          title: "Task is urgent (overdue or due within 2 days)"
        })
      }
      return h("div", { class: "w-3 h-3" }) 
    },
  },
  // ... other columns
]
```

### 4. State Management Strategy

**Decision**: Leverage Vue 3 Composition API with Inertia.js shared data

**Approach**:
- Use `useForm` from Inertia for form state management
- Reactive references for component-level state
- Shared data through Inertia props for global state
- Custom composables for reusable logic

**Example**:
```typescript
// Composable for modal management
export const useModal = <T extends string, D = any>() => {
  const currentModal = ref<T | null>(null)
  const modalData = ref<D | null>(null)
  
  const openModal = (type: T, data?: D) => {
    currentModal.value = type
    modalData.value = data ?? null
  }
  
  // ... modal management logic
}
```

### 5. Date Handling and Urgency System

**Decision**: Custom date utilities with visual urgency indicators

**Implementation**:
```typescript
// Urgency calculation
export const dueTask = (dueDate: string | null) => {
  if (!dueDate) return false
  
  const now = new Date()
  const due = new Date(dueDate)
  const diffInHours = (due.getTime() - now.getTime()) / (1000 * 60 * 60)
  
  // Mark as urgent if overdue or due within 48 hours
  return diffInHours < 0 || diffInHours <= 48
}

// Consistent date formatting
export const formatDate = (date: Date) => {
  const day = date.getDate()
  const month = date.toLocaleDateString('en-US', { month: 'short' })
  const year = date.getFullYear()
  
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
```

### 6. Color System and Category Management

**Decision**: Predefined color palette with consistent theming

**Implementation**:
```typescript
// Centralized color management
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
  // ... other colors
}
```

**Benefits**:
- Consistent visual design across the application
- Easy theme modifications
- Accessible color combinations
- Type-safe color usage

---

## Database Schema

### Tables Overview

#### 1. Users Table
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    two_factor_secret TEXT NULL,
    two_factor_recovery_codes TEXT NULL,
    two_factor_confirmed_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    current_team_id BIGINT NULL,
    profile_photo_path VARCHAR(2048) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### 2. Tasks Table
```sql
CREATE TABLE tasks (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    due_date DATETIME NULL,
    status ENUM('incomplete', 'complete') DEFAULT 'incomplete',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### 3. Categories Table
```sql
CREATE TABLE categories (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    unique_id VARCHAR(255) NOT NULL,
    color VARCHAR(50) DEFAULT 'gray',
    icon VARCHAR(50) DEFAULT 'tag',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_category (user_id, name)
);
```

#### 4. Task Categories Pivot Table
```sql
CREATE TABLE task_categories (
    task_id BIGINT NOT NULL,
    category_id BIGINT NOT NULL,
    PRIMARY KEY (task_id, category_id),
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_task_category (task_id, category_id)
);
```

### Relationships

- **Users ↔ Categories**: One-to-Many (User owns multiple categories)
- **Tasks ↔ Categories**: Many-to-Many (Tasks can have multiple categories, categories can be assigned to multiple tasks)
- **Users ↔ Tasks**: Implicit relationship through category ownership

---

## API Endpoints

### Authentication Routes
```php
// Handled by Laravel Fortify
POST   /login           # User authentication
POST   /logout          # User logout
POST   /register        # User registration
POST   /password/email  # Password reset request
POST   /password/reset  # Password reset confirmation
```

### Task Management Routes
```php
GET    /tasks           # List all tasks (with categories)
GET    /tasks/create    # Show create task form
POST   /tasks           # Store new task
GET    /tasks/{task}    # View specific task
GET    /tasks/{task}/edit # Show edit task form
PUT    /tasks/{task}    # Update specific task
DELETE /tasks/{task}    # Delete specific task
```

### Category Management Routes
```php
GET    /categories              # List user's categories
GET    /categories/create       # Show create category form
POST   /categories              # Store new category
GET    /categories/{category}/edit # Show edit category form
PUT    /categories/{category}   # Update specific category
DELETE /categories/{category}   # Delete specific category

# API endpoint for frontend data fetching
GET    /api/categories          # JSON response of user's categories
```

---

## Development Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm/yarn
- Git

### Installation Steps

1. **Clone Repository**
```bash
git clone <repository-url>
cd task-fox
```

2. **Backend Setup**
```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# (Optional) Seed database with sample data
php artisan db:seed
```

3. **Frontend Setup**
```bash
# Install Node.js dependencies
npm install

# Build frontend assets
npm run build

# For development with hot reload
npm run dev
```

4. **Start Development Server**
```bash
php artisan serve
```

### Development Commands

```bash
# Frontend development
npm run dev          # Start Vite dev server with HMR
npm run build        # Build for production
npm run format       # Format code with Prettier
npm run lint         # Lint code with ESLint

# Backend development
php artisan serve    # Start Laravel development server
php artisan migrate  # Run new migrations
php artisan tinker   # Interactive REPL
```

---

## Project Structure

```
task-fox/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TaskController.php
│   │   │   ├── CategoryController.php
│   │   │   └── Controller.php
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── Task.php
│   │   ├── Category.php
│   │   └── User.php
│   └── Policies/
│       └── CategoryPolicy.php
├── database/
│   ├── migrations/
│   │   ├── 2025_09_28_151627_create_tasks_table.php
│   │   ├── 2025_09_29_181739_create_categories_table.php
│   │   └── 2025_09_29_181742_create_task_categories_table.php
│   └── seeders/
│       ├── CategorySeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   ├── ui/              # Reusable UI components
│   │   │   ├── tasks/           # Task-related components
│   │   │   │   ├── TasksTable.vue
│   │   │   │   ├── TaskSheet.vue
│   │   │   │   └── columns.ts
│   │   │   └── categories/      # Category components
│   │   ├── pages/               # Inertia.js pages
│   │   │   ├── tasks/
│   │   │   └── categories/
│   │   ├── types/
│   │   │   └── index.d.ts       # TypeScript type definitions
│   │   ├── lib/
│   │   │   ├── utils.ts
│   │   │   └── dateUtils.ts
│   │   ├── constants/
│   │   │   └── colors.ts
│   │   └── app.ts              # Main application entry
│   └── css/
│       └── app.css             # Tailwind CSS imports
├── routes/
│   ├── web.php                 # Web routes
│   ├── auth.php               # Authentication routes
│   └── settings.php           # Settings routes
├── config/                    # Laravel configuration files
├── composer.json              # PHP dependencies
├── package.json               # Node.js dependencies
├── vite.config.ts            # Vite configuration
├── tsconfig.json             # TypeScript configuration
└── tailwind.config.js        # Tailwind CSS configuration
```

---

This documentation provides a comprehensive overview of the Task Fox project, covering its architecture, technical decisions, and implementation details. The project demonstrates modern web development practices with a focus on type safety, user experience, and maintainable code structure.