<script setup lang="ts">

import NavMain from '@/components/NavMain.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import tasks from '@/routes/tasks';
import categories from '@/routes/categories';
import { edit } from '@/routes/profile';
import { type NavItem } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { LayoutGrid, LogOut, Tag, Settings } from 'lucide-vue-next';
import { logout } from '@/routes';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import UserInfo from '@/components/UserInfo.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: tasks.index(),
        icon: LayoutGrid,
    },
    // {
    //     title: 'Tasks',
    //     href: tasks.index(),
    //     icon: Plus,
    // },
    {
        title: 'Categories',
        href: categories.index(),
        icon: Tag,
    },
    {
        title: 'Settings',
        href: edit(),
        icon: Settings,
    },
];
const handleLogout = () => {
    router.flushAll();
};

</script>

<template>
    <Sidebar collapsible="icon" variant="inset" class="border-r-2 border-sidebar-border">
        <SidebarHeader >
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child class="flex flex-col items-center justify-center p-4 mb-2">
                        <Link :href="dashboard()" class="hover:bg-transparent hover:text-inherit">
                        <div class="mb-1 flex h-9 w-9 items-center justify-center rounded-md">
                            <AppLogoIcon class="size-9 fill-current text-[var(--foreground)] dark:text-white" />
                        </div>
                        </Link>
                        <div class="text-sm text-center group-data-[collapsible=icon]:hidden">Welcome to TaskFox</div>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>
        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>
        <SidebarFooter>
      
            <div class="mt-2">
                <Link
                    :href="logout()"
                    @click="handleLogout"
                    class="flex items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-accent hover:text-accent-foreground w-full"
                    data-test="logout-button"
                >
                    <LogOut class="h-4 w-4" />
                    <span class="group-data-[collapsible=icon]:hidden">Log out</span>
                </Link>
            </div>
            <div class="flex items-center gap-2 rounded-md px-3 py-2 text-sm">
                <UserInfo :user="user" />
            </div>
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
