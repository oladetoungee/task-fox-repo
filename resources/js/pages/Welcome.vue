<script setup lang="ts">
import { login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import tasks from '@/routes/tasks';
</script>

<template>
    <Head title="Minimal Layout Test" />
    
    <div class="flex min-h-screen flex-col items-center bg-background p-6 text-foreground ">
        
        <header class="w-full max-w-4xl pb-4 mb-4">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="tasks.index()"
                    class="inline-block rounded-sm border border-muted-foreground px-5 py-1.5 text-sm leading-normal text-foreground hover:border-foreground transition-colors duration-200"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="login()"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-foreground hover:border-muted-foreground transition-colors duration-200"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="register()"
                        class="inline-block rounded-sm border-1 border-border px-5 py-1.5 text-sm leading-normal text-foreground hover:bg-muted/10 transition-colors duration-200"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>
        
        <main class="w-full max-w-4xl flex items-center justify-center p-12 rounded-lg shadow-2xl m-auto bg-gradient-to-br  from-[#FF6E00]/20 to-[#FF6E00]/5 ">
          <div class="flex flex-col items-center justify-center h-full p-8 animate-fade-in-up" style="animation-delay: 0.3s">
                        <div class="relative mb-8">
                            <AppLogoIcon class="w-24 h-24 text-[#FF6E00] animate-bounce" style="animation-duration: 2s; animation-iteration-count: infinite;" />
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-[#FF6E00] rounded-full animate-ping opacity-75"></div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-foreground mb-4 animate-fade-in-up" style="animation-delay: 0.6s">
                            Welcome to TaskFox
                        </h3>
                        
                        <div class="flex flex-col items-center space-y-4 animate-fade-in-up" style="animation-delay: 0.9s">
                            <div class="flex items-center space-x-2 text-foreground/80">
                                <div class="w-2 h-2 bg-[#FF6E00] rounded-full animate-pulse"></div>
                                <span class="text-sm">Smart Task Management</span>
                            </div>
                            <div class="flex items-center space-x-2 text-foreground/80">
                                <div class="w-2 h-2 bg-[#FF6E00] rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
                                <span class="text-sm">Priority Tracking</span>
                            </div>
                            <div class="flex items-center space-x-2 text-foreground/80">
                                <div class="w-2 h-2 bg-[#FF6E00] rounded-full animate-pulse" style="animation-delay: 1s"></div>
                                <span class="text-sm">Deadline Management</span>
                            </div>
                        </div>
                    </div>
        </main>

    </div>
</template>

